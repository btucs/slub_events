<?php
defined('TYPO3') || die();

// Register static typoscript.
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'slub_events',
    'Configuration/TypoScript',
    'SLUB: Event Registration'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'slub_events',
    'Configuration/TypoScript/FullCalendar',
    'SLUB: Event Registration - FullCalendar support'
);
