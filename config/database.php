<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'projetb2');
define('DB_USER', 'root');  
define('DB_PASS', '');      
define('DB_PORT', 3306);

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $users = [
        ['username' => 'admin', 'email' => 'admin@example.com', 'password' => 'password', 'role' => 'admin'],
        ['username' => 'user', 'email' => 'user@example.com', 'password' => 'password', 'role' => 'user']
    ];

  
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $insertStmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");

    foreach ($users as $user) {
        
        $checkStmt->execute([':username' => $user['username']]);
        $exists = $checkStmt->fetchColumn();

        if ($exists == 0) { 
            $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
            $insertStmt->execute([
                ':username' => $user['username'],
                ':email' => $user['email'],
                ':password' => $hashedPassword,
                ':role' => $user['role']
            ]);    
    }
}
} catch (PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}
?>
