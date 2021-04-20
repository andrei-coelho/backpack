<?php 

use src\Config as Config;

return function(){

    self::title(Config::get()['name']);
    self::meta('author', 'Andrei Coelho');
    self::meta('description', Config::get()['description']);
    self::data([
        "ola" => "mundo!"
    ]);
    self::page('home', []);
    
};