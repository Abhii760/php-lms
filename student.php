<?php
session_start();
include 'includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['category_id'] !== 'CAT-STU') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user']['user_id'];
$user = getUserData($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle profile update here
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h2>Student Profile</h2>
    <a href="logout.php">Logout</a>
    <form method="POST">
        <!-- Display and update student profile details here -->
    </form>
</body>

</html>