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

// Fetch admin data if on profile page
if ($page === 'profile') {
    $adminId = $_SESSION['user']['id'];
    $adminData = getAdminData($adminId);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $profilePicture = $_FILES['profile_picture']['name'];

        // Move uploaded file to the desired directory
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'uploads/' . $profilePicture);

        // Update admin data
        updateAdminData($adminId, $name, $profilePicture);

        // Refresh the page to show updated data
        header('Location: admin.php?page=profile');
        exit();
    }
}
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
            <div class="profile-menu">
                <img src="uploads/<?php echo htmlspecialchars($_SESSION['user']['profile_picture']); ?>"
                    alt="Profile Picture">
                <div class="profile-menu-content">
                    <a href="admin.php?page=profile">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <div>
                <nav class="sidebar">
                    <a href="admin.php?page=dashboard">Dashboard</a>
                    <a href="admin.php?page=users">Manage Users</a>
                    <a href="admin.php?page=courses">Manage Courses</a>
                    <a href="admin.php?page=departments">Manage Departments</a>
                </nav>
            </div>
        </nav>
    </header>
    <main>
        <?php
        // Load the selected page
        if ($page === 'profile') {
        ?>
        <h2>Admin Profile</h2>
        <form action="admin.php?page=profile" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($adminData['name']); ?>"
                required>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" required>

            <button type="submit">Update Profile</button>
        </form>
        <h3>Current Profile Picture:</h3>
        <img src="uploads/<?php echo htmlspecialchars($adminData['profile_picture']); ?>" alt="Profile Picture"
            width="100">
        <?php
        } else {
            $file = 'admin/' . $page . '.php';
            if (file_exists($file)) {
                include $file;
            } else {
                echo '<p>Page not found.</p>';
            }
        }
        ?>
    </main>
</body>

</html>