<?php
include 'db.php';

function checkLogin($username, $password)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, hash('sha256', $password)]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserData($user_id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUsers()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCourses()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM courses");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMaterials()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM course_materials");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Add more functions as needed