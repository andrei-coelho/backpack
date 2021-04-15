<?php 

namespace Back;

use src\Config as Config;
use SQLi\DataBase as DataBase;

class Pack {

    private $dataController = null;

    public function __construct(){

        Config::create();
        DataBase::openLinks();
        Request::open();
        Route::enter();
        $this->onStart();
    }

    private function onStart(){
        
        $vars = Request::all();

        if(!($target = Route::getTarget())){
            $target = "error";
            $vars   = [
                "code" => "404"
            ];
        }
        
        $this ->dataController = Controller::start($target, $vars);

        foreach ($this->dataController->getMiddleware() as $mid) 
            if($redirect = Middleware::exec($mid)){
                $this -> onFinish();
                header("Location: $redirect");
                exit;
            }
        
        $this ->onRender();
        
    }

    private function onRender(){

        $response = Route::getTypeRoute() == 'api' ? 
                  new Json($this ->dataController) :
                  new Html($this ->dataController) ;
        $response->headers();
        $response->send();

        $this->onFinish();
    }

    private function onFinish(){
        DataBase::closeAll();
    }

}