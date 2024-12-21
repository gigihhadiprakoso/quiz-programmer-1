<?php 

namespace Helpers;

class URL {

    /**
     * 
     */
    public static function base() {
        global $app;

        $config = $app->_config;

        $scheme = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http' ;

        if($config['app']['environment'] == 'development')
            $host = $config['app']['base_url'];
        else 
            $host = $_SERVER['HTTP_HOST'];

        $host = str_replace($scheme.'://', '', $host);

        return $scheme . "://" . $host;
    }

    /**
     * 
     */
    public static function asset($path = null) {
        return static::base() . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . $path;
    }

    public static function to($path) {
        header('Location: ' . static::base() . DIRECTORY_SEPARATOR . $path);
    }
}