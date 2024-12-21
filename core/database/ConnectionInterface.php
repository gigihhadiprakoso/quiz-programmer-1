<?php

namespace Core\Database;

interface ConnectionInterface {
    public function connect($host, $username, $password, $database, $port);
}