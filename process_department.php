<?php
include 'db.php';

$action = $_GET['action'];

if ($action == 'add') {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];

    $stmt = $conn->prepare("INSERT INTO departments (department_id, department_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $department_id, $department_name);
    $stmt->execute();
    header('Location: admin.php?page=departments');
} elseif ($action == 'edit') {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];

    $stmt = $conn->prepare("UPDATE departments SET department_name = ? WHERE department_id = ?");
    $stmt->bind_param("ss", $department_name, $department_id);
    $stmt->execute();
    header('Location: admin.php?page=departments');
} elseif ($action == 'delete') {
    $department_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM departments WHERE department_id = ?");
    $stmt->bind_param("s", $department_id);
    $stmt->execute();
    header('Location: admin.php?page=departments');
}