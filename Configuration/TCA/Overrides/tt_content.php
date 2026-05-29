<?php
declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

/***************************************************************
 * Plugin Eventlist
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventlist',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.list_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventlistupcoming
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventlistupcoming',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.list_view_upcoming'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventlistmonth
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventlistmonth',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.list_month_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventshow
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventshow',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.single_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventsubscribecreate
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventsubscribecreate',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.subscribe_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventsubscribedelete
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventsubscribedelete',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.unsubscribe_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventuserpanel
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventuserpanel',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.userpanel_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventgeniusbarcontactlist
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventgeniusbarcontactlist',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.contact_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventgeniusbarcategorylist
 */
$pluginSignature = ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventgeniusbarcategorylist',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.knowledgebar_view'
);

[, $pluginName] = explode('_', $pluginSignature);
ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);
