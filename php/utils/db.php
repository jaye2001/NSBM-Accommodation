<?php

class DBConnection {
    private $host = 'localhost';
    private $dbname = 'nsbm_accommodation';
    private $username = 'root';
    private $password = 'mysql8811%%';
    private $conn;

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // return $this->conn;
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
      }

    public function get_conn() {
        return $this->conn;
    }

    public function disconnect() {
        $this->conn = null;
        echo "Disconnected successfully";
    }
}

?>
