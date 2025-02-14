<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$skillModel = new Skill($pdo);
$skills = $skillModel->getSkillsByUserId($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes compétences</title>
    <link rel="stylesheet" href="../public/assets/css/skills.css">
</head>
<body>
    <header>
        <h1>Gestion de mes compétences</h1>
        <nav>
            <a href="profile.php">Mon profil</a>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="projects.php">Mes projets</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <section>
        <h2>Liste de mes compétences</h2>
        <a href="add_skill.php">Ajouter une compétence</a>
        <ul>
            <?php foreach ($skills as $skill): ?>
                <?php
                $levelClass = '';
                switch ($skill['level']) {
                    case 'Débutant':
                        $levelClass = 'level-debutant';
                        break;
                    case 'Intermédiaire':
                        $levelClass = 'level-intermediaire';
                        break;
                    case 'Avancé':
                        $levelClass = 'level-avance';
                        break;
                    case 'Expert':
                        $levelClass = 'level-expert';
                        break;
                }
                ?>
                <li class="<?php echo $levelClass; ?>">
                    <h3><?php echo htmlspecialchars($skill['name']); ?></h3>
                    <p>Niveau : <?php echo htmlspecialchars($skill['level']); ?></p>
                    <div class="progress-bar">
                        <div class="progress-bar-inner"></div>
                    </div>
                    <a href="edit_skill.php?id=<?php echo $skill['id']; ?>">Modifier</a>
                    <a href="../controllers/delete_skill.php?id=<?php echo $skill['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')">Supprimer</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>