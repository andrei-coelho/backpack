<?php 

function _url(string $url = ""){
    return src\Config::url().$url;
}

function _error($num = 404){
    
}

function _dateToBr($data){
    return date('d/m/Y', strtotime($data));
}

function _controller(){
    return Back\Controller::get(...func_get_args());
}
