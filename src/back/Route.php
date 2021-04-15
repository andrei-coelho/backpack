<?php 

namespace Back;

use src\Config as Config;

class Route {

    private static $routes = [];

    private static $request = false;
    private static $target = false;
    private static $init = false;

    private static $ignore = "main";

    public static function enter(){
        
        $req  = Request::get(0);
        $file = "../app/routes/$req.route.php";

        $file = file_exists($file) ? (function($file, $req){
            self::$ignore = $req;
            return $file;
        })($file, $req) : "../app/routes/main.route.php";

        include $file;
        
    }

    public static function req(string $route, string $target){  
        
        if(self::$target) return;

        if(!self::$request){
            self::$request = implode("/", Request::get());
        }

        self::$request = str_replace(self::$ignore, "", self::$request);
        
        if(self::$request == "" && self::is_main($route)){
            self::$target = $target;
            return;
        }

        if(self::is_regex($route)){
            
            $data = self::tranform_data($route);
            $vars = [];
            
            foreach ($data as $d) {
                $vars[]['slug'] = $d['slug'];
                $route = str_replace($d['to_replace'], $d['value'], $route);
            }

            if(preg_match($route, self::$request, $out)){
                
                foreach ($vars as $k => $v) {
                    if(isset($out[$k + 1])){
                        $vars[$k]['value'] = $out[$k + 1];
                    }
                }

                Request::saveSlugGet($vars);
                self::$target = $target;
                
                return;

            }
            
            
            return;
        }

        if (strpos(self::$request, $route) !== false){
            self::$target = $target;
        }


    }


    public static function getTarget(){
        return self::$target;
    }

    public static function ignore($ignore){
        self::$ignore = $ignore;
    }

    private static function tranform_data($reg){

        preg_match_all('/({(\w+)})(\?)?/', $reg, $out);
        
        // create arrays
        $data     = [];

        foreach ($out[1] as $key => $var) {
            $data[] = [
                "slug" => $var,
                "to_replace" => $out[1][$key],
                "value" => "([^\/]+)",
            ];
        }

        return $data;

    }

    private static function is_regex($test){
        return preg_match('/\/[^#]+\//', $test);
    }

    private static function is_main($test){
        return preg_match('/main/', $test);
    }


    public static function getTypeRoute(){
        return self::$ignore;
    }
}