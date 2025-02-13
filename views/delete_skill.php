<?php
session_start();
require_once '../config/database.php';
require_once '../models/Skill.php';

if (!isset($_SESSION['user_id'])) {
 
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $skillModel = new Skill($pdo);
    
    $skillModel->deleteSkill($id);
    
    header('Location: skills.php');
    exit();
}
?>
