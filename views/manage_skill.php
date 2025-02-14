<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';
require_once '../utils/Session.php';

use App\Session;

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['user_id']) || !Session::isAdmin()) {
    header('Location: login.php');
    exit();
}

$skillModel = new Skill($pdo);
$skills = $skillModel->getAllSkills();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_skill'])) {
        $skillName = $_POST['skill_name'];
        $skillModel->addSkillToDatabase($skillName);
        header('Location: manage_skill.php');
        exit();
    } elseif (isset($_POST['delete_skill'])) {
        $skillId = $_POST['skill_id'];
        $skillModel->deleteSkillFromDatabase($skillId);
        header('Location: manage_skill.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les compétences</title>
    <link rel="stylesheet" href="../public/assets/css/manage_skill.css">
</head>
<body>
    <header>
        <h1>Gérer les compétences</h1>
        <nav>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <section>
        <h2>Ajouter une compétence</h2>
        <form action="manage_skill.php" method="POST">
            <label for="skill_name">Nom de la compétence</label>
            <input type="text" id="skill_name" name="skill_name" required>
            <button type="submit" name="add_skill">Ajouter</button>
        </form>

        <h2>Liste des compétences</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($skills as $skill): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($skill['id']); ?></td>
                        <td><?php echo htmlspecialchars($skill['name']); ?></td>
                        <td>
                            <form action="manage_skill.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?');">
                                <input type="hidden" name="skill_id" value="<?php echo $skill['id']; ?>">
                                <button type="submit" name="delete_skill">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>