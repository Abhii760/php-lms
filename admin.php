<?php
session_start();
error_log("Session data: " . print_r($_SESSION, true));

if (!isset($_SESSION['user']) || $_SESSION['user']['category_id'] != 'CAT-ADM') {
    header('Location: login.php');
    exit();
}

// Load the selected page or default to dashboard
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Connect to database
include './includes/functions.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="admin.php?page=dashboard">Dashboard</a>
            <a href="admin.php?page=users">Manage Users</a>
            <a href="admin.php?page=courses">Manage Courses</a>
            <a href="admin.php?page=departments">Manage Departments</a>
            <!-- Add other links here -->
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <?php
        // Load the selected page
        $file = 'admin/' . $page . '.php';
        if (file_exists($file)) {
            include $file;
        } else {
            echo '<p>Page not found.</p>';
        }
        ?>
    </main>
</body>

</html>