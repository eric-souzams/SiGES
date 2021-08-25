<?php

require_once('../Config/database.php');

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
}
