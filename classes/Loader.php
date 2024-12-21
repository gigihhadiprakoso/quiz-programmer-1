<?php

namespace Classes;

use Classes\App;

class Loader {

    private $app;

    function __construct(){
        
    }

    public function setApp(App $app){
        $this->app = $app;
    }

    public function model($name, $module){

    }

    public function controller($name, $module){

    }

    public function view($page, $data, $layout = 'default') {
        $page = $data['pagement']['path_view'] . $page . ".view.php";
        require_once $data['pagement']['path_view'] . "layouts/" . $layout . ".php";
    }

    public function routes($module) {
        return dirname(__DIR__).'/modules/'.$module.'/routes.php';
    }

    public function config(){

    }

    protected function listingFolder($dir) {
        $ffs = array_slice(scandir($dir),2);

        if(count($ffs) < 1)
            return [];

        $folder = [];
        foreach ($ffs as $ff) {
            if(is_dir($dir . '/' .$ff)){
                $folder[] = $dir . '/' .$ff;
                $folder = array_merge($folder, $this->listingFolder($dir . '/' .$ff));
            }
        }

        return $folder;
    }

    protected function getDirectoryLoad(){
        $core_dirs = $this->listingFolder(dirname(__DIR__) . '/core');
        foreach ($core_dirs as $k => $v) {
            $core_dirs[$k] = str_replace(dirname(__DIR__).'/', '', $v);
        }

        $directory_load = array('classes','helpers','core');
        $directory_load = array_merge($directory_load, $core_dirs);

        foreach($this->app->_config['modules'] as $module){
            $module_dirs = $this->listingFolder(dirname(__DIR__) . '/modules/' . $module);
            foreach ($module_dirs as $k => $v) {
                if(strstr($v, '/views')) {
                    unset($module_dirs[$k]);
                    continue;
                }

                $module_dirs[$k] = str_replace(dirname(__DIR__).'/', '', $v);
            }

            $directory_load = array_merge($directory_load, $module_dirs);
        }

        return $directory_load;
    }

    protected function getFileNotLoad(){
        return array(
            basename(__FILE__), 'App.php',
        );
    }

    public function autoload(){
        foreach($this->getDirectoryLoad() as $dir){
            $path = dirname(__DIR__) . '/'.$dir.'/';
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach($files as $file){
                if(in_array($file,$this->getFileNotLoad()) || is_dir($path.$file)) 
                    continue;

                require_once $path.$file;
            }
        }
    }

}