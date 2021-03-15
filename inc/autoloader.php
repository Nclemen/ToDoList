<?php
include 'inc/dbCreds.php';
spl_autoload_register(function ($class_name) {
    $folder = 'models/';
    $extension = '.php';
    $fullpath = $folder . $class_name . $extension;
    include_once $fullpath;
});
?>