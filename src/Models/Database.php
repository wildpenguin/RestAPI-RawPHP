<?php
/**
 * Implement MySQL database queries
 */

namespace API\Models;


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
        $this->username = 'db_user';
        $this->password = 'abc123';
    
        try {
            $this->conn = new \PDO("mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname=restapi", $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (\PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
       
        return $this->conn;
    }
    
}
?>