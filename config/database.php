<?php

class Database
{
    private $hostname;
    private $username;
    private $password;
    private $dbname;

    private $conn;

    public function connect()
    {

        $this->hostname = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->dbname = 'rest_php_api';

        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            // print_r($this->conn->connect_error);
            return $this->conn->connect_error;
            exit;
        }
        return $this->conn;
        // print_r($this->conn);
    }

}

// $db = new Database;

// $db->connection();



?>