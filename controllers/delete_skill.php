<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    header('Location: login.php');
    exit();
}

// Vérifie si l'ID de la compétence est passé en GET
if (isset($_GET['id'])) {
    $skill_id = $_GET['id'];
    $user_id = $_SESSION['user_id']; // Récupère l'ID de l'utilisateur

    // Instancier le modèle Skill
    $skillModel = new Skill($pdo);

    // Appelle la méthode deleteSkill avec les deux arguments
    $skillModel->deleteSkill($user_id, $skill_id);
}

// Redirige vers la page des compétences après suppression
header('Location: ../views/skills.php');
exit();
?>
