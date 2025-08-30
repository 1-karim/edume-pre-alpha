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

/**
 * Serves the slider image files
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param stdClass $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_edume_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    // Check if this is a slider image
    if (strpos($filearea, 'slide') === 0 && strpos($filearea, 'image') !== false) {
        $theme = theme_config::load('yourthemename');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }
    
    return false;
}

/**
 * Get theme setting value
 *
 * @param string $setting
 * @param string $format
 * @return string
 */
function theme_edume_get_setting($setting, $format = false) {
    $theme = theme_config::load('yourthemename');
    if (empty($theme->settings->$setting)) {
        return false;
    } else if (!$format) {
        return $theme->settings->$setting;
    } else if ($format === 'format_text') {
        return format_text($theme->settings->$setting, FORMAT_PLAIN);
    } else if ($format === 'format_html') {
        return format_text($theme->settings->$setting, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
    } else {
        return format_string($theme->settings->$setting);
    }
}

/**
 * Extend the frontpage template context with slider data
 *
 * @param array $templatecontext
 * @param renderer_base $renderer
 * @return array
 */
function theme_edume_extend_frontpage_context($templatecontext, $renderer) {
    global $PAGE;
    
    // Only add slider on frontpage
    if ($PAGE->pagetype === 'site-index') {
        $templatecontext['slider'] = $renderer->render_slider();
    }
    
    return $templatecontext;
}

/**
 * Process CSS to add any custom styles
 *
 * @param string $css
 * @param theme_config $theme
 * @return string
 */