<?php

define("JS",1);
define("CSS",2);

$dirs = [
    "public",
    "public/script",
    "public/css"
];

$files =  [
    "bootstrap.min.css" => [
        "vendor/twbs/bootstrap/dist/css/",
        "public/css/"
    ],
    "bootstrap.bundle.min.js" => [
        "vendor/twbs/bootstrap/dist/js/",
        "public/script/"
    ]
];

foreach($dirs as $dir) {

    if(!is_dir($dir)) {
        mkdir($dir);
        echo('Create directory : '.$dir."\r\n");
    }

}

foreach($files as $file_name => $paths ) {

    $source = $paths[0].$file_name;
    $dest = $paths[1].$file_name;

    if(is_file($dest)) {
        unlink($dest);
        echo('deleted '.$dest."\r\n");
    }
    
    copy($source,$dest); 
    echo('copy : '.$source."\r\n".'in : '.$dest."\r\n");
    
}

$files_jquery = "https://github.com/jquery/jquery/archive/3.5.0.zip";
$tmp_file = "tmp.zip";
$file_name = "jquery.min.js";
$file_path = "jquery-3.5.0/dist/";

file_put_contents($tmp_file, fopen("$files_jquery", 'r'));
echo('dowloaded : '.$files_jquery."\r\n");

$zip = new ZipArchive;
if ($zip->open($tmp_file) === TRUE) {
    $file_content = $zip->getFromName($file_path.$file_name);
    file_put_contents($dirs[JS].'/'.$file_name, $file_content);
    $zip->close();
} else {
    echo 'échec';
}

unlink($tmp_file);
echo('deleted '.$tmp_file."\r\n");

?>