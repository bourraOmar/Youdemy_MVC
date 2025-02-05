<?php

Class Controller {
    //model Controller
    public function model($model){
        require_once '/app/models' . $model . '.php';

        return new $model();
    }

    //view Controller
    public function view($view, $data = []){
        // check if view is exist
        if (file_exists('../app/views/'. $view .'.php')){
            require_once '../app/views/'. $view .'.php';
        }else{
            die("View doesn't exist");
        }
    }
}
