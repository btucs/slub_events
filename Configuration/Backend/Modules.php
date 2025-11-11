<?php

return [
    'web_Slub.SlubEventsSlubevents' => [
        'parent' => 'web',
        'access' => 'user',
        'labels' => 'LLL:EXT:slub_events/Resources/Private/Language/locallang_slubevents.xlf',
        'extensionName' => 'Slub.SlubEvents',
        'controllerActions' => [
            \Slub\SlubEvents\Controller\Backend\EventController::class => [
                'beList',
                'beCopy',
                'beIcsInvitation',
            ],
            \Slub\SlubEvents\Controller\Backend\SubscriberController::class => [
                'beList',
                'beOnlineSurvey',
                'beWriteNotification',
                'beSendNotification',
            ],
        ],
    ],
];
