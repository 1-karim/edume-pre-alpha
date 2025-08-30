<?php
namespace theme_edume\output;

use stdClass;

class core_renderer extends \theme_boost\output\core_renderer {

    // public function frontpage_context() {
    //     $slides = [];
    //     $themeconfig = \core\output\theme_config::load('edume');

    //     // Example: 3 slides
    //     for ($i = 1; $i <= 3; $i++) {
    //         $image = $themeconfig->setting_file_url("sliderimage{$i}", "sliderimage{$i}");
    //         if ($image) {
    //             $slides[] = [
    //                 'image'   => $image,
    //                 'title'   => get_config('theme_edume', "slidertitle{$i}") ?? '',
    //                 'caption' => get_config('theme_edume', "slidercaption{$i}") ?? '',
    //                 'link'    => get_config('theme_edume', "sliderlink{$i}") ?? '',
    //             ];
    //         }
    //     }

    //     return [
    //         'sitename' => format_string($this->page->heading),
    //         'slides'   => $slides,
    //     ];
    // }
}
