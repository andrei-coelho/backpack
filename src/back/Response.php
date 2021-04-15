<?php 

namespace Back;

abstract class Response {

    protected $controller;
    
    public function __construct(DataController $controller) {
        header($controller->getHeaderResponseCode());
        $this->controller = $controller;
    }

}