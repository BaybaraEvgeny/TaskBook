<?php
require 'Database.php';

class TasksGateway extends Database
{

    public function selectAll($order, $page, $direct)
    {
        if (!isset($direct) || $direct !== 'desc') {
            $direct = 'asc';
        }

        if (!isset($order)) {
            $order = '';
        } else {
            $order = "ORDER BY $order $direct";
        }
        if (!isset($page)) {
            $page = 1;
        }


        $pdo = Database::connect($order);

        $no_of_records_per_page = 3;
        $total_pages_sql = "SELECT COUNT(*) AS count FROM tasks";
        $result = $pdo->prepare($total_pages_sql);
        $result->execute();
        $total_rows = $result->fetch(PDO::FETCH_OBJ)->count;
        if (!is_numeric($page) || $page <= 0 || $page > $total_rows) {
            $page = 1;
        }
        $offset = ($page - 1) * $no_of_records_per_page;
        $total_pages = (int)ceil($total_rows / $no_of_records_per_page);

        $sql = $pdo->prepare("SELECT * FROM tasks $order LIMIT $offset, $no_of_records_per_page");
        $sql->execute();
        // $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        $tasks = array();
        while ($obj = $sql->fetch(PDO::FETCH_OBJ)) {
            $tasks[] = $obj;
        }
        return ['tasks' => $tasks, 'total_pages' => $total_pages, 'page' => $page];
    }

    public function selectById($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $sql->bindValue(1, $id);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function insert($userName, $email, $text)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("INSERT INTO tasks(username, email, text, done, edited) VALUES(?, ?, ?, false, false)");
        $result = $sql->execute(array($userName, $email, $text));
    }

    public function edit($text, $id)
    {
        $pdo = Database::connect();

        $check = $pdo->prepare("SELECT text FROM tasks WHERE id = ? LIMIT 1");
        $check->execute(array($id));
        $result = $check->fetch(PDO::FETCH_OBJ)->text;

        if ($result === $text) {
            return;
        } else {
            $sql = $pdo->prepare("UPDATE tasks SET text = ?, edited = true WHERE id = ? LIMIT 1");
            $sql->execute(array($text, $id));
        }

    }

    public function delete($id)
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("DELETE FROM tasks WHERE id =?");
        $sql->execute(array($id));
    }

    public function getDone($id)
    {
        $pdo = Database::connect();
        $check = $pdo->prepare("SELECT done FROM tasks WHERE id = ?");
        $check->bindValue(1, $id);
        $check->execute();
        $check_result = $check->fetch(PDO::FETCH_OBJ)->done;
        if ($check_result) {
            return 0;
        } else {
            $sql = $pdo->prepare("UPDATE tasks SET done = true WHERE id = ? LIMIT 1");
            $result = $sql->execute(array($id));
            return 1;
        }
    }

    public function createTable()
    {
        $pdo = Database::connect();
        $sql = $pdo->prepare("CREATE TABLE IF NOT EXISTS tasks(
            id int AUTO_INCREMENT PRIMARY KEY,
            username varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            text varchar(255) NOT NULL,
            done boolean,
            edited boolean
        )");
        $sql->execute();
    }

}
