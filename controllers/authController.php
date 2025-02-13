<?php
session_start();
require_once '../config/database.php';
require_once '../models/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $role = "user";

    if ($username && $email && $password) {
        $userModel = new User($pdo);

        if ($userModel->getUserByEmailOrUsername($email) || $userModel->getUserByEmailOrUsername($username)) {
            $error = "Cet utilisateur existe déjà.";
        } else {
           
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

           
            $inserted = $userModel->createUser($username, $email, $hashedPassword, $role);

            if ($inserted) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
                exit();
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    } else {
        $error = "Tous les champs doivent être remplis.";
    }
}
?>
