<?php 

namespace src;

class MapModel {

    private static $listClasses = [];

    public static function add($class){
        self::$listClasses[] = $class;
    }

    public static function getList(){
        return self::$listClasses;
    }

}