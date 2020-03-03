<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Visualize locked backend',
    'description' => 'Visualize a locked TYPO3 backend for logged in backend editors. For example as part for your deployment process.',
    'version' => '1.0.0',
    'state' => 'stable',
    'author' => 'Josef Glatz',
    'author_email' => 'josefglatz@gmailcom',
    'clearCacheOnLoad' => true,
    'category' => 'be',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
            'php' => '7.2.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
