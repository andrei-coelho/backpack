<?php 

namespace Back;

class DataController {

    private $mid  = [], $data = [], $html, $title;
    private $code = "HTTP/1.1 200 OK";

    private $metas = [];

    public function setMiddleware($middleware){
        $this->mid[] = $middleware;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function setPage($htmlFile){
        $this->html = $htmlFile;
    }

    public function getData(){
        return $this->data;
    }

    public function getPage(){
        return $this->html;
    }

    public function getMiddleware(){
        return $this->mid;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setMeta($name, $content){
        $this->metas[$name] = $content;
    }

    public function getMetas(){
        return $this->metas;
    }

    public function setCode($code){
        switch ($code) {
            case 404:
                $this->code = 'HTTP/1.1 404 Not Found';
                break;
            
            case 403:
                $this->code = 'HTTP/1.1 403 Forbidden';
                break;
            
            default:
                $this->code = 'HTTP/1.1 200 OK';
                break;
        }
    }

    public function getHeaderResponseCode(){
        return $this->code;
    }

}