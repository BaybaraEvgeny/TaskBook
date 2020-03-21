<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Update Task</title>
    <meta charset="utf-8">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/icon.png"/>
</head>

<body>
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Update task</h3>
                </div>

                <?php
                if ($errors) {
                    echo '<div class="alert alert-danger"><ul class="errors list-group">';
                    foreach ($errors as $field => $error) {
                        echo '<li class="">' . htmlentities($error) . '</li>';
                    }
                    echo '</ul></div>';
                }
                ?>

                <div class="card-body">
                    <form class="form-horizontal" action="/edit/<?= $id ?>" method="post">
                        <div class="form-group">
                            <label class="col-form-label text-md-right">Имя пользователя</label>
                            <div class="controls">
                                <div class="alert alert-dark" role="alert">
                                    <?php echo htmlentities($task->username); ?>
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label text-md-right">Email</label>
                            <div class="controls">
                                <div class="alert alert-dark" role="alert">
                                    <?php echo htmlentities($task->email); ?>
                                </div>
                                <span class="help-inline"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label text-md-right">Текст</label>
                            <div class="controls">
                                <input type="text" name="text" placeholder="Текст" class="form-control"
                                       value="<?php echo htmlentities($task->text); ?>">
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-actions">
                            <input type="hidden" name="form-submitted" value="1">
                            <button type="submit" class="btn btn-success mr-3">Update</button>
                            <a class="btn btn-secondary" href="/">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>