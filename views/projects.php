<?php
session_start();
require_once '../config/database.php';
require_once '../models/Project.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$projectModel = new Project($pdo);
$projects = $projectModel->getProjectsByUserId($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes projets</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Gestion de mes projets</h1>
        <nav>
            <a href="profile.php">Mon profil</a>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="skills.php">Mes compétences</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <section>
        <h2>Liste de mes projets</h2>
        <a href="add_project.php">Ajouter un nouveau projet</a>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li>
                    <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <a href="edit_project.php?id=<?php echo $project['id']; ?>">Modifier</a>
                    <a href="delete_project.php?id=<?php echo $project['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">Supprimer</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>
