<?php 

namespace Back;

class Html extends Response implements ResponseInterface {

    public function headers(){
        header('Content-Type: text/html; charset=utf-8');
    }

    public function send(){
        $html = file_get_contents('../app/page/'.$this->controller->getPage().".html");
        foreach ($this->controller->getData() as $key => $value) 
        $html = str_replace('{$'.$key.'}', $value, $html);
        $html = str_replace('.{__URL__}', _url(), $html);
        $html = str_replace('{__URL__}', _url(), $html);
        $html = str_replace('\\$', '$', $html);
        echo $html;
    }

}