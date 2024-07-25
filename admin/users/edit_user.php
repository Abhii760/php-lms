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
<h2>Edit User</h2>
<form action="process_user.php?action=edit" method="post">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
    <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($user['username']); ?>"
        required>
    <input type="text" name="first_name" placeholder="First Name"
        value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
    <input type="text" name="last_name" placeholder="Last Name"
        value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>"
        required>
    <select name="category_id">
        <option value="CAT-STU" <?php if ($user['category_id'] == 'CAT-STU') echo 'selected'; ?>>Student</option>
        <option value="CAT-LEC" <?php if ($user['category_id'] == 'CAT-LEC') echo 'selected'; ?>>Lecturer</option>
        <option value="CAT-AUT" <?php if ($user['category_id'] == 'CAT-AUT') echo 'selected'; ?>>Author</option>
        <option value="CAT-ADM" <?php if ($user['category_id'] == 'CAT-ADM') echo 'selected'; ?>>Admin</option>
    </select>
    <input type="submit" value="Update User">
</form>
<?php
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid user ID.";
}
?>