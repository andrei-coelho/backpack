<?php 

namespace Back;

class Middleware {

    private $redirect = false;
    private $file = "";
    private static $instances = [];

    private function __construct($file) {
        $this->file = $file;
    }

    private function include(){
        include $this->file;
    }

    public static function exec($mid){

        $file = "../app/middleware/".$mid.".php";

        if(file_exists($file)){
            $mid = new Middleware($file);
            self::$instances[] = $mid;
            $mid -> include();
            return $mid -> redirect;
        }

        return false;

    }

    private static function redirect($to){
        self::$instances[count(self::$instances) - 1] -> redirect = $to;
    }

}