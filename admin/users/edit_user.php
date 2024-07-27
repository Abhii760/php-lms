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

        <link rel="stylesheet" href="edit_user_styles.css">

        <h2>Edit User</h2>
        <form id="editUserForm" action="../../admin/users/process_user.php?action=edit" method="post" onsubmit="return checkAdminPassword();">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <?php if ($user['category_id'] != 'CAT-ADM') { ?>
                <input type="button" value="Change Password" onclick="window.location.href='change_password.php?id=<?php echo htmlspecialchars($user['user_id']); ?>';">
            <?php } ?>

            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="tel_number">Telephone Number</label>
            <input type="text" id="tel_number" name="tel_number" placeholder="Telephone Number" value="<?php echo htmlspecialchars($user['tel_number']); ?>" required>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" placeholder="Date of Birth" value="<?php echo htmlspecialchars($user['dob']); ?>" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

            <label for="category_id">Category</label>
            <select id="category_id" name="category_id">
                <option value="CAT-STU" <?php if ($user['category_id'] == 'CAT-STU') echo 'selected'; ?>>Student</option>
                <option value="CAT-LEC" <?php if ($user['category_id'] == 'CAT-LEC') echo 'selected'; ?>>Lecturer</option>
                <option value="CAT-AUT" <?php if ($user['category_id'] == 'CAT-AUT') echo 'selected'; ?>>Author</option>
                <option value="CAT-ADM" <?php if ($user['category_id'] == 'CAT-ADM') echo 'selected'; ?>>Admin</option>
            </select>

            <label for="department_id">Department</label>
            <select id="department_id" name="department_id">
                <?php
                // Fetch departments from the database
                $stmt = $pdo->query('SELECT department_id, department_name FROM departments');
                while ($department = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($user['department_id'] == $department['department_id']) ? 'selected' : '';
                    echo "<option value=\"{$department['department_id']}\" $selected>{$department['department_name']}</option>";
                }
                ?>
            </select>

            <input type="submit" value="Update User">
            <input type="button" value="Cancel" onclick="window.location.href=document.referrer;">

        </form>

        <script>
            function checkAdminPassword() {
                <?php if ($user['category_id'] == 'CAT-ADM') { ?>
                    var adminPassword = prompt("Please enter your current admin password:");
                    if (adminPassword == null || adminPassword == "") {
                        return false;
                    }
                    // You can add an AJAX call here to verify the admin password if needed
                <?php } ?>
                return true;
            }
        </script>

<?php
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid user ID.";
}
?>