<?php
session_start();
require_once '../config/database.php';
require_once '../models/Project.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$projectModel = new Project($pdo);
$project = $projectModel->getProjectById($_GET['id']);

if (!$project || $project['user_id'] != $_SESSION['user_id']) {
    header('Location: projects.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $project_url = $_POST['project_url'];

    $projectModel->updateProject($project['id'], $title, $description, $image_url, $project_url);

    header('Location: projects.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un projet</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Modifier le projet</h1>
        <nav>
            <a href="projects.php">Retour aux projets</a>
        </nav>
    </header>

    <section>
        <form action="edit_project.php?id=<?php echo $project['id']; ?>" method="POST">
            <label for="title">Titre du projet</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>

            <label for="image_url">URL de l'image</label>
            <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($project['image_url']); ?>" required>

            <label for="project_url">URL du projet</label>
            <input type="text" id="project_url" name="project_url" value="<?php echo htmlspecialchars($project['project_url']); ?>" required>

            <button type="submit">Mettre à jour le projet</button>
        </form>
    </section>
</body>
</html>
