<?php
namespace Slub\SlubEvents\Slots;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Bigga <typo3@slub-dresden.de>
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use DateTimeZone;
use Slub\SlubEvents\Utility\DateFormattingUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This hook extends the tcemain class.
 * It preselects the author field with the current be_user id.
 *
 * @author    Alexander Bigga <typo3@slub-dresden.de>
 */
class HookPreProcessing
{
    /**
     * Array of flash messages (params) array[][status,title,message]
     *
     * @var array
     */
    protected $messages = [];

    protected ?string $locale = null;
    public function __construct(private readonly FlashMessageService $flashMessageService)
    {
    }

    /**
     * initializeAction
     *
     * @return
     */
    protected function initialize()
    {
        $language = $GLOBALS['BE_USER']->uc['lang'] ?? null;
        $this->locale = match ($language) {
            'de' => 'de_DE',
            'en' => 'en_GB',
            default => $language,
        };
    }

    /**
     * This method is called by a hook in the TYPO3 Core Engine (TCEmain)
     * when a record is saved.
     * We use it to disable saving of the current record if it has
     * categories assigned that are not allowed for the BE user.
     *
     * @param    array  $fieldArray : The field names and their values to be processed (passed by reference)
     * @param    string $table      : The table TCEmain is currently processing
     * @param    string $id         : The records id (if any)
     * @param    object $pObj       : Reference to the parent object (TCEmain)
     *
     * @return    void
     * @access public
     */
    public function processDatamap_preProcessFieldArray(&$fieldArray, $table, $id, &$pObj): void
    {
        if ($table == 'tx_slubevents_domain_model_event') { // prevent moving of categories into their rootline

            // fieldArray only contains the hidden field, if you click on the lamp
            // fieldArray is complete, if you edit the tceform
            // as start_date_time is a required field, we take it to compare these two cases:
            if (empty($fieldArray['start_date_time'])) {
                return;
            }

            $this->initialize();

            if (empty($fieldArray['genius_bar'])) {
                $this->messages[] = [
                    ContextualFeedbackSeverity::OK,
                    'OK',
                    'Veranstaltung gespeichert: "' . $fieldArray['title'] . '" am ' . $this->gmstrftime(
                        $fieldArray['start_date_time']) . '.'
                ];
            } else {
                $message_text = 'Wissensbar-Veranstaltung gespeichert: ';
                $category_text = '';
                // most time the category field is something like
                // 5|Literatur%20finden%3A%20Recherchestr...,11|Spezielle%20Datenbanken%3A%20Normen,12|Thematische%20Recherche
                // but in some cases it's:
                // 5,11,12
                foreach (explode(',', (string) $fieldArray['categories']) as $category) {
                    $catarray = explode('|', $category);
                    if ($catarray && count($catarray) > 1) {
                        $category_text .= urldecode($catarray[1]) . ', ';
                    }
                }
                if ($category_text !== '' && $category_text !== '0') {
                    // get away last ', ' and add formating:
                    $category_text = '"' . substr($category_text, 0, strlen($category_text) - 2) . '"';
                }
                $message_text .= ($category_text !== '' ? $category_text . ' ' : '') . 'am ' . $this->gmstrftime(
                        $fieldArray['start_date_time']) . '.';
                $this->messages[] = [
                    ContextualFeedbackSeverity::OK,
                    'OK',
                    $message_text
                ];
            }

            if ($fieldArray['start_date_time'] > $fieldArray['end_date_time'] && $fieldArray['end_date_time'] > 0) {
                $this->messages[] = [
                    ContextualFeedbackSeverity::ERROR,
                    'Fehler: Ende der Veranstaltung',
                    'Ende (' . $this->gmstrftime(
                        $fieldArray['end_date_time']) . ') liegt vor dem Start (' . $this->gmstrftime(
                        $fieldArray['start_date_time']) . ')'
                ];
            }

            // use the select box value to calculate the end_date_time relative to start_date_time
            if (!empty($fieldArray['end_date_time_select'])) {
                $fieldArray['end_date_time'] = $this->calculateEndDateTime($fieldArray['start_date_time'], $fieldArray['end_date_time_select']);
                unset($fieldArray['end_date_time_select']);
                $this->messages[] = [
                    ContextualFeedbackSeverity::INFO,
                    'Bitte prüfen:',
                    'Ende der Veranstaltung gesetzt auf ' . $this->gmstrftime($fieldArray['end_date_time'])
                ];
            } elseif (empty($fieldArray['end_date_time'])) {
                $fieldArray['end_date_time'] = 0;
            }

            $minSubscriber = (int)($fieldArray['min_subscriber'] ?? 0);
            $maxSubscriber = (int)($fieldArray['max_subscriber'] ?? 0);
            $fieldArray['min_subscriber'] = $minSubscriber;
            $fieldArray['max_subscriber'] = $maxSubscriber;

            // touch the subscribtion end only if minimum subscribers are set
            if ($minSubscriber > 0 || $maxSubscriber > 0) {
                $startDateTimestamp = $this->resolveTimestamp($fieldArray['start_date_time'] ?? null);
                $subEndDateTimestamp = $this->resolveTimestamp($fieldArray['sub_end_date_time'] ?? null);

                if ((($startDateTimestamp !== null && $subEndDateTimestamp !== null && $startDateTimestamp < $subEndDateTimestamp) || $minSubscriber > 0 && empty($fieldArray['sub_end_date_time'])) && !empty($fieldArray['sub_end_date_time_select'])) {
                    $fieldArray['sub_end_date_time'] = $this->calculateEndDateTime($fieldArray['start_date_time'], $fieldArray['sub_end_date_time_select'], FALSE);
                    $subEndDateTimestamp = $this->resolveTimestamp($fieldArray['sub_end_date_time']);
                    $this->messages[] = [
                        ContextualFeedbackSeverity::INFO,
                        'Bitte prüfen:',
                        'Ende der Anmeldungsfrist wurde gesetzt auf ' . $this->gmstrftime(
                            $fieldArray['sub_end_date_time'])
                    ];
                }
                unset($fieldArray['sub_end_date_time_select']);

                // warn if subscription deadline is more than 3 days before the event.
                if ($subEndDateTimestamp !== null && $startDateTimestamp !== null && $startDateTimestamp > $subEndDateTimestamp + (3 * 86400)) {
                    $this->messages[] = [
                        ContextualFeedbackSeverity::WARNING,
                        'Bitte prüfen:',
                        'Ende der Anmeldungsfrist ist aktuell gesetzt auf ' . $this->gmstrftime(
                            $fieldArray['sub_end_date_time']) . ' ==> ' . (int)(($startDateTimestamp - $subEndDateTimestamp) / 86400) . ' Tage vorher!'
                    ];
                }

                // if sub_end_date_time has been cleared, it is empty ("") here --> set it to 0.
                if (empty($fieldArray['sub_end_date_time'])) {
                    $fieldArray['sub_end_date_time'] = 0;
                }
            } else {
                unset($fieldArray['sub_end_date_time_select']);
                $fieldArray['sub_end_date_time'] = 0;
            }

            if ($fieldArray['genius_bar'] == false && count(explode(',', (string) $fieldArray['categories'])) > 1) {
                $this->messages[] = [
                    ContextualFeedbackSeverity::INFO,
                    'Bitte prüfen:',
                    'Sie haben ' . count(explode(',', (string) $fieldArray['categories'])) . ' Kategorien ausgewählt. '
                ];
            }

            // force genius bar events with min_ and max_subscriber == 1
            if ($fieldArray['genius_bar'] == true && ($minSubscriber !== 1 || $maxSubscriber !== 1)) {
                $fieldArray['min_subscriber'] = 1;
                $fieldArray['max_subscriber'] = 1;
                $this->messages[] = [
                    ContextualFeedbackSeverity::INFO,
                    'Bitte prüfen:',
                    'Die Mindest- und Maximalteilnehmerzahl beträgt in der Wissensbar immer 1. Dies wurde automatisch korrigiert. '
                ];
            }

            $generatedTitle = $this->buildEventTitleFromContact($fieldArray, $id);
            if ($generatedTitle !== null) {
                $fieldArray['title'] = $generatedTitle;
            }

            $maxNumber = (int)($fieldArray['max_number'] ?? 0);
            if ($maxSubscriber > 0 && $maxNumber === 0) {
                $fieldArray['max_number'] = $maxSubscriber;
            }

            // save recurring options as serialized Array
            if (!empty($fieldArray['recurring_options'])) {
              $fieldArray['recurring_options'] = serialize($fieldArray['recurring_options']);
            }

            $this->generateOutput();
        }
    }

    /**
     * calculate end_date_time from selected time interval
     *
     * @param boolean $add
     *
     * @return end_date_time
     */
    protected function calculateEndDateTime(mixed $startDateTime, mixed $selectedInterval, $add = TRUE)
    {
        // TYPO3 is working with dateTime values instead of unix timestamps in fieldArray
        $sdt = new \DateTime($startDateTime);
        $edt = new \DateTime();
        if ($add === TRUE) {
            $edt = $sdt->add(new \DateInterval("PT" . trim((string) $selectedInterval) . "M"));
        } else {
            $edt = $sdt->sub(new \DateInterval("PT" . trim((string) $selectedInterval) . "M"));
        }
        $endDateTime = $edt->format(\DateTime::ATOM);

        return $endDateTime;
    }

    protected function resolveTimestamp(mixed $time): ?int
    {
        $dateTime = DateFormattingUtility::resolveDateTime($time);

        return $dateTime?->getTimestamp();
    }

    protected function buildEventTitleFromContact(array $fieldArray, mixed $id): ?string
    {
        $currentRecord = is_numeric((string)$id)
            ? BackendUtility::getRecord('tx_slubevents_domain_model_event', (int)$id, 'uid,title,contact,genius_bar')
            : null;

        $isGeniusBar = (bool)($fieldArray['genius_bar'] ?? $currentRecord['genius_bar'] ?? false);
        if (!$isGeniusBar) {
            return null;
        }

        $contactUid = (int)($fieldArray['contact'] ?? $currentRecord['contact'] ?? 0);
        if ($contactUid <= 0) {
            return null;
        }

        $contactRecord = BackendUtility::getRecord('tx_slubevents_domain_model_contact', $contactUid, 'uid,name');
        if (!is_array($contactRecord) || trim((string)($contactRecord['name'] ?? '')) === '') {
            return null;
        }

        return 'Wissensbar ' . trim((string)$contactRecord['name']);
    }

    /**
     * return formated timestring
     *
     *
     * @return string $formatedTimeString
     */
    protected function gmstrftime(mixed $time)
    {
        // TYPO3 is working with dateTime values instead of unix timestamps in fieldArray
        // But on importing data, $time is a Unix timestamp

        $dateTime = DateFormattingUtility::resolveDateTime($time);

        if (!$dateTime instanceof \DateTimeImmutable) {
            return '';
        }

        $utcDateTime = $dateTime->setTimezone(new DateTimeZone('UTC'));

        return DateFormattingUtility::formatPattern(
            $utcDateTime,
            'EEE, dd.MM.yyyy HH:mm:ss',
            $this->locale ?? DateFormattingUtility::getDefaultLocale(),
            'D, d.m.Y H:i:s'
        );
    }

    /**
     * Generates output by using flash messages
     *
     * @return string
     */
    protected function generateOutput() {
        $flashMessages = [];

        foreach ($this->messages as $messageItem) {
            /** @var FlashMessage $flashMessage */
            $flashMessages[] = GeneralUtility::makeInstance(FlashMessage::class, $messageItem[2], $messageItem[1], $messageItem[0]);
        }

        // render flash messages as text on CLI commands like impexp:import
        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = $this->flashMessageService;
        /** @var FlashMessageQueue $defaultFlashMessageQueue */
        $defaultFlashMessageQueue = $flashMessageService->getMessageQueueByIdentifier();

        foreach ($flashMessages as $flashMessage) {
            $defaultFlashMessageQueue->enqueue($flashMessage);
        }
    }
}
