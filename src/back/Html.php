<?php 

namespace Back;
use src\Config as Config;

class Html extends Response implements ResponseInterface {

    public function headers(){
        header('Content-Type: text/html; charset=utf-8');
    }

    public function send(){
        
        $html = file_get_contents('../app/page/'.$this->controller->getPage().".html");
        $url = _url();

        if($url[strlen($url) - 1] == '/') $url = substr($url, 0, -1);
        
        foreach ($this->controller->getData() as $key => $value) 
            $html = str_replace('{$'.$key.'}', $value, $html);
        
        $html = str_replace('.{__URL__}', $url, $html);
        $html = str_replace('{__URL__}', $url, $html);
        
        $html = str_replace('{__app_name__}', Config::get()['name'], $html);
        $html = str_replace('{__title__}', $this->controller->getTitle(), $html);
        $html = str_replace('{__metas__}', $this->getMetasTags(), $html);

        if(Config::is_in_production()) $html = str_replace('"{__status__}"', "true", $html);
        if(Config::use_alternative()) $html = str_replace('"{__not_use_alternative__}"', "true", $html);

        $html = str_replace('\\$', '$', $html);
        echo $html;
    }

    private function getMetasTags(){
        
        $strMetas = "";
        $metas = $this->controller->getMetas();
        foreach ($metas as $name => $content) {
            $strMetas = $strMetas."<meta name=\"$name\" content=\"$content\">";
        }
        return $strMetas;
    }

}