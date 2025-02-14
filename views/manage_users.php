<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../utils/Session.php';

use App\Session;

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['user_id']) || !Session::isAdmin()) {
    // Afficher des messages de débogage
    error_log('User ID: ' . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'not set'));
    error_log('User Role: ' . (isset($_SESSION['role']) ? $_SESSION['role'] : 'not set'));
    header('Location: login.php');
    exit();
}

$userModel = new User($pdo);
$users = $userModel->getAllUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $userId = $_POST['user_id'];
        // Empêcher l'administrateur de se supprimer lui-même
        if ($userId != $_SESSION['user_id']) {
            $userModel->deleteUser($userId);
        }
        header('Location: manage_users.php');
        exit();
    } elseif (isset($_POST['update_user'])) {
        $userId = $_POST['user_id'];
        $role = $_POST['role'];
        $userModel->updateUserRole($userId, $role);
        header('Location: manage_users.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les utilisateurs</title>
    <link rel="stylesheet" href="../public/assets/css/manage_users.css">
</head>
<body>
    <header>
        <h1>Gérer les utilisateurs</h1>
        <nav>
            <a href="dashboard.php">Tableau de bord</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <section>
        <h2>Liste des utilisateurs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <form action="manage_users.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <select name="role">
                                    <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Utilisateur</option>
                                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
                                </select>
                                <button type="submit" name="update_user">Mettre à jour</button>
                            </form>
                        </td>
                        <td>
                            <form action="manage_users.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete_user" <?php if ($user['id'] == $_SESSION['user_id']) echo 'disabled'; ?>>Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>