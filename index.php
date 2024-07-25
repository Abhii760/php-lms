<?php
session_start();

// Debugging: Log session data
error_log("Session data: " . print_r($_SESSION, true));

if (!isset($_SESSION['user'])) {
    error_log("No user in session, redirecting to login.php");
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$categoryId = $user['category_id'];

// Debugging: Log category ID
error_log("Category ID: $categoryId");

switch ($categoryId) {
    case 'CAT-ADM':
        error_log("Redirecting to admin.php");
        header('Location: admin.php');
        break;
    case 'CAT-STU':
        error_log("Redirecting to student.php");
        header('Location: student.php');
        break;
    case 'CAT-LEC':
        error_log("Redirecting to lecturer.php");
        header('Location: lecturer.php');
        break;
    case 'CAT-AUT':
        error_log("Redirecting to author.php");
        header('Location: author.php');
        break;
    default:
        error_log("Invalid category_id, redirecting to login.php");
        header('Location: login.php');
        break;
}

exit();