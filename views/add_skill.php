<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$skillModel = new Skill($pdo);

$skills = $skillModel->getAllSkills();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skill_id = $_POST['skill_id']; 
    $level = $_POST['level'];

   
    $skillModel->addSkill($_SESSION['user_id'], $skill_id, $level);

    header('Location: skills.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une compétence</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Ajouter une compétence</h1>
        <nav>
            <a href="skills.php">Retour aux compétences</a>
        </nav>
    </header>

    <section>
        <form action="add_skill.php" method="POST">
            <label for="skill_id">Compétence</label>
            <select id="skill_id" name="skill_id" required>
                <option value="">Choisissez une compétence</option>
                <?php foreach ($skills as $skill): ?>
                    <option value="<?= $skill['id']; ?>"><?= $skill['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="level">Niveau</label>
            <select id="level" name="level" required>
                <option value="Débutant">Débutant</option>
                <option value="Intermédiaire">Intermédiaire</option>
                <option value="Avancé">Avancé</option>
                <option value="Expert">Expert</option>
            </select>

            <button type="submit">Ajouter la compétence</button>
        </form>
    </section>
</body>
</html>
