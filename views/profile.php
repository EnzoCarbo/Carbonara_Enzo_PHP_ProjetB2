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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Profil de <?php echo htmlspecialchars($user['email']); ?></h1>
        <nav>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="projects.php">Mes projets</a>
            <a href="skills.php">Mes compétences</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <section>
        <h2>Informations utilisateur</h2>
        <form action="update_profile.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Laisser vide si pas de changement">
            
            <button type="submit">Mettre à jour</button>
        </form>
    </section>
</body>
</html>
