<?php

namespace Core\Database\Drivers;

use Core\Database\ConnectionAdapter;

class Connection_PostgreSQL extends ConnectionAdapter {

    private $result;
    private $__id;
    
    protected function connect($host, $user, $password, $dbname, $port) {
        $this->connection = pg_connect("host=$host dbname=$dbname user=$user password=$password port=$port");
        if (!$this->connection) {
            throw new \Exception("PostgreSQL Connection failed.");
        }
    }

    public function query($sql) {
        $this->result = pg_query($this->connection, $sql);
        // $__assoc = pg_fetch_assoc($this->result);
        if(strstr(strtolower($sql), "returning")) {
            list(, $this->__id) = explode("returning", strtolower($sql));
        }

        if (!$this->result) {
            throw new \Exception("PostgreSQL Query failed: " . pg_last_error($this->connection));
        }

        return $this->result;
    }

    public function lastID() {
        $__assoc = pg_fetch_assoc($this->result);
        $__row = [];
        foreach (explode(",", $this->__id) as $id) {
            $__row[] = $__assoc[trim($id)];
        }
        return $__row;
    }

    public function errorCode() {
        $error_message = pg_last_error($this->connection);
        if(preg_match('/SQLSTATE\[(\w+)\]/', $error_message, $matches)) 
            return $matches[1];

        return 0;
    }

    public function errorMsg() {
        return pg_last_error($this->connection);
    }

    protected function fetchAssoc($result) {
        return pg_fetch_assoc($result);
    }
}
