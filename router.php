<?php

require_once 'controller/TasksController.php';
require_once 'route/Route.php';

$controller = new TasksController();

$controller->checkTable();

Route::add('/', [$controller, 'listTasks'], 'get');

Route::add('/new', [$controller, 'saveTask'], 'get');

Route::add('/new', [$controller, 'saveTask'], 'post');

Route::add('/show/([0-9]*)', [$controller, 'showTask'], 'get');

Route::add('/edit/([0-9]*)', [$controller, 'editTask'], 'get');

Route::add('/edit/([0-9]*)', [$controller, 'editTask'], 'post');

Route::add('/delete/([0-9]*)', [$controller, 'deleteTask'], 'post');

Route::add('/done/([0-9]*)', [$controller, 'getDone'], 'post');

Route::add('/login', [$controller, 'login'], 'get');

Route::add('/login', [$controller, 'login'], 'post');

Route::add('/logout', [$controller, 'logout'], 'post');

Route::pathNotFound([$controller, 'showError']);

Route::methodNotAllowed([$controller, 'showError']);

// Run the router
Route::run('/');
