<?php

namespace Modules\Api\Controllers;

use Classes\Controller;

class WelcomeController extends Controller{

    public function show(){
        var_dump('asik');
        die();
        // $this->view('welcome',['time'=>date('Y-m-d')]);
    }
}