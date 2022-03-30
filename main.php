<?php
// Configuration
$root_dir = __DIR__ . "/src/";
$main_file = $root_dir . "index.php";

// AutoLoad Classes
spl_autoload_register(function($className) use($root_dir){
    $file = $root_dir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';
    if(file_exists($file)) {
        require $file;
        return true;
    }
});

// load configuration file
include "config.php";

// run main file
include $main_file;