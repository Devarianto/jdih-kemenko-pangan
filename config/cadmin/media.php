<?php

$thumbs = [];

foreach(
[
    '1440x820', '1440x400', '916x662', '606x425', '720x620', '1440x600', '481x400', '629x414', '172x130', '300x300', '340x227', '400x340', '433x439', '340x340', '486x500',
    '766x1024', '375x667', '147x60', '400x400', '334x225', '375x225', '152x115', '1200x463', '174x240', '380x300', '312x200', '1200x406', '280x220', '536x300','180x248','943x448','688x404','325x560','360x360','240x284','360x760','375x340','1024x480', '926x619', '1070x240', '990x287'
] 
as $v) {
    $x = explode('x',$v);
    $thumbs[$v] = [
        'width'=>(int) $x[0],
        'height'=>(int) $x[1],
        'type'=>array_key_exists(2,$x) ? $x[2] : 'cover',
    ];
}

$thumbs['h80'] = [
    'height'=>80,
    'type'=>'cover',
];

$thumbs['h60'] = [
    'height'=>60,
    'type'=>'cover',
];

return [
    'sourcepath' => 'assets/source',
    'thumbpath' => 'assets/thumbs',
    'driver'=>'local',
    'thumbs'    => $thumbs
];
