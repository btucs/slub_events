<?php
defined('TYPO3') || die();

/***************************************************************
 * Plugin Eventlist
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventlist',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:plugin.Eventlist'
);

$pluginSignature = 'slubevents_eventlist';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:slub_events/Configuration/FlexForms/flexform_eventlist.xml',
    $pluginSignature
);

/***************************************************************
 * Plugin Eventsubscribe
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventsubscribe',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:plugin.Eventsubscribe'
);

$pluginSignature = 'slubevents_eventsubscribe';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:slub_events/Configuration/FlexForms/flexform_eventsubscribe.xml',
    $pluginSignature
);

/***************************************************************
 * Plugin Eventuserpanel
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventuserpanel',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:plugin.Eventuserpanel'
);

$pluginSignature = 'slubevents_eventuserpanel';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:slub_events/Configuration/FlexForms/flexform_eventuserpanel.xml',
    $pluginSignature
);

/***************************************************************
 * Plugin Eventgeniusbar
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventgeniusbar',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:plugin.Eventgeniusbar'
);

$pluginSignature = 'slubevents_eventgeniusbar';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:slub_events/Configuration/FlexForms/flexform_eventgeniusbar.xml',
    $pluginSignature
);
