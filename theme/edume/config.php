<?php
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'edume';
$THEME->parents = ['boost']; // inherit from Boost
$THEME->sheets = []; // we’ll use SCSS instead
$THEME->supportscssoptimisation = false;

$THEME->scss = function($theme) {
    return theme_edume_get_main_scss_content($theme);
};

$THEME->layouts = [
    'base' => [
        'file' => 'default.php',
        'regions' => [],
    ],
    'standard' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'course' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
];
