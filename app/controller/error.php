<?php 
/**
 * Error Controller
 */

return function($code){

    self::headerResponseCode($code);
    self::page('error');
    self::data([
        'code' => $code
    ]);
    
};