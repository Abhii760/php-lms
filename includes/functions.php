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

// Fetch admin data
function getAdminData($adminId)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT name, profile_picture FROM admins WHERE id = ?');
    $stmt->execute([$adminId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update admin data
function updateAdminData($adminId, $name, $profilePicture)
{
    global $pdo;
    $stmt = $pdo->prepare('UPDATE admins SET name = ?, profile_picture = ? WHERE id = ?');
    $stmt->execute([$name, $profilePicture, $adminId]);
}

// Add more functions as needed