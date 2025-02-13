<?php
class Skill {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllSkills() {
        $stmt = $this->pdo->prepare("SELECT * FROM skills");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSkillsByUserId($user_id) {
        $stmt = $this->pdo->prepare("SELECT s.id, s.name, us.level FROM skills s
                                     JOIN user_skills us ON s.id = us.skill_id
                                     WHERE us.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }
    
    

    public function addSkill($user_id, $skill_id, $level) {
        $stmt = $this->pdo->prepare("INSERT INTO user_skills (user_id, skill_id, level) 
                                     VALUES (:user_id, :skill_id, :level)");
        $stmt->execute([
            'user_id' => $user_id,
            'skill_id' => $skill_id,
            'level' => $level
        ]);
    }
    

    public function getSkillById($skill_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM skills WHERE id = :skill_id");
        $stmt->execute(['skill_id' => $skill_id]);
        return $stmt->fetch();
    }
    
    

    public function updateSkill($user_id, $skill_id, $level) {
        $stmt = $this->pdo->prepare("UPDATE user_skills 
                                     SET level = :level 
                                     WHERE user_id = :user_id AND skill_id = :skill_id");
        $stmt->execute([
            'user_id' => $user_id,
            'skill_id' => $skill_id,
            'level' => $level
        ]);
    }
    

    public function deleteSkill($user_id, $skill_id) {
        $stmt = $this->pdo->prepare("DELETE FROM user_skills 
                                     WHERE user_id = :user_id AND skill_id = :skill_id");
        $stmt->execute([
            'user_id' => $user_id,
            'skill_id' => $skill_id
        ]);
    }
    
}