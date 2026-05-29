<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

// Register static typoscript.
ExtensionManagementUtility::addStaticFile(
    'slub_events',
    'Configuration/TypoScript',
    'SLUB: Event Registration'
);

ExtensionManagementUtility::addStaticFile(
    'slub_events',
    'Configuration/TypoScript/FullCalendar',
    'SLUB: Event Registration - FullCalendar support'
);
