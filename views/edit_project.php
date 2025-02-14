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
    $project_url = $_POST['project_url'];

  
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

       
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExtension, $allowedExtensions)) {
           
            $uploadDir = '../public/uploads/';
            $destPath = $uploadDir . $imageName;

           
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

           
            if (move_uploaded_file($imageTmpPath, $destPath)) {
                $image_url = 'public/uploads/' . $imageName; 
            } else {
                $error = 'Erreur lors du téléchargement de l\'image.';
            }
        } else {
            $error = 'Extension de fichier non autorisée.';
        }
    } else {
        $image_url = $project['image_url']; 
    }

    if (!isset($error)) {
        $projectModel->updateProject($project['id'], $title, $description, $image_url, $project_url);

        header('Location: projects.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un projet</title>
    <link rel="stylesheet" href="../public/assets/css/edit_projects.css">
</head>
<body>
    <header>
        <h1>Modifier le projet</h1>
        <nav>
            <a href="projects.php">Retour aux projets</a>
        </nav>
    </header>

    <section>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="edit_project.php?id=<?php echo $project['id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="title">Titre du projet</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($project['description']); ?></textarea>

            <?php if (!empty($project['image_url'])): ?>
                <img src="<?php echo htmlspecialchars($project['image_url']); ?>" alt="Image du projet" style="max-width: 200px;">
            <?php endif; ?>
            <label for="image">Changer l'image du projet</label>
            <input type="file" id="image" name="image" accept="image/*">

            <label for="project_url">URL du projet</label>
            <input type="text" id="project_url" name="project_url" value="<?php echo htmlspecialchars($project['project_url']); ?>" required>

            <button type="submit">Mettre à jour le projet</button>
        </form>
    </section>
</body>
</html>