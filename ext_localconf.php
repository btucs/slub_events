<?php
defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventlist',
    [
        \Slub\SlubEvents\Controller\EventController::class => 'list, new, update, create, delete, printCal, ajax',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\EventController::class => 'new, update, create, delete, ajax',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventlistupcoming',
    [
        \Slub\SlubEvents\Controller\EventController::class => 'listUpcoming',
    ],
    // non-cacheable actions
    [
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventlistmonth',
    [
        \Slub\SlubEvents\Controller\EventController::class => 'listMonth',
    ],
    // non-cacheable actions
    [
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventshow',
    [
        \Slub\SlubEvents\Controller\EventController::class => 'show, showNotFound',
    ],
    // non-cacheable actions
    [
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventsubscribecreate',
    [
        \Slub\SlubEvents\Controller\SubscriberController::class => 'new, create, eventNotFound',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\SubscriberController::class => 'new, create',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventsubscribedelete',
    [
        \Slub\SlubEvents\Controller\SubscriberController::class => 'delete, eventNotFound, subscriberNotFound',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\SubscriberController::class => 'delete',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventuserpanel',
    [
        \Slub\SlubEvents\Controller\EventController::class      => 'listOwn, show',
        \Slub\SlubEvents\Controller\SubscriberController::class => 'list, show',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\EventController::class => 'listOwn',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventgeniusbarcontactlist',
    [
        \Slub\SlubEvents\Controller\CategoryController::class => 'contactList, list, gbList',
    ],
    // non-cacheable actions
    [
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventgeniusbarcategorylist',
    [
        \Slub\SlubEvents\Controller\CategoryController::class => 'list, gbList, contactList',
    ],
    // non-cacheable actions
    [
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Apieventlist',
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'list',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'list',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Apieventlistuser',
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'listUser',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'listUser',
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Custom cache for category
if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['slubevents_category'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['slubevents_category'] = [];
}

/**
 * Set storagePid by default to detect not configured page tree sections
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
    plugin.tx_slubevents.persistence.storagePid =
    module.tx_slubevents.persistence.storagePid < plugin.tx_slubevents.persistence.storagePid
');

## EXTENSION BUILDER DEFAULTS END TOKEN -
# Everything BEFORE this line is overwritten with the defaults of the extension builder

/***************************************************************
 * Backend module
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
    Slub\SlubEvents\Slots\HookPreProcessing::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
    Slub\SlubEvents\Slots\HookPostProcessing::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
    Slub\SlubEvents\Slots\HookPostProcessing::class;

$languageDir = 'slub_events/Resources/Private/Language/';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Slub\SlubEvents\Task\CheckeventsTask::class] = [
    'extension'        => 'slub_events',
    'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.checkevents.name',
    'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.checkevents.description',
    'additionalFields' => Slub\SlubEvents\Task\CheckeventsTaskAdditionalFieldProvider::class
];
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Slub\SlubEvents\Task\StatisticsTask::class] = [
    'extension'        => 'slub_events',
    'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.statistics.name',
    'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.statistics.description',
    'additionalFields' => Slub\SlubEvents\Task\StatisticsTaskAdditionalFieldProvider::class
];
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Slub\SlubEvents\Task\CleanUpTask::class] = [
    'extension'        => 'slub_events',
    'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.cleanup.name',
    'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.cleanup.description',
    'additionalFields' => Slub\SlubEvents\Task\CleanUpTaskAdditionalFieldProvider::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1600698292] = [
    'nodeName' => 'recurringOptions',
    'priority' => 40,
    'class' => Slub\SlubEvents\Helper\Form\Element\RecurringOptionsElement::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1600701794] = [
    'nodeName' => 'recurringEvents',
    'priority' => 40,
    'class' => Slub\SlubEvents\Helper\Form\Element\RecurringEventsElement::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1600702566] = [
    'nodeName' => 'recurringParent',
    'priority' => 40,
    'class' => Slub\SlubEvents\Helper\Form\Element\RecurringParentElement::class
];

// register update wizard
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['slubEventsFileLocationUpdater']
    = Slub\SlubEvents\Updates\FileLocationUpdater::class;
