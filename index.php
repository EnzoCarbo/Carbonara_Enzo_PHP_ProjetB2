<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: views/dashboard.php");
    exit();
}

if (isset($_COOKIE['remember_me'])) {
    $remember_me = $_COOKIE['remember_me'];
    
    require_once '../config/database.php';
    require_once '../models/user.php';
    
    $userModel = new User($pdo);

    $user = $userModel->getUserByRememberToken($remember_me);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        header("Location: views/dashboard.php");
        exit();
    }
}
header("Location: views/login.php");
exit();
