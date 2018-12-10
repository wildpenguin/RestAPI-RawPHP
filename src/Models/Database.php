<?php
/**
 * Implement MySQL database queries
 */

namespace API;

$config = include('.config.php');

class Database 
{
    // specify your own database credentials
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn = null;
 
    // get the database connection
    public function getConnection()
    {
        if ($this->conn) {
            return $this->conn;
        }
        // these needs to be moved to a separate config file
        $this->host = 'localhost';
        $this->db_name = 'restapi';
        $this->username = 'user1';
        $this->password = 'abc123';
    
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }

    
}
?>