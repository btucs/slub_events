<?php
defined('TYPO3') || die();

/***************************************************************
 * Plugin Eventlist
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventlist',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.list_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventlistupcoming
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventlistupcoming',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.list_view_upcoming'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventlistmonth
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventlistmonth',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.list_month_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventshow
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventshow',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.single_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventsubscribecreate
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventsubscribecreate',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.subscribe_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventsubscribedelete
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventsubscribedelete',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.unsubscribe_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventuserpanel
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventuserpanel',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.userpanel_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventgeniusbarcontactlist
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventgeniusbarcontactlist',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.contact_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);

/***************************************************************
 * Plugin Eventgeniusbarcategorylist
 */
$pluginSignature = \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SlubEvents',
    'Eventgeniusbarcategorylist',
    'LLL:EXT:slub_events/Resources/Private/Language/locallang_be.xlf:flexforms.knowledgebar_view'
);

[, $pluginName] = explode('_', $pluginSignature);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,pages,recursive,', $pluginSignature, 'after:subheader');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
  '*',
  'FILE:EXT:slub_events/Configuration/FlexForms/flexform_' . $pluginName . '.xml',
  $pluginSignature,
);
