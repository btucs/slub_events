<?php

$LL = 'LLL:EXT:slub_events/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl'      => [
        'title'                    => $LL . 'tx_slubevents_domain_model_event',
        'label'                    => 'title',
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'sortby'                   => 'sorting',
        'versioningWS'             => true,
        'origUid'                  => 't3_origuid',
        'languageField'            => 'sys_language_uid',
        'transOrigPointerField'    => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete'                   => 'deleted',
        'enablecolumns'            => [
            'disabled'  => 'hidden',
            'starttime' => 'starttime',
            'endtime'   => 'endtime',
        ],
        'searchFields'             => 'title,start_date_time,all_day,end_date_time,sub_end_date_time,teaser,description,min_subscriber,max_subscriber,audience,categories,subscribers,location,discipline,topic,',
        'iconfile'                 => 'EXT:slub_events/Resources/Public/Icons/tx_slubevents_domain_model_event.gif',
    ],
    'types'     => [
        // Single event
        '0' => [
            'showitem' => '' .
                          '--div--;Was und Wann,' .
                          'genius_bar,title,' .
                          '--palette--;' . $LL . 'tx_slubevents_domain_model_event.start;paletteStart,' .
                          '--palette--;' . $LL . 'tx_slubevents_domain_model_event.end;paletteEnd,' .
                          'location,' .
                          'teaser,' .
                          'description,' .
                          '--div--;' . $LL . 'tx_slubevents_domain_model_event.content_elements,' .
                          'content_elements,' .
                          'image,' .
                          '--div--;Anmeldebedingungen,' .
                          'contact,' .
                          'external_registration,' .
                          '--palette--;' . $LL . 'tx_slubevents_domain_model_event.subscribers;paletteSubscribers,' .
                          '--palette--;' . $LL . 'tx_slubevents_domain_model_event.sub_end;paletteEndSubscription,' .
                          '--div--;Kategorisierung,' .
                          'audience,' .
                          'categories,' .
                          'discipline,' .
                          'topic,' .
                          '--div--;Angemeldete Teilnehmer,' .
                          'subscribers,' .
                          '--div--;Wiederholung,' .
                          '--palette--;;paletteRecurring,' .
                          '--div--;Extras,' .
                          'hidden, --palette--;;1,' .
                          'onlinesurvey,' .
                          'no_search',
        ],
    ],
    'palettes'  => [
        'paletteStart'           => [
            'showitem' => 'start_date_time,all_day,cancelled',
        ],
        'paletteEnd'             => [
            'showitem' => 'end_date_time_select, --linebreak--, end_date_time',
        ],
        'paletteSubscribers'     => [
            'showitem' => 'min_subscriber,max_subscriber,max_number',
        ],
        'paletteEndSubscription' => [
            'showitem' => 'sub_end_date_time_select, --linebreak--,  sub_end_date_time, sub_end_date_info_sent',
        ],
        'paletteRecurring'       => [
            'showitem'       => 'parent, recurring, --linebreak--, recurring_options, recurring_end_date_time, --linebreak--, recurring_events',
        ],
    ],
    'columns'   => [
        'sys_language_uid'         => [
            'exclude'  => 1,
            'label'    => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config'   => ['type' => 'language'],
            'onChange' => 'reload',
        ],
        'l10n_parent'              => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label'       => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config'      => [
                'type'                => 'select',
                'renderType'          => 'selectSingle',
                'items'               => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table'       => 'tx_slubevents_domain_model_event',
                'foreign_table_where' => 'AND tx_slubevents_domain_model_event.pid=###CURRENT_PID### AND tx_slubevents_domain_model_event.sys_language_uid IN (-1,0)',
                'default'             => 0,
            ],
        ],
        'l10n_diffsource'          => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label'              => [
            'label'  => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max'  => 255,
            ],
        ],
        'hidden'                   => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config'  => [
                'type'       => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'starttime'                => [
            'exclude'   => 1,
            'l10n_mode' => 'exclude',
            'label'     => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config'    => [
                'behaviour'  => [
                    'allowLanguageSynchronization' => true
                ],
                'type'       => 'datetime',
                'size'       => 13,
                'default'    => 0,
            ],
        ],
        'endtime'                  => [
            'exclude'   => 1,
            'l10n_mode' => 'exclude',
            'label'     => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config'    => [
                'behaviour'  => [
                    'allowLanguageSynchronization' => true
                ],
                'type'       => 'datetime',
                'size'       => 13,
                'default'    => 0,
            ],
        ],
        'title'                    => [
            'displayCond' => 'FIELD:genius_bar:<:1',
            'exclude'     => 0,
            'label'       => $LL . 'tx_slubevents_domain_model_event.title',
            'l10n_mode'   => 'prefixLangTitle',
            'config'      => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'start_date_time'          => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.start_date_time',
            'config'    => [
                'type'       => 'datetime',
                'size'       => 13,
                'default'    => 0,
                'required' => true,
            ],
        ],
        'all_day'                  => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.all_day',
            'config'    => [
                'type'    => 'check',
                'default' => 0,
            ],
        ],
        'end_date_time'            => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.end_date_time',
            'config'    => [
                'type'       => 'datetime',
                'size'       => 13,
                'default'    => 0,
            ],
        ],
        'end_date_time_select'     => [
            'displayCond' => 'FIELD:end_date_time:=:0',
            'l10n_mode'   => 'exclude',
            'exclude'     => 0,
            'label'       => $LL . 'tx_slubevents_domain_model_event.end_date_time_select',
            'config'      => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.end_date_time_select_value',
                        'value' => 0,
                    ],
                    ['label' => '00:15', 'value' => 15],
                    ['label' => '00:30', 'value' => 30],
                    ['label' => '00:45', 'value' => 45],
                    ['label' => '01:00', 'value' => 60],
                    ['label' => '01:30', 'value' => 90],
                    ['label' => '02:00', 'value' => 120],
                    ['label' => '03:00', 'value' => 180],
                    ['label' => '04:00', 'value' => 240],
                    ['label' => '05:00', 'value' => 300],
                    ['label' => '06:00', 'value' => 360],
                ],
                'size'       => 1,
                'maxitems'   => 1,
                'eval'       => '',
                'default'    => 60,
            ],
        ],
        'sub_end_date_time'        => [
            'displayCond' => 'FIELD:external_registration:REQ:false',
            'l10n_mode'   => 'exclude',
            'exclude'     => 0,
            'label'       => $LL . 'tx_slubevents_domain_model_event.sub_end_date_time',
            'config'      => [
                'type'       => 'datetime',
                'size'       => 13,
                'default'    => 0,
            ],
        ],
        'sub_end_date_time_select' => [
            'displayCond' => [
                'AND' => [
                    'FIELD:sub_end_date_time:=:0',
                    'displayCond' => 'FIELD:external_registration:REQ:false'
                ]
            ],
            'l10n_mode'   => 'exclude',
            'exclude'     => 0,
            'label'       => $LL . 'tx_slubevents_domain_model_event.sub_end_date_time_select',
            'config'      => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.sub_end_date_time_select_value',
                        'value' => -1,
                    ],
                    ['label' => '00:00', 'value' => 0],
                    ['label' => '00:30', 'value' => 30],
                    ['label' => '01:00', 'value' => 60],
                    ['label' => '02:00', 'value' => 120],
                    ['label' => '04:00', 'value' => 240],
                    ['label' => '12:00', 'value' => 720],
                    ['label' => '24:00', 'value' => 1440],
                    ['label' => '48:00', 'value' => 2880],
                    ['label' => '72:00', 'value' => 4320],
                ],
                'size'       => 1,
                'maxitems'   => 1,
                'eval'       => '',
                'default'    => 1440,
            ],
        ],
        'teaser'                   => [
            'displayCond' => 'FIELD:genius_bar:<:1',
            'exclude'     => 1,
            'label'       => $LL . 'tx_slubevents_domain_model_event.teaser',
            'l10n_mode'   => 'prefixLangTitle',
            'config'      => [
                'type'           => 'text',
                'cols'           => 40,
                'rows'           => 15,
                'eval'           => 'trim',
                'fieldControl'   => [
                    'fullScreenRichtext' => [
                        'disabled' => false
                    ],
                ],
                'enableRichtext' => true,
                'default'        => ''
            ],
        ],
        'description'              => [
            'displayCond' => 'FIELD:genius_bar:<:1',
            'exclude'     => 0,
            'label'       => $LL . 'tx_slubevents_domain_model_event.description',
            'l10n_mode'   => 'prefixLangTitle',
            'config'      => [
                'type'           => 'text',
                'cols'           => 40,
                'rows'           => 15,
                'eval'           => 'trim',
                'fieldControl'   => [
                    'fullScreenRichtext' => [
                        'disabled' => false
                    ],
                ],
                'enableRichtext' => true,
            ],
        ],
        'content_elements'         => [
            'exclude' => true,
            'label'   => $LL . 'tx_slubevents_domain_model_event.content_elements',
            'config'  => [
                'type'           => 'inline',
                'allowed'        => 'tt_content',
                'foreign_table'  => 'tt_content',
                'foreign_sortby' => 'sorting',
                'foreign_field'  => 'tx_slubevents_related_content',
                'minitems'       => 0,
                'maxitems'       => 99,
                'appearance'     => [
                    'collapseAll'                     => true,
                    'expandSingle'                    => true,
                    'levelLinksPosition'              => 'bottom',
                    'useSortable'                     => true,
                    'showPossibleLocalizationRecords' => true,
                    'showAllLocalizationLink'         => true,
                    'showSynchronizationLink'         => true,
                    'enabledControls'                 => [
                        'info' => false,
                    ]
                ],
                'behaviour'      => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'image'                    => [
            'exclude' => true,
            'label'   => $LL . 'tx_slubevents_domain_model_event.image',
            'config'  => [
                ### !!! Watch out for fieldName different from columnName
                'type' => 'file',
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'maxitems'             => 1,
                'appearance'           => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                    'fileUploadAllowed'          => false
                ],
                'foreign_match_fields' => [
                    'fieldname'   => 'image',
                    'tablenames'  => 'tx_slubevents_domain_model_event',
                ],
                'default'              => 0,
            ]
        ],
        'min_subscriber'           => [
            'displayCond' => 'FIELD:external_registration:REQ:false',
            'exclude'     => 0,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.min_subscriber',
            'config'      => [
                'type' => 'number',
                'size' => 4,
            ],
        ],
        'max_subscriber'           => [
            'displayCond' => 'FIELD:external_registration:REQ:false',
            'exclude'     => 0,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.max_subscriber',
            'config'      => [
                'type' => 'number',
                'size' => 4,
            ],
        ],
        'max_number'               => [
            'displayCond' => 'FIELD:external_registration:REQ:false',
            'exclude'     => 0,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.max_number',
            'config'      => [
                'type' => 'number',
                'size' => 4
            ],
        ],
        'audience'                 => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.audience',
            'config'    => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'items'      => [
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.audience.I.0',
                        'value' => 0,
                    ],
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.audience.I.1',
                        'value' => 1,
                    ],
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.audience.I.4',
                        'value' => 4,
                    ],
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.audience.I.2',
                        'value' => 2,
                    ],
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.audience.I.3',
                        'value' => 3,
                    ],
                    [
                        'label' => $LL . 'tx_slubevents_domain_model_event.audience.I.5',
                        'value' => 5,
                    ],
                ],
                'size'       => 1,
                'maxitems'   => 1,
                'required' => true,
            ],
        ],
        'sub_end_date_info_sent'   => [
            'displayCond' => 'FIELD:external_registration:REQ:false',
            'exclude'     => 0,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.sub_end_date_info_sent',
            'config'      => [
                'type'    => 'check',
                'default' => 0,
            ],
        ],

        'no_search' => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.no_search',
            'config'    => [
                'type'    => 'check',
                'default' => 0,
            ],
        ],

        'genius_bar'              => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.genius_bar',
            'config'    => [
                'type'    => 'check',
                'default' => 0,
            ],
            'onChange'  => 'reload',
        ],
        'parent'                  => [
            'displayCond' => 'FIELD:parent:REQ:true',
            'exclude'     => 0,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.parent',
            'config'      => [
                'type'       => 'user',
                'renderType' => 'recurringParent',
            ],
        ],
        'recurring'               => [
            'displayCond' => 'FIELD:parent:REQ:false',
            'l10n_mode'   => 'exclude',
            'exclude'     => 1,
            'label'       => $LL . 'tx_slubevents_domain_model_event.recurring',
            'config'      => [
                'type'    => 'check',
                'default' => 0,
            ],
            'onChange'    => 'reload',
        ],
        'recurring_options'       => [
            'displayCond' => 'FIELD:recurring:REQ:true',
            'exclude'     => 1,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.recurring_options',
            'config'      => [
                'type'       => 'user',
                'renderType' => 'recurringOptions',
                'size'       => 60,
                'parameters' => ['color' => 'green']
            ],
        ],
        'recurring_events'        => [
            'displayCond' => 'FIELD:recurring:REQ:true',
            'exclude'     => 1,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.recurring_events',
            'config'      => [
                'type'       => 'user',
                'renderType' => 'recurringEvents',
                'size'       => 60,
                'parameters' => ['color' => 'green']
            ],
        ],
        'recurring_end_date_time' => [
            'displayCond' => 'FIELD:recurring:REQ:true',
            'l10n_mode'   => 'exclude',
            'exclude'     => 1,
            'label'       => $LL . 'tx_slubevents_domain_model_event.recurring_end_date_time',
            'config'      => [
                'type'       => 'datetime',
                'size'       => 13,
                'default'    => 0,
            ],
        ],
        'cancelled'               => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.cancelled',
            'config'    => [
                'type'    => 'check',
                'default' => 0,
            ],
        ],
        'categories'              => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.categories',
            'config'    => [
                'behaviour'           => [
                    'allowLanguageSynchronization' => true
                ],
                'type'                => 'select',
                'foreign_table'       => 'tx_slubevents_domain_model_category',
                'foreign_table_where' => 'AND tx_slubevents_domain_model_category.genius_bar = ###REC_FIELD_genius_bar### AND tx_slubevents_domain_model_category.pid = ###CURRENT_PID### AND (tx_slubevents_domain_model_category.sys_language_uid = 0 OR tx_slubevents_domain_model_category.l10n_parent = 0) AND tx_slubevents_domain_model_category.hidden = 0 ORDER BY tx_slubevents_domain_model_category.sorting ASC',
                'MM'                  => 'tx_slubevents_event_category_mm',
                'renderType'          => 'selectTree',
                'subType'             => 'db',
                'treeConfig'          => [
                    'parentField' => 'parent',
                    'appearance'  => [
                        'expandAll'  => true,
                        'showHeader' => true,
                        'maxLevels'  => 10,
                    ],
                ],
                'size'                => 10,
                'minitems'            => 1,
                'maxitems'            => 30,
            ],
        ],
        'subscribers'             => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.subscribers',
            'config'    => [
                'type'          => 'inline',
                'foreign_table' => 'tx_slubevents_domain_model_subscriber',
                'foreign_field' => 'event',
                'maxitems'      => 9999,
                'appearance'    => [
                    'collapseAll'                     => 1,
                    'expandSingle'                    => 1,
                    'levelLinksPosition'              => 'bottom',
                    'showSynchronizationLink'         => 0,
                    'showPossibleLocalizationRecords' => 0,
                    'showAllLocalizationLink'         => 0,
                ],
            ],
        ],
        'location'                => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.location',
            'config'    => [
                'type'                => 'select',
                'foreign_table'       => 'tx_slubevents_domain_model_location',
                'foreign_table_where' => ' AND (tx_slubevents_domain_model_location.sys_language_uid = 0 OR tx_slubevents_domain_model_location.l10n_parent = 0) AND tx_slubevents_domain_model_location.pid = ###CURRENT_PID### AND tx_slubevents_domain_model_location.deleted = 0 AND tx_slubevents_domain_model_location.hidden = 0 ORDER BY tx_slubevents_domain_model_location.sorting',
                'renderType'          => 'selectTree',
                'subType'             => 'db',
                'treeConfig'          => [
                    'parentField' => 'parent',
                    'appearance'  => [
                        'expandAll'  => true,
                        'showHeader' => true,
                    ],
                ],
                'size'                => 10,
                'minitems'            => 1,
                'maxitems'            => 1,
                'default'             => 0
            ],
        ],
        'discipline'              => [
            'displayCond' => 'FIELD:genius_bar:<:1',
            'exclude'     => 0,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.discipline',
            'config'      => [
                'type'                => 'select',
                'foreign_table'       => 'tx_slubevents_domain_model_discipline',
                'foreign_table_where' => ' AND (tx_slubevents_domain_model_discipline.sys_language_uid = 0 OR tx_slubevents_domain_model_discipline.l10n_parent = 0) AND tx_slubevents_domain_model_discipline.pid = ###CURRENT_PID### AND tx_slubevents_domain_model_discipline.deleted = 0 AND tx_slubevents_domain_model_discipline.hidden = 0 ORDER BY tx_slubevents_domain_model_discipline.sorting',
                'MM'                  => 'tx_slubevents_event_discipline_mm',
                'renderType'          => 'selectTree',
                'subType'             => 'db',
                'treeConfig'          => [
                    'parentField' => 'parent',
                    'appearance'  => [
                        'expandAll'  => true,
                        'showHeader' => true,
                    ],
                ],
                'size'                => 10,
                'minitems'            => 1,
                'maxitems'            => 10,
                'default'             => 0
            ],
        ],
        'topic'                     => [
            'displayCond' => 'FIELD:genius_bar:<:1',
            'exclude'     => 0,
            'l10n_mode'   => 'exclude',
            'label'       => $LL . 'tx_slubevents_domain_model_event.topic',
            'config'      => [
                'type'                => 'select',
                'foreign_table'       => 'tx_slubevents_domain_model_topic',
                'foreign_table_where' => ' AND (tx_slubevents_domain_model_topic.sys_language_uid = 0 OR tx_slubevents_domain_model_topic.l10n_parent = 0) AND tx_slubevents_domain_model_topic.pid = ###CURRENT_PID### AND tx_slubevents_domain_model_topic.deleted = 0 AND tx_slubevents_domain_model_topic.hidden = 0 ORDER BY tx_slubevents_domain_model_topic.sorting',
                'MM'                  => 'tx_slubevents_event_topic_mm',
                'renderType'          => 'selectTree',
                'subType'             => 'db',
                'treeConfig'          => [
                    'parentField' => 'parent',
                    'appearance'  => [
                        'expandAll'  => true,
                        'showHeader' => true,
                    ],
                ],
                'size'                => 10,
                'minitems'            => 1,
                'maxitems'            => 1,
                'default'             => 0
            ],
        ],
        'contact'                  => [
            'exclude' => 0,
            'l10n_mode' => 'exclude',
            'label'   => $LL . 'tx_slubevents_domain_model_event.contact',
            'config'  => [
                'allowed'             => 'pages',
                'type'                => 'select',
                'foreign_table'       => 'tx_slubevents_domain_model_discipline',
                'foreign_table_where' => ' AND (tx_slubevents_domain_model_discipline.sys_language_uid = 0 OR tx_slubevents_domain_model_discipline.l10n_parent = 0) AND tx_slubevents_domain_model_discipline.pid = ###CURRENT_PID### AND tx_slubevents_domain_model_discipline.deleted = 0 AND tx_slubevents_domain_model_discipline.hidden = 0 ORDER BY tx_slubevents_domain_model_discipline.sorting',
                'renderType'          => 'selectSingle',
                'size'                => 1,
                'minitems'            => 1,
                'maxitems'            => 1,
                'required' => true
            ],
        ],
        'contact'                 => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.contact',
            'config'    => [
                'allowed'                          => 'pages',
                'type'                             => 'select',
                'renderType'                       => 'selectMultipleSideBySide',
                'foreign_table'                    => 'tx_slubevents_domain_model_contact',
                'foreign_table_where'              => 'AND tx_slubevents_domain_model_contact.pid = ###CURRENT_PID### AND tx_slubevents_domain_model_contact.deleted = 0 AND tx_slubevents_domain_model_contact.hidden = 0 ORDER BY tx_slubevents_domain_model_contact.sorting',
                'minitems'                         => 1,
                'maxitems'                         => 1,
                'size'                             => 8,
                'selectedListStyle'                => 'width:600px;',
                'itemListStyle'                    => 'width:600px;',
                'default'                          => 0
            ],
        ],
        'onlinesurvey'            => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.onlinesurvey',
            'config'    => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
        ],
        'external_registration'   => [
            'exclude'   => 0,
            'l10n_mode' => 'exclude',
            'label'     => $LL . 'tx_slubevents_domain_model_event.external_registration',
            'config'    => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
            ],
            'onChange'  => 'reload',
        ],
    ],
];
