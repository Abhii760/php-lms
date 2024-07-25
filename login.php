<?php
session_start();
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugging: Log the received username and password
    error_log("Username: $username, Password: $password");

    $user = checkLogin($username, $password);

    // Debugging: Log the result of checkLogin
    if ($user) {
        error_log("Login successful for user: " . print_r($user, true));
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit();
    } else {
        error_log("Login failed for username: $username");
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
        <?php if (isset($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </form>
</body>

</html>