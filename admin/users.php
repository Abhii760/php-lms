<?php
// Include the database connection file
include '../includes/functions.php';
?>

<h2>Manage Users</h2>

<!-- Add User Form -->
<h3>Add User</h3>
<form action="process_user.php?action=add" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <select name="category_id">
        <option value="CAT-STU">Student</option>
        <option value="CAT-LEC">Lecturer</option>
        <option value="CAT-AUT">Author</option>
        <option value="CAT-ADM">Admin</option>
    </select>
    <input type="submit" value="Add User">
</form>

<!-- Search Bar -->
<h3>Search Users</h3>
<input type="text" id="searchInput" placeholder="Search by ID, Username, First Name, Last Name, or Email"
    onkeyup="filterTable()">

<!-- List Users -->
<h3>List Users</h3>
<table id="usersTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Ensure $pdo is defined and not null
        if ($pdo) {
            $stmt = $pdo->query("SELECT * FROM users");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['user_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>';
                echo '<a href="admin/users/edit_user.php?id=' . htmlspecialchars($row['user_id']) . '">Edit</a> | ';
                echo '<a href="admin/users/delete_user.php?id=' . htmlspecialchars($row['user_id']) . '" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">Database connection failed.</td></tr>';
        }
        ?>
    </tbody>
</table>

<script>
function filterTable() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("usersTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
}
</script>