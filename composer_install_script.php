<?php

$mkdirs = [
    "public",
    "public/script",
    "public/css"
];

$files =  [
    "bootstrap.min.css" => [
        "vendor/twbs/bootstrap/dist/css/",
        "public/css/"
    ],
    "bootstrap.min.js" => [
        "vendor/twbs/bootstrap/dist/js/",
        "public/script/"
    ]
];

foreach($mkdirs as $dir) {

    if(!is_dir($dir)) {
        mkdir($dir);
        echo('Create directory : '.$dir."\r\n");
    }

}

foreach($files as $file_name => $dirs ) {

    $source = $dirs[0].$file_name;
    $dest = $dirs[1].$file_name;

    if(is_file($dest)) {
        unlink($dest);
        echo('deleted '.$dest."\r\n");
    }
    
    copy($source,$dest); 
    echo('copy : '.$source."\r\n".'in : '.$dest."\r\n");
    
}

?>