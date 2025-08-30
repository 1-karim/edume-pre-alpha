<?php
defined('MOODLE_INTERNAL') || die();

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true),
    'output' => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes()
];

echo $OUTPUT->render_from_template('theme_edume/default', $templatecontext);