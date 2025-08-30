<?php
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Create settings tabs like Boost does.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingedume',
        get_string('configtitle', 'theme_edume'));

    // ---- General tab ----
    $page = new admin_settingpage('theme_edume_general',
        get_string('generalsettings', 'theme_edume'));

    // Example brand color.
    $page->add(new admin_setting_configcolourpicker(
        'theme_edume/brandcolor',
        get_string('brandcolor', 'theme_edume'),
        get_string('brandcolor_desc', 'theme_edume'),
        '#789262'
    ));

    // Slider images.
    $page->add(new admin_setting_configstoredfile(
        'theme_edume/sliderimage1',
        get_string('sliderimage1', 'theme_edume'),
        get_string('sliderimage_desc', 'theme_edume'),
        'sliderimage1'
    ));

    $page->add(new admin_setting_configstoredfile(
        'theme_edume/sliderimage2',
        get_string('sliderimage2', 'theme_edume'),
        get_string('sliderimage_desc', 'theme_edume'),
        'sliderimage2'
    ));

    $page->add(new admin_setting_configstoredfile(
        'theme_edume/sliderimage3',
        get_string('sliderimage3', 'theme_edume'),
        get_string('sliderimage_desc', 'theme_edume'),
        'sliderimage3'
    ));

    $settings->add($page);
}
