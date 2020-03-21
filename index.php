<?php

session_start();

require_once 'model/FlashMessages.php';

$msg = new FlashMessages();

require_once 'router.php';
