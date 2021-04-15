<?php 

require "../src/Spyc.php";
require "../src/Config.php";
include "../src/helper.php";

use src\Config as Config;

Config::create();

// pack and model register
spl_autoload_register(function($class) {

    $parts     = explode("\\", $class);
    $realClass = array_pop($parts);
    $pack  = "";
    $realPack = "";

    foreach ($parts as $k => $p) {
        $el = strtolower($p);
        if($k == 0) $realPack = $el;
        $pack .= $el."/";
    }

    $file  = "../src/".$pack.$realClass.".php";
    
    if(Config::is_pack($realPack) && file_exists($file) && !class_exists($class)){
        include $file;
        return;
    }

    $fileModel = "../model/".$pack.$realClass.".php";
    
    if(file_exists($fileModel) && !class_exists($class)){
        include $fileModel;
    }

});
