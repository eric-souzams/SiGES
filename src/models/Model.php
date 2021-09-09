<?php

class Model extends Database
{

    protected static $table = "";
    protected static $columns = [];
    protected $values = [];

    public function deleteById($id)
    {
        try {
            $query = "DELETE FROM " . static::$table . " WHERE id = :id";

            $result = $this->connection->prepare($query);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->execute();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

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

            $result = $this->connection->prepare($query);
            $result->bindParam(':userId', $userId, PDO::PARAM_INT);
            $result->bindParam(':date', $date, PDO::PARAM_STR);
            $result->execute();

            $data = $result->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return false;
            }

            $calledClass = get_called_class();
            $class = new $calledClass();
            $class->loadData($data);

            return $class;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function insert()
    {
        try {
            $query = "INSERT INTO " . static::$table
                . "( " . implode(",", static::$columns) . ") VALUES (";
            foreach (static::$columns as $column) {
                $query .= static::getFormatedValue($this->getValue($column)) . ",";
            }
            $query[strlen($query) - 1] = ')';

            $result = $this->connection->prepare($query);

            print_r($result);
            //exit();

            $result->execute();

            $id = $this->connection->lastInsertId('id');

            $this->setValue('id', $id);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function update()
    {
        try {
            $query = "UPDATE " . static::$table . " SET ";
            foreach (static::$columns as $column) {
                $query .= " ${column} = " . static::getFormatedValue($this->getValue($column)) . ",";
            }
            $query[strlen($query) - 1] = ' ';
            $query .= "WHERE id = {$this->getValue('id')}";

            $result = $this->connection->prepare($query);
            $result->execute();
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

    public function findByUser($id, $date1, $date2)
    {
        try {
            $query = "SELECT * FROM " . static::$table . "  WHERE user_id = :id AND work_date BETWEEN :date1 and :date2";

            $result = $this->connection->prepare($query);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->bindParam(':date1', $date1, PDO::PARAM_STR);
            $result->bindParam(':date2', $date2, PDO::PARAM_STR);
            $result->execute();

            $data = [];
            if ($result) {
                $calledClass = get_called_class();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $class = new $calledClass();
                    $class->loadData($row);
                    //array_push($data, $class);
                    $data[$class->getValue('work_date')] = $class;
                }
            }

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findWorkedTime($date1, $date2)
    {
        try {
            $query = "SELECT SUM(worked_time) AS sum FROM " . static::$table . " WHERE work_date BETWEEN :date1 and :date2";

            $result = $this->connection->prepare($query);
            $result->bindParam(':date1', $date1, PDO::PARAM_STR);
            $result->bindParam(':date2', $date2, PDO::PARAM_STR);
            $result->execute();

            $data = $result->fetch(PDO::FETCH_ASSOC);
            if (!isset($data)) {
                return false;
            }

            return $data['sum'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getUsersCount()
    {
        try {
            $query = "SELECT COUNT(*) AS count FROM users WHERE end_date IS NULL";

            $result = $this->connection->prepare($query);
            $result->execute();

            $data = $result->fetch(PDO::FETCH_ASSOC);
            if (!isset($data)) {
                return false;
            }

            return $data['count'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getAllUsers()
    {
        try {
            $query = "SELECT id, name FROM " . static::$table;

            $result = $this->connection->prepare($query);
            $result->execute();

            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if (!isset($data)) {
                return false;
            }

            return $data;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findAllUsers()
    {
        try {
            $query = "SELECT * FROM " . static::$table;

            $result = $this->connection->prepare($query);
            $result->execute();

            $data = $result->fetchAll(PDO::FETCH_ASSOC);
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

    public function findAbsentUsers($today)
    {
        try {
            $query = "SELECT name FROM users WHERE end_date IS NULL AND id NOT IN 
                    ( SELECT user_id FROM working_hours WHERE work_date = :today AND time1 IS NOT NULL)";

            $result = $this->connection->prepare($query);
            $result->bindParam(':today', $today, PDO::PARAM_STR);
            $result->execute();

            $data = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row['name']);
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
                $cleanValue = $value;

                $cleanValue = strip_tags(trim($cleanValue));
                $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);

                $this->values[$key] = $cleanValue;
            }
        }
    }

    public function getValue($key)
    {
        return @$this->values[$key];
    }

    public function setValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function getValues()
    {
        return $this->values;
    }

    static function getFormatedValue($value)
    {
        if (is_null($value)) {
            return "null";
        } elseif ($value === '') {
            return "null";
        } elseif (gettype($value) === 'string') {
            return "'${value}'";
        } else {
            return $value;
        }
    }
}
