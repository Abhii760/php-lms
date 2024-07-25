<?php
session_start();
include 'includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['category_id'] !== 'CAT-AUT') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user']['user_id'];
$user = getUserData($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submissions for managing materials here
}

$materials = getAllMaterials();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Author Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h2>Author Dashboard</h2>
    <a href="logout.php">Logout</a>
    <!-- Display and manage course materials here -->
</body>

</html>