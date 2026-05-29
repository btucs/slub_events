<?php

declare(strict_types=1);

/***************************************************************
 * Extension Manager/Repository config file for ext "slub_events".
 *
 ***************************************************************/
$EM_CONF[$_EXTKEY] = [
    'title'            => 'SLUB: Event Registration',
    'description'      => 'Tool for event registration and experts booking.

This extension is developped and used in production at the Saxony State and University Library (SLUB) Dresden, Germany.',
    'category'         => 'plugin',
    'author'           => 'SLUB TYPO3 Team',
    'author_email'     => 'typo3@slub-dresden.de',
    'author_company'   => 'SLUB Dresden',
    'state'            => 'stable',
    'version'          => '6.3.0',
    'constraints'      => [
        'depends'   => [
            'typo3'   => '12.4.0-0.0.0',
        ],
        'conflicts' => [
        ],
        'suggests'  => [
        ],
    ],
];
