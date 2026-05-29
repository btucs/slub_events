<?php

declare(strict_types=1);

use Slub\SlubEvents\Controller\Backend\EventController;
use Slub\SlubEvents\Controller\Backend\SubscriberController;

return [
    'web_SlubEvents' => [
        'parent' => 'web',
        'access' => 'user',
        'labels' => 'LLL:EXT:slub_events/Resources/Private/Language/locallang_slubevents.xlf',
        'extensionName' => 'SlubEvents',
        'controllerActions' => [
            EventController::class => [
                'beList',
                'beCopy',
                'beIcsInvitation',
            ],
            SubscriberController::class => [
                'beList',
                'beOnlineSurvey',
                'beWriteNotification',
                'beSendNotification',
            ],
        ],
    ],
];
