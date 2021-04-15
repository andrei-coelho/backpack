<?php 

use src\Config as Config;

return function(){

    # FUNÇÕES DE CONFIGURAÇÃO PARA RENDERIZAÇÃO

    self::data([
        "ola" => "mundo!"
    ]);
    self::page('home', []);
    

};