<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $skill_id = $_GET['id'];
    $user_id = $_SESSION['user_id']; 

    $skillModel = new Skill($pdo);

    $skillModel->deleteSkill($user_id, $skill_id);
}

header('Location: ../views/skills.php');
exit();
?>
