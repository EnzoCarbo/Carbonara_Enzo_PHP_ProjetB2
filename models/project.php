<?php
class Project {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getProjectsByUserId($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM projects WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function addProject($user_id, $title, $description, $image_url, $project_url) {
        $stmt = $this->pdo->prepare("INSERT INTO projects (user_id, title, description, image_url, project_url) VALUES (:user_id, :title, :description, :image_url, :project_url)");
        $stmt->execute([
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'image_url' => $image_url,
            'project_url' => $project_url
        ]);
    }

    public function getProjectById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateProject($id, $title, $description, $image_url, $project_url) {
        $stmt = $this->pdo->prepare("UPDATE projects SET title = :title, description = :description, image_url = :image_url, project_url = :project_url WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'image_url' => $image_url,
            'project_url' => $project_url
        ]);
    }

    public function deleteProject($id) {
        $stmt = $this->pdo->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}