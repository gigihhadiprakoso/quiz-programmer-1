<?php

namespace Core\Database\Drivers;

use Core\Database\ConnectionAdapter;

class Connection_MySQL extends ConnectionAdapter {

    protected function connect($host, $username, $password, $database, $port = '3306'){
        $this->connection = new \mysqli($host, $username, $password, $database, $port);

        if ($this->connection->connect_error) {
            throw new \Exception("MySQL Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            throw new \Exception("MySQL Query failed: " . $this->connection->error);
        }

        return $result;
    }

    public function lastID() {
        return $this->connection->insert_id;
    }

    public function errorCode() {
        return $this->connection->errno;
    }

    public function errorMsg() {
        return $this->connection->error;
    }

    protected function fetchAssoc($result) {
        return $result->fetch_assoc();
    }

}