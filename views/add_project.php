<?php
session_start();
require_once '../config/database.php';
require_once '../models/Project.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $project_url = $_POST['project_url'];

    $projectModel = new Project($pdo);
    $projectModel->addProject($_SESSION['user_id'], $title, $description, $image_url, $project_url);

    header('Location: projects.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un projet</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Ajouter un projet</h1>
        <nav>
            <a href="projects.php">Retour aux projets</a>
        </nav>
    </header>

    <section>
        <form action="add_project.php" method="POST">
            <label for="title">Titre du projet</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="image_url">URL de l'image</label>
            <input type="text" id="image_url" name="image_url" required>

            <label for="project_url">URL du projet</label>
            <input type="text" id="project_url" name="project_url" required>

            <button type="submit">Ajouter le projet</button>
        </form>
    </section>
</body>
</html>
