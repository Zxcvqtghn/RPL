<?php

class Database
{
    private $host = "localhost";
    private $db_name = "mesketch";
    private $username = "root";
    private $password = "";

    public function getConnection()
    {
        try {
            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->db_name
            );

            // Set charset to utf8mb4 for better emoji/special char support
            $this->conn->set_charset("utf8mb4");

            // Check connection
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }

            return $this->conn;

        } catch (Exception $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

function getDB()
{
    $database = new Database();
    return $database->getConnection();
}
?>