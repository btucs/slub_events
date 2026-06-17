<?php
namespace Slub\SlubEvents\Helper\Form\Element;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020 Alexander Bigga <typo3@slub-dresden.de>
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

use DateTimeImmutable;
use Slub\SlubEvents\Utility\DateFormattingUtility;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class RecurringOptionsElement extends AbstractFormElement
{
    #[\Override]
    public function render(): array
    {
        // Custom TCA properties and other data can be found in $this->data, for example the above
        // parameters are available in $this->data['parameterArray']['fieldConf']['config']['parameters']
        $result = $this->initializeResultArray();

        $serializedRecurringOptions = (string)($this->data['parameterArray']['itemFormElValue'] ?? '');
        $recurring_options = $serializedRecurringOptions !== ''
          ? unserialize($serializedRecurringOptions, ['allowed_classes' => false])
          : [];
        if (!is_array($recurring_options)) {
          $recurring_options = [];
        }

        $startDateTime = DateFormattingUtility::resolveDateTime($this->data['databaseRow']['start_date_time']);

        $week = $this->buildWeekdayLabels();
        $startWeekday = $startDateTime instanceof \DateTimeImmutable ? (int)$startDateTime->format('N') : 0;
        $fieldChangeAttributes = GeneralUtility::implodeAttributes(
          $this->getOnFieldChangeAttrs('click', $this->data['parameterArray']['fieldChangeFunc'] ?? []),
          true
        );

        $formField = '';

        // Weekday Settings ------
        if (!is_array($recurring_options['weekday'] ?? null)) {
            // initialize empty array if new recurring settings
            $recurring_options['weekday'] = [];
        }
        $formField .= '<h4>'. LocalizationUtility::translate(
            'tx_slubevents_domain_model_event.recurring_options.interval.days',
            'SlubEvents').'</h4>';
        $formField .= '<div class="btn-group" data-toggle="buttons">';

        for ($i=1; $i<8; $i++) {
          $disabled = FALSE;
            if ($startWeekday === $i) {
              $active = 'active';
              $checked = 'checked="checked"';
              $disabled = TRUE;
          } elseif (in_array($i, $recurring_options['weekday'], true)) {
              $active = 'active';
              $checked = 'checked="checked"';
          } else {
            $active = '';
            $checked = '';
          }
          $formField .= '<label for="weekday-'.$i.'" class="btn btn-primary '.$active.' '.($disabled ? 'disabled' : '').'">';

          if ($disabled) {
              // send the current value as hidden field and show the checkbox as disabled to the user
             $formField .= '<input type="hidden" name="' . $this->data['parameterArray']['itemFormElName'] . '[weekday][]" value="' . $i . '" />';
          }
          $formField .= '<input type="checkbox" name="' . $this->data['parameterArray']['itemFormElName'] . '[weekday][]"';
          $formField .= ' value="' . $i . '" ' . $checked;
          if ($disabled) {
              $formField .= ' readonly disabled';
          }
            if ($fieldChangeAttributes !== '') {
              $formField .= ' ' . $fieldChangeAttributes;
            }
          $formField .= ' />';
          $formField .= $week[$i] . '</label>';
        }
        $formField .= '</div>';

        // Interval Settings ------
        if (empty($recurring_options['interval'])) {
            // initialize empty array if new recurring settings
            $recurring_options['interval'] = 'weekly';
        }
        $formField .= '<h4>'. LocalizationUtility::translate(
            'tx_slubevents_domain_model_event.recurring_options.interval',
            'SlubEvents').'</h4>';
        $formField .= '<div class="btn-group" data-toggle="buttons">';

        // ---weekly
        if ($recurring_options['interval'] == 'weekly') {
          $active = 'active';
          $checked = 'checked="checked"';
        } else {
          $active = '';
          $checked = '';
        }
        $formField .= '<label for="interval-weekly" class="btn btn-primary '.$active.'">';
        $formField .= '<input type="radio" id="interval-weekly" name="' . $this->data['parameterArray']['itemFormElName'] . '[interval]"';
        $formField .= ' value="weekly" '.$checked;
        if ($fieldChangeAttributes !== '') {
          $formField .= ' ' . $fieldChangeAttributes;
        }
        $formField .= ' />';
        $formField .= LocalizationUtility::translate(
            'tx_slubevents_domain_model_event.recurring_options.interval.weekly',
            'SlubEvents') . '</label>';

        // --- 2weekly
        if ($recurring_options['interval'] == '2weekly') {
          $active = 'active';
          $checked = 'checked="checked"';
        } else {
          $active = '';
          $checked = '';
        }
        $formField .= '<label for="interval-2weekly" class="btn btn-primary '.$active.'">';
        $formField .= '<input type="radio" id="interval-2weekly" name="' . $this->data['parameterArray']['itemFormElName'] . '[interval]"';
        $formField .= ' value="2weekly" '.$checked;
        if ($fieldChangeAttributes !== '') {
          $formField .= ' ' . $fieldChangeAttributes;
        }
        $formField .= ' />';
        $formField .= LocalizationUtility::translate(
            'tx_slubevents_domain_model_event.recurring_options.interval.2weekly',
            'SlubEvents') . '</label>';

        // --- 4weekly
        if ($recurring_options['interval'] == '4weekly') {
          $active = 'active';
          $checked = 'checked="checked"';
        } else {
          $active = '';
          $checked = '';
        }
        $formField .= '<label for="interval-4weekly" class="btn btn-primary '.$active.'">';
        $formField .= '<input type="radio" id="interval-4weekly" name="' . $this->data['parameterArray']['itemFormElName'] . '[interval]"';
        $formField .= ' value="4weekly" '.$checked;
        if ($fieldChangeAttributes !== '') {
          $formField .= ' ' . $fieldChangeAttributes;
        }
        $formField .= ' />';
        $formField .= LocalizationUtility::translate(
            'tx_slubevents_domain_model_event.recurring_options.interval.4weekly',
            'SlubEvents') . '</label>';

        // --- monthly
        if ($recurring_options['interval'] == 'monthly') {
          $active = 'active';
          $checked = 'checked="checked"';
        } else {
          $active = '';
          $checked = '';
        }
        $formField .= '<label for="interval-monthly" class="btn btn-primary '.$active.'">';
        $formField .= '<input type="radio" id="interval-monthly" name="' . $this->data['parameterArray']['itemFormElName'] . '[interval]"';
        $formField .= ' value="monthly" '.$checked;
        if ($fieldChangeAttributes !== '') {
          $formField .= ' ' . $fieldChangeAttributes;
        }
        $formField .= ' />';
        $formField .= LocalizationUtility::translate(
            'tx_slubevents_domain_model_event.recurring_options.interval.monthly',
            'SlubEvents') . '</label>';

        // --- yearly
        if ($recurring_options['interval'] == 'yearly') {
          $active = 'active';
          $checked = 'checked="checked"';
        } else {
          $active = '';
          $checked = '';
        }
        $formField .= '<label for="interval-yearly" class="btn btn-primary '.$active.'">';
        $formField .= '<input type="radio" id="interval-yearly" name="' . $this->data['parameterArray']['itemFormElName'] . '[interval]"';
        $formField .= ' value="yearly" '.$checked;
        if ($fieldChangeAttributes !== '') {
          $formField .= ' ' . $fieldChangeAttributes;
        }
        $formField .= ' />';
        $formField .= LocalizationUtility::translate(
            'tx_slubevents_domain_model_event.recurring_options.interval.yearly',
            'SlubEvents') . '</label>';
        $formField .= '</div>';

        $result['html'] = $formField;

        return $result;
    }

      private function buildWeekdayLabels(): array
      {
        $weekStart = new DateTimeImmutable('monday this week');
        $labels = [];

        for ($i = 0; $i < 7; $i++) {
          $labels[$i + 1] = DateFormattingUtility::formatPattern(
            $weekStart->modify('+' . $i . ' days'),
            'EEEE',
            null,
            'l'
          );
        }

        return $labels;
      }
}
