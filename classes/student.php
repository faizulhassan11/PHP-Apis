<?php

class Student
{
    public $name;
    public $email;
    public $mobile;
    public $id;

    private $conn;

    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->table_name = "tbl_students";
    }

    public function create()
    {
        // Corrected SQL query with proper syntax
        $query = "INSERT INTO " . $this->table_name . " (name, email, mobile) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));

        // Bind parameters
        $stmt->bind_param("sss", $this->name, $this->email, $this->mobile);

        // Check if any of the fields are not empty
        if (!empty($this->name) && !empty($this->email) && !empty($this->mobile)) {
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
        return false; // Return false if any of the fields are empty
    }
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            // Fetch the result
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }


    public function read_single_record()
    {
        if (!empty($this->id)) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);

            $stmt->bind_param("i", $this->id);
            if ($stmt->execute()) {
                // Fetch the result
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        }
    }
    public function update()
    {
        if (!empty($this->id)) {
            // Initialize the query
            $query = "UPDATE " . $this->table_name . " SET ";
            $params = [];
            $types = '';

            // Check and add each field to the query if it is not empty
            if (!empty($this->name)) {
                $query .= "name=?,";
                $params[] = htmlspecialchars(strip_tags($this->name));
                $types .= 's';
            }
            if (!empty($this->email)) {
                $query .= "email=?,";
                $params[] = htmlspecialchars(strip_tags($this->email));
                $types .= 's';
            }
            if (!empty($this->mobile)) {
                $query .= "mobile=?,";
                $params[] = htmlspecialchars(strip_tags($this->mobile));
                $types .= 's';
            }

            // Remove the trailing comma
            $query = rtrim($query, ',');

            // Add the WHERE clause
            $query .= " WHERE id=?";
            $params[] = $this->id;
            $types .= 'i';

            // Prepare the statement
            $stmt = $this->conn->prepare($query);

            // Bind the parameters
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            // Execute the statement
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function delete_single_record()
{
    if (!empty($this->id)) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}




}