<?php

session_start();
require_once '../config/database.php';
require_once '../models/Project.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: ../views/projects.php');
    exit();
}

$projectId = $_GET['id'];
$userId = $_SESSION['user_id'];

$projectModel = new Project($pdo);

$project = $projectModel->getProjectById($projectId);

if ($project && $project['user_id'] == $userId) {
    $projectModel->deleteProject($projectId);
    header('Location: ../views/projects.php');
    exit();
} else {
    header('Location: ../views/projects.php');
    exit();
}