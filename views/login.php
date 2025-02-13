<?php
session_start();
require_once '../config/database.php';
require_once '../models/user.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = isset($_POST['login']) ? trim($_POST['login']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($login && $password) {
        $userModel = new User($pdo);

        // Vérification si l'utilisateur existe avec l'email ou le nom d'utilisateur
        $user = $userModel->getUserByEmailOrUsername($login);

        if ($user && password_verify($password, $user['password'])) {
            // Authentification réussie, démarrer la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Tous les champs doivent être remplis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/login.css">
</head>
<body>
    <h2>Connexion</h2>
    <?php if ($error) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form action="login.php" method="post">
        <input type="text" name="login" placeholder="Email ou Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <a href="register.php">Pas encore inscrit ?</a>
</body>
</html>
