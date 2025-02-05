<?php

Class pages extends Controller {
    public function index(){
        $data = ['title' => "this is index page"];
        $this->view('pages/index', $data);
    }

    public function courses(){
        $data = ['title' => "this is courses page"];
        $this->view('pages/courses', $data);
    }
}
