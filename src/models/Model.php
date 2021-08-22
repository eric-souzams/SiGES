<?php

class Model {

    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];

    public function __construct($data)
    {
        $this->loadData($data);
    }

    public function loadData($data) {
        if($data) {
            foreach($data as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function __get($key) {
        return $this->values[$key];
    }

    public function __set($key, $value) {
        $this->values[$key] = $value;
    }

}