<?php

namespace Core\Database;

use Core\Database\Drivers\Connection_MySQL;
use Core\Database\Drivers\Connection_PostgreSQL;

class DatabaseManager {
    private static $instances = [];

    public static function getConnection(array $config) {
        $driver = $config['driver'] ?? 'mysql';
        $key = md5(serialize($config));

        // Jika koneksi sudah ada, gunakan kembali
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = self::createConnection($driver, $config);
        }

        return self::$instances[$key];
    }

    private static function createConnection($driver, $config) {
        switch (strtolower($driver)) {
            case 'mysql':
                return new Connection_MySQL(
                    $config['hostname'],
                    $config['username'],
                    $config['password'],
                    $config['dbname'],
                    $config['port']
                );
            case 'pgsql':
                return new Connection_PostgreSQL(
                    $config['hostname'],
                    $config['username'],
                    $config['password'],
                    $config['dbname'],
                    $config['port']
                );
            default:
                throw new \Exception("Unsupported database driver: $driver");
        }
    }
}


/* class Factory {

    protected $host;
    protected $user;
    protected $pass;
    protected $db;
    protected $port;

    public function __construct($driver, $host, $user, $pass, $db, $port) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
        $this->port = $port;
            
        return $this->__init__($driver);
    }

    protected function __init__($_driver) {
        switch ($_driver) {
            case 'mysql':
                $classObj = new Connection_MySQL($this->host, $this->user, $this->pass, $this->db, $this->port);
                break;
            case 'pgsql':
                $classObj = new Connection_PostgreSQL($this->host, $this->user, $this->pass, $this->db, $this->port);
                break;
            default:
                throw new \Exception("Factory connection database failed", 1);
                break;
        }

        return $classObj;
    }

    protected function __mapDriverName__($drv){
        switch ($drv) {
            case 'mysql':
                return 'MySQL';
                break;
            case 'pgsql':
                return 'PostgreSQL';
                break;
        }
    }

} */


