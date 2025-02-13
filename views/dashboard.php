<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

if (!isset($_SESSION['user_id'])) {
 
    header('Location: login.php');
    exit();
}

$userModel = new User($pdo);
$user = $userModel->getUserById($_SESSION['user_id']);

$isAdmin = ($user['role'] === 'admin');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../public/assets/css/dashboard.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur votre tableau de bord</h1>
        <p>Bonjour, <?php echo htmlspecialchars($user['email']); ?></p>
        <nav>
            <a href="profile.php">Mon profil</a>
            <a href="projects.php">Mes projets</a>
            <a href="skills.php">Mes compétences</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <section>
        <?php if ($isAdmin): ?>
            <h2>Bienvenue, administrateur !</h2>
            <p>Vous avez accès aux fonctionnalités d'administration.</p>
            <ul>
                <li><a href="manage_users.php">Gérer les utilisateurs</a></li>
                <li><a href="manage_skill.php">Gérer les compétences</a></li>
            </ul>
        <?php else: ?>
            <h2>Bienvenue, utilisateur !</h2>
            <p>Vous pouvez gérer vos projets et compétences ci-dessous.</p>
            <ul>
                <li><a href="profile.php">Modifier mon profil</a></li>
                <li><a href="add_project.php">Ajouter un projet</a></li>
                <li><a href="edit_skill.php">Modifier mes compétences</a></li>
            </ul>
        <?php endif; ?>
    </section>
</body>
</html>
