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
    private $userId;
    private $conn;

    public function __construct()
    {
        $this->conn = $this->getConnection();
    }
    /**
     * Display all lists for current user
     * @return array
     */
    public function viewAll($request)
    {
        $sql = <<< SQL
        SELECT l.id, l.name FROM todoList l 
        JOIN apiUsers u ON (l.userId=u.id) 
        WHERE u.user=:user
SQL;
        $query = $this->conn->prepare($sql);
        $query->execute([':user' => $request->user]);

        $data = $query->fetchAll();
       
        return count($data) > 0 ? $data : 'Empty list';
    }
    
    /**
     * View specific list by Id
     * @return array
     */
    public function view($request)  
    {
        if (empty($request->id)) {
            return $this->viewAll($request);
        }
        
        $sql = <<< SQL
        SELECT id, name, user FROM todoList l
        JOIN todoItem i ON (i.listId=l.id)
        JOIN apiUsers u ON (u.id=l.userId)
        WHERE id=:id and user=:user
SQL;
        $query = $this->conn->prepare($sql);
        $query->execute([':id' => $request->id, ':user' => $request->user]);

        return $query->fetchAll();
    }

    /**
     * Create a new Todo List
     * @return array status and list Id
     */
    public function create($request, $params) {
       $data = $params['data'];
        if (!$data['name']) {
            throw new \Exception('Missing name from TodoList!');
        }
        $sql = <<< SQL
        INSERT IGNORE INTO todoList (name, userId) 
        VALUES (:name, (SELECT id FROM apiUsers WHERE user=:user))
SQL;
        try {
            $query = $this->conn->prepare($sql);
            $query->execute([':name' => $data['name'], ':user' => $request->user]);

            return [
                'status' => 'OK', 
                //'id' => $this->conn->lastInsertId
            ];
        } catch (\PDOException $e) {
            return [
                'status' => 'ERROR',
                'error' => $e->getMessage()
            ];
        }
    }

    public function update($request, $data) {
        return 'update';
    }
    public function delete($request) {
        return 'delete';
    }

}