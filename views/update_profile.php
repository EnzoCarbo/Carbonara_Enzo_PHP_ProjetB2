<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($email)) {
        $updateData = ['username' => $username, 'email' => $email];
        
        if (!empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        
        $userModel->updateUser($_SESSION['user_id'], $updateData);
        
        $_SESSION['success_message'] = "Profil mis à jour avec succès.";
        header('Location: profile.php');
        exit();
    } else {
        $_SESSION['error_message'] = "Tous les champs obligatoires doivent être remplis.";
        header('Location: profile.php');
        exit();
    }
}

header('Location: profile.php');
exit();
