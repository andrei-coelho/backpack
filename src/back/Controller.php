<?php 

// Esta classe irá chamar um controller específico e retornará seus dados 

namespace Back;

class Controller {
    
    private static $atualKey = 0;
    private static $dataControllerInstances = [];

    public static function start($controller, $args = []){
        
        // via request com uma rota definida
        self::$dataControllerInstances[] = new DataController();
        self::init($controller, $args, false);
        return array_pop(self::$dataControllerInstances);
        
    }

    public static function get(){
        
        // via outros controllers
        self::$dataControllerInstances[] = new DataController();

        if(func_num_args() == 0) {
            // mostra erro em desenvolvimento
            return false;
        }

        $args = func_get_args();
        $controller = array_shift($args);
        self::init($controller, $args);

        return array_pop(self::$dataControllerInstances)->getData();

    }

    private static function init($controller, $args = [], $order = true){
    
        $fileController = "../app/controller/".$controller.".php";
        
        if(!file_exists($fileController)){
            // mostra erro em desenvolvimento
            throw new \Exception("O controller $controller não existe", 1);
            return false;
        }

        $mainFunc = include $fileController;
        $f        = new \ReflectionFunction($mainFunc);
        
        if($order){
            $f->invokeArgs($args);
            return;
        }

        $params   = [];

        foreach ($f->getParameters() as $param) {

            if(!$param->isOptional() && !isset($args[$param->name])){
                // mostra erro em desenvolvimento
                throw new \Exception("Erro. O parâmetro '".$param->name."' não é opicional." , 1);
            }
            
            if(isset($args[$param->name]))
                $params[] = $args[$param->name];

        }

        $f->invokeArgs($params);

    }

    private static function mid($file){
        self::$dataControllerInstances[count(self::$dataControllerInstances)-1]->setMiddleware($file);
    }

    private static function data($data){
        self::$dataControllerInstances[count(self::$dataControllerInstances)-1]->setData($data);
    }

    private static function page($page){
        self::$dataControllerInstances[count(self::$dataControllerInstances)-1]->setPage($page);
    }

    private static function headerResponseCode(int $code){
        self::$dataControllerInstances[count(self::$dataControllerInstances)-1]->setCode($code);
    }

}