<?php

namespace Classes;

use Classes\Loader;

class Controller {
    protected $model;
    private $load;

    public function __construct(){
        $this->load = new Loader();
    }

    protected function setRecord(){

    }

    protected function view($filename_view, $data=array()){
        list($dir, $module) = $this->getModuleClass();
        $data['pagement'] = [
            'path_view' => getcwd()."/".strtolower($dir)."/".strtolower($module)."/views/",
        ];
        $this->load->view($filename_view, $data);
    }

    private function getModuleClass(){
        $classname = get_class($this);
        return explode("\\",$classname);
    }
}