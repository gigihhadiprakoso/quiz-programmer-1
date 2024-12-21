<?php

namespace Classes;

use Classes\Error;
use Classes\Request;

class Route {

    const POST = 'POST';
    const GET = 'GET';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    private $routes = array();
    private $param;
    private $module_default = 'web';
    private $module;
    private $_error;

    public function __construct(){
        $this->_error = new Error();
    }

    public function register($method, $endpoint, $controller_function){
        list($controller, $function) = explode('@', $controller_function);
        $_route = array(
            'method' => strtoupper($method),
            'endpoint' => $this->setDefaultPrefix($endpoint, $this->module),
            'controller' => $controller,
            'function' => $function,
            'module' => $this->module
        );

        $this->isRouteTaken($method, $this->setDefaultPrefix($endpoint, $this->module));

        array_push($this->routes, $_route);
    }

    public function getRoute(){
        return $this->routes;
    }

    public function access($method, $endpoint){
        $keys_routes = array_keys(array_column($this->routes, 'method'), $method);

        foreach($keys_routes as $key){
            $path = $this->routes[$key];

            if(strpos($path['endpoint'],":") !== false){
                list($endpoint_, $key) = explode("/",trim($path['endpoint'],'/'));

                $uri = explode("/",trim($endpoint,"/"));
                $tmp_endpoint = $uri[0];
                $id = isset($uri[1]) ? $uri[1] : null; 
            }else {
                $endpoint_ = $path['endpoint'];
                $tmp_endpoint = $endpoint;
            }

            if($tmp_endpoint == $endpoint_){
                if(strpos($key,":") !== false && ($this->isGET($method) || $this->isPUT($method)))
                    $this->param[trim($key,":")] = $id;

                $this->call($path['module'], $path['controller'], $path['function']);
                die;
            }
        }

        $this->_error->error404();
    }

    public function call($module, $controller, $function){
        $request = new Request();

        parse_str(file_get_contents('php://input'), $_input);
        $request->setInput($_input);
        
        if($this->param){
            $request->appendInput($this->param);
        }

        $module_camelcase = ucwords($module);
        $class = "\\Modules\\{$module_camelcase}\\Controllers\\$controller";
        $called_controller = new $class();
        $called_controller->{$function}($request);
    }

    private function setDefaultPrefix($endpoint, $module) {
        return ($module == 'api' ? 'api' : '') . $endpoint;
    }

    private function isRouteTaken($method, $endpoint) {
        if(in_array($endpoint, array_column($this->routes, 'endpoint')) && 
            in_array(strtoupper($method), array_column($this->routes, 'method'))){
                $this->_error->errorCustom('Error: found same route with endpoint and method.');
        }
    }

    public function get($endpoint, $controller_function){
        $this->register('get', $endpoint, $controller_function);
    }

    public function post($endpoint, $function_controller){
        $this->register('post', $endpoint, $function_controller);
    }

    public function put($endpoint, $function_controller){
        $this->register('put', $endpoint, $function_controller);
    }

    public function delete($endpoint, $function_controller){
        $this->register('delete', $endpoint, $function_controller);
    }

    private function isGET($method){
        return self::GET==$method;
    }

    private function isPOST($method){
        return self::POST==$method;
    }

    private function isPUT($method){
        return self::PUT==$method;
    }

    private function isDELETE($method){
        return self::DELETE==$method;
    }

    public function setRouteModule($module){
        $this->module = $module;
    }

    public function navigate($path = null) {
        $this->access(self::GET, $path);
    }
}