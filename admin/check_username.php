<?php
header('Content-Type: application/json');

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=nibm_prject_lms', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    try {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $exists = $stmt->fetchColumn() > 0;
        echo json_encode(['exists' => $exists]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Username not provided']);
}