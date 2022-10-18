<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    //'format' => 'A4-L',
    //'orientation' => 'L',
    'default_font' => 'vazir',
    'author'                => '',
    'subject'               => '',
    'keywords'              => '',
    'creator'               => 'Laravel Pdf',
    'display_mode'          => 'fullpage',
    'tempDir'               => base_path('../temp/'),

    'font_path' => base_path('../admin/fonts/Vazir/'),
    'font_data' => [
        'vazir' => [
            'R'  => 'Vazir.ttf',    // regular font
            //'B'  => '',       // optional: bold font
            //'I'  => '',     // optional: italic font
            //'BI' => '', // optional: bold-italic font
            'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ]
    ]
];
