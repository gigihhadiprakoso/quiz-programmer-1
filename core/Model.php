<?php

namespace Core;

use Core\Database\ConnectionAdapter;
use Modules\Web\Models\LogTrx;

abstract class Model {
    protected static $connection;
    protected $attributes = [];
    protected $table;
    protected $primaryKey = 'id';

    public function __construct($attributes = []) {
        $this->attributes = $attributes;
    }

    public static function setConnection(ConnectionAdapter $connection) {
        static::$connection = $connection;
    }

    public function getTable() {
        return $this->table ?? strtolower(static::class) . 's';
    }

    public static function all() {
        $table = (new static())->getTable();
        $sql = "SELECT * FROM {$table}";
        $rows = static::$connection->getMany($sql);

        return array_map(fn($row) => new static($row), $rows);
    }

    public static function find($id) {
        $table = (new static())->getTable();
        
        $pk = static::getPrimaryKey();
        $id = explode("/", $id);

        $where_clause = [];
        foreach ($pk as $k => $col) {
            $where_clause[] = $col . " = " .$id[$k];
        }

        $sql = "SELECT * FROM {$table} WHERE " . implode(" AND ", $where_clause);
        $row = static::$connection->getRow($sql);

        return $row ? new static($row) : null;
    }

    public static function where($column, $operator, $value) {
        $table = (new static())->getTable();
        $sql = "SELECT * FROM {$table} WHERE {$column} {$operator} ?";
        $rows = static::$connection->getMany(str_replace('?', $value, $sql));

        return array_map(fn($row) => new static($row), $rows);
    }

    public function save() {
        $op_type = null;
        $table = $this->getTable();
        $columns = array_keys($this->attributes);
        $values = array_values($this->attributes);
        $where= [];

        $pk = static::getPrimaryKey();

        $id = [];
        foreach ($pk as $key) {
            if(!empty($this->attributes[$key])) 
                $id[] = $this->attributes[$key];
        }

        if(!empty($id))
            $row_exist = static::find(implode("/", $id));

        if (!empty($row_exist) && !empty($id)) {
            // Update
            $set = $where = [];
            foreach ($this->attributes as $key => $value) {
                $set[] = "$key = $value";
                if(in_array($key, $pk))
                    $where[] = "$key = $value";
            }
            $set_clause = implode(", ", $set);
            $where_clause = implode(" AND ", $where);
            $sql = "UPDATE {$table} SET {$set_clause} WHERE {$where_clause} RETURNING ".implode(", ", $pk);
            static::$connection->query($sql);
            $op_type = 'U';
        } else {
            // Insert
            $cols = implode(', ', $columns);
            $vals = implode("', '", $values);
            $sql = "INSERT INTO {$table} ({$cols}) VALUES ('{$vals}') RETURNING ".implode(", ", $pk);
            static::$connection->query($sql);
            $op_type = 'I';
        }
        $last_id = static::$connection->lastID();

        if(empty(static::$connection->errorCode())) {
            $log = new LogTrx();
            $old_data = !empty($row_exist) ? json_encode($row_exist->attributes) : null;
            $log->write(static::getTable(), $pk, $op_type, $old_data, json_encode($this->attributes));
        }

        static::afterSave($this->attributes, $last_id);
    }

    public function delete() {
        if (!isset($this->attributes['id'])) {
            throw new \Exception("Cannot delete a record without an ID");
        }
        $table = $this->getTable();
        $sql = "DELETE FROM {$table} WHERE id = ?";
        static::$connection->query(str_replace('?', $this->attributes['id'], $sql));
    }

    public function __get($name) {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value) {
        $this->attributes[$name] = $value;
    }

    protected static function getPrimaryKey() {
        $primary = (new static())->primaryKey;
        return (is_array($primary) ? $primary : array($primary));
    }

    protected static function afterSave($attributes, $id) {
        return null;
    }
}
