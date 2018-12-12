<?php
/**
 * Users management
 */
namespace API\Models;

use API\Models\Database;


class Users extends Database
{
     public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function isAuthenticated($user, $password)
    {
        // plain text passwords ;)
        $sql = <<< SQL
            SELECT user, password FROM apiUsers
            WHERE user=:user and password=:password
SQL;
        try {
            $query = $this->conn->prepare($sql);
            $query->execute([':user' => $user, ':password' => $password]);
            
            return (count($query->fetchAll()) === 1);
        } catch (\PDOException $e) {
            echo $e->getMessages();
        }
    }
}