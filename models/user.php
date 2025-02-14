<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserById($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch();
    }

    public function updateUserRole($user_id, $role) {
        $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE id = :user_id");
        $stmt->execute([
            'user_id' => $user_id,
            'role' => $role
        ]);
    }
    
    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
    

    public function getUserByEmailOrUsername($login) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :login OR username = :login");
        $stmt->execute(['login' => $login]);
        return $stmt->fetch();
    }

    public function createUser($username, $email, $password, $role) {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role
        ]);
    }

    public function register($email, $username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $stmt->execute([
            'email' => $email,
            'username' => $username,
            'password' => $hashedPassword
        ]);
    }

    public function checkIfExists($email, $username) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
        $stmt->execute(['email' => $email, 'username' => $username]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function updateUser($user_id, $data) {
        $setParts = [];
        $params = ['user_id' => $user_id];

        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
            $params[$key] = $value;
        }

        $sql = "UPDATE users SET " . implode(", ", $setParts) . " WHERE id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteUser($user_id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
    }

}
?>
