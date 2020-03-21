<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Create Task</title>
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
                    <h3>Create a task</h3>
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
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="col-form-label text-md-right">Имя пользователя</label>
                            <div class="controls">
                                <input type="text" name="username" placeholder="Имя пользователя" class="form-control"
                                       value="<?php echo htmlentities($userName); ?>">
                                <span class="help-inline"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label text-md-right">Email</label>
                            <div class="controls">
                                <input type="email" name="email" placeholder="Email" class="form-control"
                                       value="<?php echo htmlentities($email); ?>">
                                <span class="help-inline"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label text-md-right">Текст</label>
                            <div class="controls">
                                <input type="text" name="text" placeholder="Текст" class="form-control"
                                       value="<?php echo htmlentities($text); ?>">
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <br>
                        <div class="form-actions">
                            <input type="hidden" name="form-submitted" value="1">
                            <button type="submit" class="btn btn-success mr-3">Create</button>
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