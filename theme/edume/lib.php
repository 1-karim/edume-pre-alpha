<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Loads the main SCSS content for the theme.
 *
 * @param theme_config $theme
 * @return string
 */
function theme_edume_get_main_scss_content($theme) {
    global $CFG;

    // Load parent theme (Boost) SCSS first
    $scss = file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');

    // Add your custom preset if it exists
    $custom = $CFG->dirroot . '/theme/edume/scss/preset.scss';
    if (file_exists($custom)) {
        $scss .= "\n" . file_get_contents($custom);
    }

    return $scss;
}
