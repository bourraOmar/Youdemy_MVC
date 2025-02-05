<?php
// load config
require_once 'config/config.php';

//Autoload Libraries
spl_autoload_register(function ($className){
    require_once 'libraries/'.$className.'.php';
});
