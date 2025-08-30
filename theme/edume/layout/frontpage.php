<?php
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/behat/lib.php'); // not mandatory; typical includes vary

$templatecontext = [
    'sitename'       => format_string($SITE->fullname, true, ['context' => \context_course::instance(SITEID)]),
    'output'         => $OUTPUT,
    'bodyattributes' => $OUTPUT->body_attributes(),
    'sidepreblocks'  => $OUTPUT->blocks('side-pre'),
];

// Build slides array
$slides = [];
for ($i = 1; $i <= 3; $i++) {
    $img = $PAGE->theme->setting_file_url("sliderimage{$i}", "sliderimage{$i}");
    if ($img) {
        $slides[] = [
            'image'   => $img,
            'title'   => (string)get_config('theme_edume', "slidetitle{$i}"),
            'caption' => (string)get_config('theme_edume', "slidecaption{$i}"),
            'link'    => (string)get_config('theme_edume', "slidelink{$i}"),
            'first'   => (count($slides) === 0) // Mark first slide
        ];
    }
}

// ✅ Inject into Mustache context
$templatecontext['slides'] = $slides;

// Render your frontpage mustache.
echo $OUTPUT->render_from_template('theme_edume/frontpage', $templatecontext);