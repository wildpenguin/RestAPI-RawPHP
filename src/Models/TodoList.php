<?php 
/**
 * The model class for TodoList
 * Contains items of TodoItems
 * 
 */
namespace API\Models;

use API\Models\Database;


class TodoList extends Database implements isRestful 
{
    private $id;
    private $name;
    private $user;

    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getUser()
    {
        return $user;
    }

    public function viewAll()
    {
        $query = $this->conn->prepare('SELECT id, name, user FROM todoList WHERE user=:user');
        $data = $query->execute($request['user']);

        return $data->fetchAll();
    }
    
    public function view($request)  
    {
        if (empty($id)) {
            $this->viewAll();
        }
        
        $query = $this->conn->prepare('SELECT id, name, user FROM todoList WHERE id=:id and user=:user');
        $data = $query->execute([$id, $user]);

        return $data->fetchAll();
    }

    public function create($data) {
        return 'create';
    }
    public function update($request, $data) {
        return 'update';
    }
    public function delete($request) {
        return 'delete';
    }

}