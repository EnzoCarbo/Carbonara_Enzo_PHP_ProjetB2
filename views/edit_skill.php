<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$skillModel = new Skill($pdo);
$skill = $skillModel->getSkillById($_GET['id']);

if (!$skill || $skill['user_id'] != $_SESSION['user_id']) {
    header('Location: skills.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $level = $_POST['level'];

    $skillModel->updateSkill($skill['id'], $name, $level);

    header('Location: skills.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une compétence</title>
    <link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Modifier la compétence</h1>
        <nav>
            <a href="skills.php">Retour aux compétences</a>
        </nav>
    </header>

    <section>
        <form action="edit_skill.php?id=<?php echo $skill['id']; ?>" method="POST">
            <label for="name">Nom de la compétence</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($skill['name']); ?>" required>

            <label for="level">Niveau</label>
            <select id="level" name="level" required>
                <option value="Débutant" <?php echo $skill['level'] == 'Débutant' ? 'selected' : ''; ?>>Débutant</option>
                <option value="Intermédiaire" <?php echo $skill['level'] == 'Intermédiaire' ? 'selected' : ''; ?>>Intermédiaire</option>
                <option value="Avancé" <?php echo $skill['level'] == 'Avancé' ? 'selected' : ''; ?>>Avancé</option>
                <option value="Expert" <?php echo $skill['level'] == 'Expert' ? 'selected' : ''; ?>>Expert</option>
            </select>

            <button type="submit">Mettre à jour la compétence</button>
        </form>
    </section>
</body>
</html>
