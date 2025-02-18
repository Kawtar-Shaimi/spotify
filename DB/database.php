<?php
class Database {
    private $host = "localhost";
    private $db_name = "Spotify";
    private $username = "root";
    private $password = "password";
    private $conn;

    public function connect() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $this->conn;
    }
}

$db = (new Database)->connect();