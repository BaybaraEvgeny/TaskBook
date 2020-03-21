<?php

require_once 'TasksGateway.php';
require_once 'ValidationException.php';
require_once 'Database.php';

class TasksService extends TasksGateway
{

    private $tasksGateway = null;

    public function __construct()
    {
        $this->tasksGateway = new TasksGateway();
    }

    public function getAllTasks($order, $page, $direct)
    {
        $result = $this->tasksGateway->selectAll($order, $page, $direct);

        return $result;
    }

    public function getTask($id)
    {
        $result = $this->tasksGateway->selectById($id);

        return $this->tasksGateway->selectById($id);
    }

    private function validateTaskParams($userName, $email, $text)
    {
        $errors = array();

        if (!isset($userName) || empty($userName)) {
            $errors[] = 'Имя не указано';
        }
        if (!isset($email) || empty($email)) {
            $errors[] = 'E-mail не указан';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "E-mail адрес указан неверно.\n";
        }
        if (!isset($text) || empty($text)) {
            $errors[] = 'Текст не указан';
        }
        if (empty($errors)) {
            return;
        }
        throw new ValidationException($errors);
    }

    public function createNewTask($userName, $email, $text)
    {
        $this->validateTaskParams($userName, $email, $text);
        $result = $this->tasksGateway->insert($userName, $email, $text);
        return $result;
    }

    public function editTask($text, $id)
    {
        $errors = array();

        if (!isset($text) || empty($text)) {
            $errors[] = 'Текст не указан';
        }
        if (!empty($errors)) {
            throw new ValidationException($errors);
            return;
        }

        $result = $this->tasksGateway->edit($text, $id);
    }

    public function deleteTask($id)
    {
        $result = $this->tasksGateway->delete($id);
    }

    public function getDone($id)
    {
        return $this->tasksGateway->getDone($id);
    }

    public function createTable()
    {
        $result = $this->tasksGateway->createTable();
    }

    public function login($login, $password)
    {
        $errors = array();

        if ($login === 'admin' && $password === '123') {
            $_SESSION['admin'] = true;
        } else {
            $errors[] = 'Некорректные данные';
            throw new ValidationException($errors);
        }
    }

    public function logout()
    {
        unset($_SESSION['admin']);
    }

    public function checkAccess()
    {
        if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) return true;
        else return false;
    }

}
