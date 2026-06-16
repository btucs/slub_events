<?php
namespace Slub\SlubEvents\Controller\Backend;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use Slub\SlubEvents\Domain\Model\Event;
use Slub\SlubEvents\Helper\EmailHelper;
use Slub\SlubEvents\Helper\EventHelper;
use Slub\SlubEvents\Utility\TextUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * @package slub_events
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SubscriberController extends BaseController
{
    public ConfigurationManagerInterface $configurationManager;
    /**
     * action beList
     *
     * @return ResponseInterface
     */
    public function beListAction(): ResponseInterface
    {
        // get data from BE session
        $searchParameter = $this->getSessionData('tx_slubevents');

        // set the startDateStamp
        if (empty($searchParameter['selectedStartDateStamp'])) {
            $searchParameter['selectedStartDateStamp'] = date('Y-m-d');
        }

        // if search was triggered
        $submittedSearchParams = $this->getParametersSafely('searchParameter');
        if (is_array($submittedSearchParams)) {

            $searchParameter = $submittedSearchParams;

            // save session data
            $this->setSessionData('tx_slubevents', $searchParameter);
        }

        // Categories
        // ------------------------------------------------------------------------------------

        // get the categories
        $categories = $this->categoryRepository->findAllTree();
        if(!isset($searchParameter['category'])) {
            $searchParameter['category'] = [];
        }

        // check which categories have been selected
        if (isset($submittedSearchParams['category']) && !is_array($submittedSearchParams['category'])) {
            $allCategories = $this->categoryRepository->findAll()->toArray();
            foreach ($allCategories as $category) {
                $searchParameter['category'][$category->getUid()] = $category->getUid();
            }
        }
        $this->view->assign('categoriesSelected', $searchParameter['category']);

        // Events
        // ------------------------------------------------------------------------------------
        // get the events to show
        $events = $this->eventRepository->findAllByCategoriesAndDate(
            $searchParameter['category'],
            strtotime((string) $searchParameter['selectedStartDateStamp'])
        );


        // Subscribers
        // ------------------------------------------------------------------------------------
        if (count($events->toArray()) > 0) {
            $subscribers = $this->subscriberRepository->findAllByEvents($events);
            $this->view->assign('subscribers', $subscribers);
        } else {
            $this->addFlashMessage('No events found.', 'Error', ContextualFeedbackSeverity::ERROR);
        }

        $this->view->assign('categories', $categories);
        $this->view->assign('events', $events);
        $this->view->assign('selectedStartDateStamp', $searchParameter['selectedStartDateStamp']);
        return $this->htmlResponse();
    }

    /**
     * action beOnlineSurveyAction
     *
     * --> see ics template in Resources/Private/Templates/Email/
     *
     * @param Event   $event
     * @param integer $step
     *
     * @return ResponseInterface
     */
    #[Extbase\IgnoreValidation(['argumentName' => 'event'])]
    public function beOnlineSurveyAction(Event $event, $step = 0): ResponseInterface
    {
        // get the onlineSurveyLink and potential timestamp of last sent
        $onlineSurveyLink = GeneralUtility::trimExplode('|', $event->getOnlinesurvey(), true);

        // set the link to the current object to get access inside the email
        $event->setOnlinesurvey($onlineSurveyLink[0]);

        $emailTextHTML = '';
        if ($step == 0) {
            $variables = [
                'onlineSurveyLink' => $onlineSurveyLink[0],
                'event' => $event,
                'subscriber' => ['name' => '###Name wird automatisch ausgefüllt###']
            ];

            $emailTextHTML = EmailHelper::renderEmailTemplate($this->request, 'OnlineSurvey', $variables, $this->configurationManager);
        }

        if ($step == 1) {
            $helper['now'] = time();
            $helper['description'] = TextUtility::foldline(EmailHelper::html2rest($event->getDescription()));
            $helper['location'] = EventHelper::getLocationNameWithParent($event);
            $helper['locationics'] = TextUtility::foldline($helper['location']);

            $allSubscribers = $event->getSubscribers();
            foreach ($allSubscribers as $uid => $subscriber) {
                EmailHelper::sendTemplateEmail(
                    [$subscriber->getEmail() => $subscriber->getName()],
                    [$event->getContact()->getEmail() => $event->getContact()->getName()],
                    'Online-Umfrage zu ' . $event->getTitle(),
                    'OnlineSurvey',
                    [
                        'event'      => $event,
                        'subscriber' => $subscriber,
                        'helper'     => $helper,
                        'settings'   => $this->settings,
                        'attachCsv'  => false,
                        'attachIcs'  => false,
                    ],
                    $this->request,
                    $this->configurationManager
                );
            }

            // change the onlineSurvey link to see, that we sent it already
            $event->setOnlinesurvey($onlineSurveyLink[0] . '|' . time());
            // we changed the event inside the repository and have to
            // update the repo manually as of TYPO3 6.1
            $this->eventRepository->update($event);
        }

        $this->view->assign('event', $event);

        if (isset($onlineSurveyLink[1])) {
            $this->view->assign('onlineSurveyLastSent', $onlineSurveyLink[1]);
        }

        $this->view->assign('subscribers', $event->getSubscribers());
        $this->view->assign('step', $step);
        $this->view->assign('emailText', $emailTextHTML);
        return $this->htmlResponse();
    }

    /** Shows the form to send an email notification to all subscribers of the given event. */
    public function beWriteNotificationAction(Event $event): ResponseInterface
    {
        $templateVariables = [
            'event' => $event,
            'subscriber' => ['name' => '###Name wird automatisch ausgefüllt###'],
            'emailBody' => '###Text bitte unten eingeben###'
        ];
        $emailTextHTML = EmailHelper::renderEmailTemplate($this->request,'EventNotification', $templateVariables, $this->configurationManager);

        $this->view->assign('event', $event);
        $this->view->assign('emailTextPreview', $emailTextHTML);
        return $this->htmlResponse();
    }

    /** Actually sends the notification email to all subscribers of the given event. */
    public function beSendNotificationAction(Event $event, string $emailSubject, string $emailBody)
    {
        $hasErrors = false;
        if ($emailSubject === '' || $emailSubject === '0') {
            $this->addFlashMessage('Bitte einen Betreff eingeben.', 'Fehler', ContextualFeedbackSeverity::ERROR);
            $hasErrors = true;
        }
        if ($emailBody === '' || $emailBody === '0') {
            $this->addFlashMessage('Bitte einen Text eingeben.', 'Fehler', ContextualFeedbackSeverity::ERROR);
            $hasErrors = true;
        }
        if ($hasErrors) {
            return $this->redirect('beWriteNotification', null, null, [
                'event' => $event,
                'emailSubject' => $emailSubject,
                'emailBody' => $emailBody
            ]);
        }

        $successCount = 0;
        $allSubscribers = $event->getSubscribers();
        foreach ($allSubscribers as $subscriber) {
            $successCount += EmailHelper::sendTemplateEmail(
                [$subscriber->getEmail() => $subscriber->getName()],
                [$event->getContact()->getEmail() => $event->getContact()->getName()],
                $emailSubject,
                'EventNotification',
                [
                    'event'      => $event,
                    'emailBody'  => nl2br($emailBody),
                    'subscriber' => $subscriber,
                    'settings'   => $this->settings,
                ],
                $this->request,
                $this->configurationManager
            );
        }

        $this->addFlashMessage("{$successCount} Rundmails wurde gesendet.", 'Mails gesendet.', ContextualFeedbackSeverity::OK);
        return $this->redirect('beList');
    }
}
