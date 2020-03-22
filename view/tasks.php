<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/icon.png"/>
    <title>TaskBook</title>
</head>
<body>
<div class="container-fluid">
    <div class="row ml-5">
        <h1><strong><a href="/" style="text-decoration: none; color: black" ">Task List</a></strong></h1>
    </div>

    <div class="row">
        <p class="ml-5">
            <a href="new" class="btn btn-primary">Create</a>
        </p>
        <?php if (isset($_SESSION['admin'])) : ?>
            <p class="ml-5">
            <form action="logout" method="post">
                <button class="btn btn-danger">Logout</button>
            </form>
            </p>
        <?php else : ?>
            <p class="ml-5">
                <a href="login" class="btn btn-success">Login</a>
            </p>
        <?php endif; ?>
        <p class="ml-5">
        <div class="p-2"><h3><?= isset($_SESSION['admin']) ? 'Админ' : 'Обычный пользователь' ?></h3></div>
        </p>
        <?= (new FlashMessages())->display(); ?>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th scope="col">
                    <a href="?<?= http_build_query(['orderby' => 'username', 'direct' => $directButton] + $_GET) ?>">
                        Имя пользователя
                        <div style="display: inline">
                            <?php if (isset($_GET['orderby'])
                                && $_GET['orderby'] == 'username'
                                && isset($_GET['direct'])
                                && $_GET['direct'] == 'asc') : ?>
                                ↓
                            <?php elseif (isset($_GET['orderby'])
                                && $_GET['orderby'] == 'username'
                                && isset($_GET['direct'])
                                && $_GET['direct'] == 'desc') : ?>
                                ↑
                            <?php endif; ?>
                        </div>
                    </a>
                </th>
                <th scope="col">
                    <a href="?<?= http_build_query(['orderby' => 'email', 'direct' => $directButton] + $_GET) ?>">Email</a>
                    <div style="display: inline">
                        <?php if (isset($_GET['orderby'])
                            && $_GET['orderby'] == 'email'
                            && isset($_GET['direct'])
                            && $_GET['direct'] == 'asc') : ?>
                            ↓
                        <?php elseif (isset($_GET['orderby'])
                            && $_GET['orderby'] == 'email'
                            && isset($_GET['direct'])
                            && $_GET['direct'] == 'desc') : ?>
                            ↑
                        <?php endif; ?>
                    </div>
                </th>
                <th scope="col">Текст задачи</th>
                <th scope="col">Действия</th>
                <th scope="col">
                    <a href="?<?= http_build_query(['orderby' => 'done', 'direct' => $directButton] + $_GET) ?>">Статус</a>
                    <div style="display: inline">
                        <?php if (isset($_GET['orderby'])
                            && $_GET['orderby'] == 'done'
                            && isset($_GET['direct'])
                            && $_GET['direct'] == 'asc') : ?>
                            ↓
                        <?php elseif (isset($_GET['orderby'])
                            && $_GET['orderby'] == 'done'
                            && isset($_GET['direct'])
                            && $_GET['direct'] == 'desc') : ?>
                            ↑
                        <?php endif; ?>
                    </div>
                </th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($tasks as $task) : ?>
                <tr>
                    <td style="max-width: 13em; word-wrap: break-word"><?= htmlentities($task->username); ?></td>
                    <td style="max-width: 13em; word-wrap: break-word"><?= htmlentities($task->email); ?></td>
                    <td style="max-width: 20em; word-wrap: break-word"><?= htmlentities($task->text); ?></td>
                    <td style="max-width: 13em; word-wrap: break-word">
                        <a class="btn btn-info" href="show/<?= $task->id; ?>">View</a>
                        <?php if (isset($_SESSION['admin'])) : ?>
                            <a class="btn btn-success" href="edit/<?= $task->id; ?>">Update</a>
                            <form action="delete/<?= $task->id; ?>" method="post" class="d-inline">
                                <button class="btn btn-danger" href="delete/<?= $task->id; ?>">Delete</button>
                            </form>
                        <?php endif; ?>

                        <?php if ($task->edited) : ?>
                            <div>Отредактировано администратором</div>
                        <?php endif; ?>
                    </td>
                    <td style="max-width: 13em; word-wrap: break-word">
                        <?php if (isset($_SESSION['admin'])) : ?>
                            <form id="done" action="done/<?= $task->id; ?>" method="post" class="d-inline">
                                <label>
                                    <input type="checkbox" name="done"
                                           value="<?= $task->id; ?>"
                                           onChange="this.form.submit()" <?= $task->done ? 'checked' : '' ?> >

                                </label>
                            </form>
                        <?php endif; ?>

                        <?= $task->done ? 'Выполнено' : 'Не Выполнено' ?>
                    </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation" class="ml-5">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(['page' => 1] + $_GET) ?>">First</a>
                </li>
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="?<?= $page <= 1 ? '' : http_build_query(['page' => $page - 1] + $_GET) ?>"
                    >Prev</a>
                </li>
                <li class="page-item active">
                    <a class="page-link"><?= $page ?></a>
                </li>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link"
                       href="?<?= $page >= $totalPages ? '' : http_build_query(['page' => $page + 1] + $_GET) ?>"
                    >Next</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?<?= http_build_query(['page' => $totalPages] + $_GET) ?>">Last</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
</body>
</html>

