<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DomPDF Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can set the DomPDF configuration options.
    |
    */

    'enabled' => true,
    'font_path' => base_path('/storage/fonts'),  // Đường dẫn đến thư mục font
    'font_data' => [
        'vntime' => [
            'R'  => storage_path('fonts/VNTIME.TTF'),   // Đảm bảo bạn đã tải font và đường dẫn đúng
            'B'  => storage_path('fonts/VNTIMEB.TTF'),
            'I'  => storage_path('fonts/VNTIMEI.TTF'),
            'BI' => storage_path('fonts/VNTIMEBI.TTF'),
        ],


        'vni_times' => [
            'R'  => 'VNTIME.TTF',   // Đảm bảo bạn đã tải font và đường dẫn đúng
            'B'  => 'VNTIMEB.TTF',
            'I'  => 'VNTIMEI.TTF',
            'BI' => 'VNTIMEBI.TTF',
        ],
    ],
    'default_paper_size' => 'A4',  // Kích thước giấy mặc định
    'paper' => 'A4',
    'isHtml5ParserEnabled' => true,  // Cho phép sử dụng HTML5 parser
    'isPhpEnabled' => true,         // Cho phép sử dụng PHP trong PDF
];
