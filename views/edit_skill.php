<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$skillModel = new Skill($pdo);

if (!isset($_GET['id'])) {
    header('Location: skills.php');
    exit();
}

$skillId = $_GET['id'];
$skill = $skillModel->getSkillById($skillId);

if (!$skill || $skill['user_id'] != $_SESSION['user_id']) {
    header('Location: skills.php');
    exit();
}

$allSkills = $skillModel->getAllSkills();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSkillId = $_POST['skill_id'];
    $level = $_POST['level'];

    $skillModel->updateSkill($_SESSION['user_id'], $skillId, $newSkillId, $level);

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
    <link rel="stylesheet" href="../public/assets/css/edit_skills.css">
</head>
<body>
    <header>
        <h1>Modifier une compétence</h1>
        <nav>
            <a href="skills.php">Retour aux compétences</a>
        </nav>
    </header>

    <section>
        <form action="edit_skill.php?id=<?php echo $skill['id']; ?>" method="POST">
            <label for="skill_id">Nom de la compétence</label>
            <select id="skill_id" name="skill_id" required>
                <?php foreach ($allSkills as $availableSkill): ?>
                    <option value="<?php echo $availableSkill['id']; ?>" <?php if ($availableSkill['id'] == $skill['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($availableSkill['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="level">Niveau</label>
            <select id="level" name="level" required>
                <option value="Débutant" <?php if ($skill['level'] == 'Débutant') echo 'selected'; ?>>Débutant</option>
                <option value="Intermédiaire" <?php if ($skill['level'] == 'Intermédiaire') echo 'selected'; ?>>Intermédiaire</option>
                <option value="Avancé" <?php if ($skill['level'] == 'Avancé') echo 'selected'; ?>>Avancé</option>
                <option value="Expert" <?php if ($skill['level'] == 'Expert') echo 'selected'; ?>>Expert</option>
            </select>

            <button type="submit">Mettre à jour la compétence</button>
        </form>
    </section>
</body>
</html>