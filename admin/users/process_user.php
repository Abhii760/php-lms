<?php
include 'db.php';

$action = $_GET['action'];

if ($action == 'add') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, first_name, last_name, email, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password, $first_name, $last_name, $email, $category_id);
    $stmt->execute();
    header('Location: admin.php?page=users');
} elseif ($action == 'edit') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, category_id = ? WHERE user_id = ?");
    $stmt->bind_param("sssssi", $username, $first_name, $last_name, $email, $category_id, $user_id);
    $stmt->execute();
    header('Location: admin.php?page=users');
} elseif ($action == 'delete') {
    $user_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    header('Location: admin.php?page=users');
}