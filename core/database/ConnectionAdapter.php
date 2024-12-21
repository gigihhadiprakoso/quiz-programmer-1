<?php

namespace Core\Database;

abstract class ConnectionAdapter {

    protected $connection;

    public function __construct($host, $user, $password, $database, $port) {
        $this->connect($host, $user, $password, $database, $port);
    }

    abstract protected function connect($host, $user, $password, $database, $port);

    abstract protected function query($sql);

    abstract protected function lastID();

    abstract protected function errorCode();

    abstract protected function errorMsg();

    abstract protected function fetchAssoc($result);

    public function getMany($sql) {
        $result = $this->query($sql);
        $data = [];
        while ($row = $this->fetchAssoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getRow($sql) {
        $result = $this->query($sql);
        return $this->fetchAssoc($result);
    }
}