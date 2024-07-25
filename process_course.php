<?php
include 'db.php';

$action = $_GET['action'];

if ($action == 'add') {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO courses (course_id, course_name, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $course_id, $course_name, $description);
    $stmt->execute();
    header('Location: admin.php?page=courses');
} elseif ($action == 'edit') {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE courses SET course_name = ?, description = ? WHERE course_id = ?");
    $stmt->bind_param("sss", $course_name, $description, $course_id);
    $stmt->execute();
    header('Location: admin.php?page=courses');
} elseif ($action == 'delete') {
    $course_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = ?");
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    header('Location: admin.php?page=courses');
}