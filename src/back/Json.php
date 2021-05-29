<?php 

namespace Back;

class Json extends Response implements ResponseInterface{

    public function headers(){
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
    }

    public function send(){
        echo ObjJson::hot_json_encode([
            "error" => $this->controller->getError(),
            "code"  => $this->controller->getCodeNumber(),
            "data"  => $this->controller->getData()
        ], 
            JSON_PRETTY_PRINT | 
            JSON_PRESERVE_ZERO_FRACTION | 
            JSON_PARTIAL_OUTPUT_ON_ERROR |
            JSON_UNESCAPED_UNICODE
        );
    }

}