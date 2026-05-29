<?php
declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Slub\SlubEvents\Controller\EventController;
use Slub\SlubEvents\Controller\SubscriberController;
use Slub\SlubEvents\Controller\CategoryController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Slub\SlubEvents\Slots\HookPreProcessing;
use Slub\SlubEvents\Slots\HookPostProcessing;
use Slub\SlubEvents\Task\CheckeventsTask;
use Slub\SlubEvents\Task\CheckeventsTaskAdditionalFieldProvider;
use Slub\SlubEvents\Task\StatisticsTask;
use Slub\SlubEvents\Task\StatisticsTaskAdditionalFieldProvider;
use Slub\SlubEvents\Task\CleanUpTask;
use Slub\SlubEvents\Task\CleanUpTaskAdditionalFieldProvider;
use Slub\SlubEvents\Helper\Form\Element\RecurringOptionsElement;
use Slub\SlubEvents\Helper\Form\Element\RecurringEventsElement;
use Slub\SlubEvents\Helper\Form\Element\RecurringParentElement;
use Slub\SlubEvents\Updates\FileLocationUpdater;

defined('TYPO3') || die();

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventlist',
    [
        EventController::class => 'list, new, update, create, delete, printCal, ajax',
    ],
    // non-cacheable actions
    [
        EventController::class => 'new, update, create, delete, ajax',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventlistupcoming',
    [
        EventController::class => 'listUpcoming',
    ],
    // non-cacheable actions
    [
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventlistmonth',
    [
        EventController::class => 'listMonth',
    ],
    // non-cacheable actions
    [
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventshow',
    [
        EventController::class => 'show, showNotFound',
    ],
    // non-cacheable actions
    [
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventsubscribecreate',
    [
        SubscriberController::class => 'new, create, eventNotFound',
    ],
    // non-cacheable actions
    [
        SubscriberController::class => 'new, create',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventsubscribedelete',
    [
        SubscriberController::class => 'delete, eventNotFound, subscriberNotFound',
    ],
    // non-cacheable actions
    [
        SubscriberController::class => 'delete',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventuserpanel',
    [
        EventController::class      => 'listOwn, show',
        SubscriberController::class => 'list, show',
    ],
    // non-cacheable actions
    [
        EventController::class => 'listOwn',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventgeniusbarcontactlist',
    [
        CategoryController::class => 'contactList, list, gbList',
    ],
    // non-cacheable actions
    [
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Eventgeniusbarcategorylist',
    [
        CategoryController::class => 'list, gbList, contactList',
    ],
    // non-cacheable actions
    [
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Apieventlist',
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'list',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'list',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'SlubEvents',
    'Apieventlistuser',
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'listUser',
    ],
    // non-cacheable actions
    [
        \Slub\SlubEvents\Controller\Api\EventController::class => 'listUser',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Custom cache for category
if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['slubevents_category'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['slubevents_category'] = [];
}

/**
 * Set storagePid by default to detect not configured page tree sections
 */
ExtensionManagementUtility::addTypoScriptSetup('
    plugin.tx_slubevents.persistence.storagePid =
    module.tx_slubevents.persistence.storagePid < plugin.tx_slubevents.persistence.storagePid
');

## EXTENSION BUILDER DEFAULTS END TOKEN -
# Everything BEFORE this line is overwritten with the defaults of the extension builder

/***************************************************************
 * Backend module
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
    HookPreProcessing::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] =
    HookPostProcessing::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] =
    HookPostProcessing::class;

$languageDir = 'slub_events/Resources/Private/Language/';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][CheckeventsTask::class] = [
    'extension'        => 'slub_events',
    'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.checkevents.name',
    'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.checkevents.description',
    'additionalFields' => CheckeventsTaskAdditionalFieldProvider::class
];
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][StatisticsTask::class] = [
    'extension'        => 'slub_events',
    'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.statistics.name',
    'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.statistics.description',
    'additionalFields' => StatisticsTaskAdditionalFieldProvider::class
];
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][CleanUpTask::class] = [
    'extension'        => 'slub_events',
    'title'            => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.cleanup.name',
    'description'      => 'LLL:EXT:' . $languageDir . 'locallang.xlf:tasks.cleanup.description',
    'additionalFields' => CleanUpTaskAdditionalFieldProvider::class
];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1600698292] = [
    'nodeName' => 'recurringOptions',
    'priority' => 40,
    'class' => RecurringOptionsElement::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1600701794] = [
    'nodeName' => 'recurringEvents',
    'priority' => 40,
    'class' => RecurringEventsElement::class
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1600702566] = [
    'nodeName' => 'recurringParent',
    'priority' => 40,
    'class' => RecurringParentElement::class
];

// register update wizard
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['slubEventsFileLocationUpdater']
    = FileLocationUpdater::class;
