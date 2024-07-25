<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <?php
        // Include the database connection file
        include '../../includes/functions.php';

        // Check if user ID is set
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];

            // Prepare and execute the query to fetch user details
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if user exists
            if ($user) {
        ?>
        <h2>Delete User</h2>
        <p>Are you sure you want to delete the following user?</p>
        <ul>
            <li>Username: <?php echo htmlspecialchars($user['username']); ?></li>
            <li>First Name: <?php echo htmlspecialchars($user['first_name']); ?></li>
            <li>Last Name: <?php echo htmlspecialchars($user['last_name']); ?></li>
            <li>Email: <?php echo htmlspecialchars($user['email']); ?></li>
            <li>Category: <?php echo htmlspecialchars($user['category_id']); ?></li>
        </ul>
        <form action="process_user.php?action=delete&id=<?php echo htmlspecialchars($user['user_id']); ?>"
            method="post">
            <input type="submit" value="Delete User">
        </form>
        <?php
            } else {
                echo "User not found.";
            }
        } else {
            echo "Invalid user ID.";
        }
        ?>
    </div>
</body>

</html>