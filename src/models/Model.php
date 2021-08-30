<?php

class Model extends Database
{

    protected static $table = "";
    protected static $columns = [];
    protected $values = [];

    public function findByEmail(string $email)
    {
        try {
            $query = "SELECT * FROM " . static::$table . " WHERE email = :email";

            $result = $this->connection->prepare($query);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->execute();

            $data = $result->fetch(PDO::FETCH_ASSOC);
            if (!isset($data)) {
                return false;
            }

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findByUserAndDate($userId, $date)
    {
        try {
            $query = "SELECT * FROM " . static::$table . " WHERE user_id = :userId AND work_date = :date";
            //SELECT * FROM working_hours WHERE user_id = 1 and work_date = '2021-08-30';

            $result = $this->connection->prepare($query);
            $result->bindParam(':userId', $userId, PDO::PARAM_INT);
            $result->bindParam(':date', $date, PDO::PARAM_STR);
            $result->execute();
            
            $data = $result->fetch(PDO::FETCH_ASSOC);
            if (!isset($data)) {
                return false;
            }
            
            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function save()
    {
        try {
            $query = "INSERT INTO " . static::$table
                . "( " . implode(",", static::$columns) . ") VALUES (";
            foreach (static::$columns as $column) {
                $query .= static::getFormatedValue($this->getValue($column)) . ",";
            }
            $query[strlen($query) - 1] = ')';

            $result = $this->connection->prepare($query);
            $result->execute();

            $id = $this->connection->lastInsertId();
            $this->id = $id;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function find(int $id)
    {
        try {
            $query = "SELECT * FROM " . static::$table . " WHERE id = :id";

            $result = $this->connection->prepare($query);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->execute();

            $data = $result->fetch(PDO::FETCH_ASSOC);
            if (!isset($data)) {
                return false;
            }

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findAll()
    {
        try {
            $query = "SELECT * FROM " . static::$table;

            $result = $this->connection->prepare($query);
            $result->execute();

            $data = [];
            if ($result) {
                $calledClass = get_called_class();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $class = new $calledClass();
                    $class->loadData($row);
                    array_push($data, $class);
                }
            }

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function loadData($data)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->values[$key] = $value;
            }
        }
    }

    public function getValue($key)
    {
        return $this->values[$key];
    }

    public function setValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    static function getFormatedValue($value)
    {
        if (is_null($value)) {
            return "null";
        } elseif (gettype($value) === 'string') {
            return "'${value}'";
        } else {
            return $value;
        }
    }
}
