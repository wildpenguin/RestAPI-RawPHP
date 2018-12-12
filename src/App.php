<?php

/**
 * Application class
 * provides API REST provisioning
 */
namespace API;

use API\Models\TodoList;
use API\Models\TodoItem;
use API\Models\Users;
use API\Models\isRestful;

class App
{
    private $config;

    /**
     * Class constructor
     */
    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * Launch the application to manage request
     * The format of the request should like /resource/{id}
     * @return json Data from models
     */
    public function start()
    {
        if (!$this->isAuthenticated()) {
            $this->render(401, ['message'=>'Please provide a valid user/password']);
        }

        $request = $this->parseUrl();
        if (!$request) {
            $this->render(200, ['message'=> 'To interact with API, please request these resourses: /todo or /item']);
        }

        $resource = $this->parseResourceName($request->resource);
        if (!$resource || !($resource instanceof isRestful)) {
            $this->render(404, ['message'=> 'Resource not found, please request these resourses: /todo or /item']);
        }

        $result = [];
        try {
            switch ($request->method) {
                case 'GET':
                    $result = $resource->view($request);
                    break;
                case 'POST':
                    $params = (array) json_decode(file_get_contents('php://input'), TRUE); // the only way to send json from Postman
                    $result = $resource->create($request, $params);
                    break;
                case 'PUT':
                    $result = $resource->update($request, $_POST['data']??[]);
                    break;
                case 'DELETE':
                    $result = $resource->delete($request);
                    break;
                default:
                    $this->render(405, ['message'=> 'Only GET, POST, PUT, DELETE methods are accepted!']);
            }
        } catch (\Exception $e) {
            $this->render(500, ['message' => 'Error occurred: '. $e->getMessage()]);
        }
        $this->render(200, ['message' => $result]);
        
    }

    /**
     * Searches the _SERVER for requested resources
     * 
     * @return stdObject
     */
    protected function parseUrl()
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"] ?? []; //GET, POST, PUT, DELETE
        $path = $_SERVER['PATH_INFO'] ?? [];
        $user = $_SERVER['PHP_AUTH_USER'];

        if (!$path) {
            return [];
        }
        $path = explode('/', substr($path, 1)); // remove first slash

        return (object) [
            'method' => $requestMethod, 
            'resource' => $path[0] ?? '',
            'id' => $path[1] ?? '',
            'user' => $user,
        ];
    }

    /**
     * Guess the resource from parsed URL
     * 
     * @return Model Resource model 
     */
    protected function parseResourceName($name) 
    {
        if (empty($name)) {
            return false;
        }
        // a more sophisticated way to guess class name is required
        switch (strtolower($name)) {
            case 'todo':
                return new TodoList();
            case 'item':
                return new TodoItem();
            default:
                return false;
        }

    }

    /**
     * Render response to client
     * @param http status code
     * @param array data
     */
    protected function render($httpStatus=200, $data=[])
    {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($httpStatus);
        echo json_encode($data);
        exit;
    }


    /**
     * Ask user to authenticate
     * @return boolean
     */
    protected function isAuthenticated()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="API zone"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Text to send if user hits Cancel button';
            exit;
        }
       
        $users = new Users();
        return $users->isAuthenticated($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
}

    
}