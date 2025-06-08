<?php
    session_start();
    session_unset();     // smaže všechny session proměnné
    session_destroy();   // zničí session
    require_once __DIR__ . '/../config/constant.php';

    header("Location: " . BASE_URL . "views/lists/index.php");
    exit;