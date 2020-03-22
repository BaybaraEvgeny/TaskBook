<?php
require_once 'model/Autoloader.php';
require_once ROOT_PATH . '/model/TasksService.php';

class TasksController
{

    private $TasksService = null;

    public function __construct()
    {
        $this->TasksService = new TasksService();
    }

    private function redirect($location)
    {
        header('Location: ' . $location);
    }

    public function listTasks()
    {
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : null;
        $page = isset($_GET['page']) ? $_GET['page'] : null;
        $directGet = isset($_GET['direct']) ? $_GET['direct'] : null;

        $data = $this->TasksService->getAllTasks($orderby, $page, $directGet);

        $tasks = $data['tasks'];
        $totalPages = $data['total_pages'];
        $page = $data['page'];

        if (isset($_GET['direct']) && $_GET['direct'] === 'asc') {
            $directButton = 'desc';
        } else {
            $directButton = 'asc';
        }

        include ROOT_PATH . '/view/tasks.php';
    }

    public function saveTask()
    {
        $userName = '';
        $email = '';
        $text = '';

        $errors = array();

        if (isset($_POST['form-submitted'])) {
            $userName = isset($_POST['username']) ? trim($_POST['username']) : null;
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            $text = isset($_POST['text']) ? trim($_POST['text']) : null;

            try {
                $this->TasksService->createNewTask($userName, $email, $text);
                (new FlashMessages())->success('Задача успешно добавлена', null, true);
                $this->redirect('/');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }

        include ROOT_PATH . '/view/create.php';
    }

    public function editTask($id)
    {
        if (!$this->checkAccess()) {
            (new FlashMessages())->error('Недостаточно прав', null, true);
            $this->redirect('/');
            return;
        }
        $task = $this->TasksService->getTask($id);

        $errors = array();

        if (isset($_POST['form-submitted'])) {
            $text = isset($_POST['text']) ? trim($_POST['text']) : null;

            try {
                $this->TasksService->editTask($text, $id);
                (new FlashMessages())->success('Задача успешно изменена', null, true);
                $this->redirect('/');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
        include ROOT_PATH . '/view/update.php';
    }

    public function deleteTask($id)
    {
        if (!$this->checkAccess()) {
            (new FlashMessages())->error('Недостаточно прав. Необходима авторизация', null, true);
            $this->redirect('/');
            return;
        }
        $this->TasksService->deleteTask($id);

        (new FlashMessages())->success('Задача успешно удалена', null, true);
        $this->redirect('/');
        return;

    }

    public function showTask($id)
    {
        $errors = array();

        $task = $this->TasksService->getTask($id);

        include ROOT_PATH . '/view/show.php';
    }

    public function getDone($id)
    {
        if (!$this->checkAccess()) {
            (new FlashMessages())->error('Недостаточно прав. Необходима авторизация', null, true);
            $this->redirect('/');
            return;
        }
        if ($this->TasksService->getDone($id)) {
            (new FlashMessages())->success('Задача успешно выполнена', null, true);
        } else {
            (new FlashMessages())->error('Задача уже была выполнена', null, true);
        }

        $this->redirect('/');
    }

    public function showError()
    {
        echo 'Error 404 Page Not Found';
    }

    public function checkTable()
    {
        $this->TasksService->createTable();
    }

    public function login()
    {
        if ($this->checkAccess()) {
            (new FlashMessages())->info('Вы уже вошли', null, true);
            $this->redirect('/');
            return;
        }
        $login = '';
        $password = '';

        $errors = array();

        if (isset($_POST['form-submitted'])) {
            $login = isset($_POST['login']) ? trim($_POST['login']) : null;
            $password = isset($_POST['password']) ? trim($_POST['password']) : null;

            try {
                $this->TasksService->login($login, $password);
                (new FlashMessages())->success('Вы успешно вошли', null, true);
                $this->redirect('/');
                return;
            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }

        include ROOT_PATH . '/view/login.php';
    }

    public function logout()
    {
        if (!$this->checkAccess()) {
            (new FlashMessages())->error('Недостаточно прав', null, true);
            $this->redirect('/');
            return;
        }
        $this->TasksService->logout();

        (new FlashMessages())->success('Вы успешно вышли', null, true);
        $this->redirect('/');
    }

    private function checkAccess()
    {
        return $this->TasksService->checkAccess();
    }
}
