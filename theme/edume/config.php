<?php
defined('MOODLE_INTERNAL') || die();


$THEME->name = 'edume';
$THEME->parents = ['boost']; // inherit from Boost
$THEME->sheets = []; // we’ll use SCSS instead
$THEME->supportscssoptimisation = false;
$THEME->favicon = 'favicon'; // put your favicon in /pix folder
// A dock is a way to take blocks out of the page and put them in a persistent floating area on the side of the page. Boost         
// does not support a dock so we won't either - but look at bootstrapbase for an example of a theme with a dock.                    
$THEME->enable_dock = false;                                                                                        
// This is an old setting used to load specific CSS for some YUI JS. We don't need it in Boost based themes because Boost           
// provides default styling for the YUI modules that we use. It is not recommended to use this setting anymore.                     
$THEME->yuicssmodules = array();                                                                                                    
                                                                                                                                    
// Most themes will use this rendererfactory as this is the one that allows the theme to override any other renderer.               
$THEME->rendererfactory = 'theme_overridden_renderer_factory';                                                                      
                                                                                                                                    
// This is a list of blocks that are required to exist on all pages for this theme to function correctly. For example               
// bootstrap base requires the settings and navigation blocks because otherwise there would be no way to navigate to all the        
// pages in Moodle. Boost does not require these blocks because it provides other ways to navigate built into the theme.            
$THEME->requiredblocks = [];   

// This is a feature that tells the blocks library not to use the "Add a block" block. We don't want this in boost based themes because
// it forces a block region into the page when editing is enabled and it takes up too much room.
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

$THEME->haseditswitch = true;
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
    'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
    'course' => [
        'file' => 'default.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
    ],
];
