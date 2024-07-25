<?php
// Include the database connection file
include '../../includes/functions.php';

// Fetch departments for the dropdown menu
$departments = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT department_id, department_name FROM departments");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $departments[] = $row;
    }
} else {
    echo 'Database connection failed.';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>Manage Users</h2>

    <!-- Add User Form -->
    <h3>Add User</h3>
    <form action="./admin/users/process_user.php?action=add" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="tel_number" placeholder="Telephone Number" required>
        <input type="date" name="dob" placeholder="Date of Birth" required>
        <input type="text" name="address" placeholder="Address" required>
        <select name="category_id">
            <option value="CAT-STU">Student</option>
            <option value="CAT-LEC">Lecturer</option>
            <option value="CAT-AUT">Author</option>
            <option value="CAT-ADM">Admin</option>
        </select>
        <select name="department_id">
            <?php foreach ($departments as $department) : ?>
            <option value="<?= htmlspecialchars($department['department_id']) ?>">
                <?= htmlspecialchars($department['department_name']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Add User">
    </form>

    <!-- Search Bar -->
    <h3>Search Users</h3>
    <input type="text" id="searchInput" placeholder="Search by ID, Username, First Name, Last Name, or Email"
        onkeyup="filterTable()">

    <!-- List Users -->
    <h3>List Users</h3>
    <div class="table-wrapper">
        <table id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Telephone Number</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Category</th>
                    <th>Department</th>
                    <th>Date Joined</th>
                    <th>Profile Picture</th>
                    <th class="actions">Actions</th>
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
                        echo '<td>' . htmlspecialchars($row['tel_number']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['dob']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['category_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['department_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['date_joined']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['profile_picture']) . '</td>';
                        echo '<td class="actions-cell">';
                        echo '<a href="admin/users/edit_user.php?id=' . htmlspecialchars($row['user_id']) . '">Edit</a> | ';
                        echo '<a href="admin/users/delete_user.php?id=' . htmlspecialchars($row['user_id']) . '" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="13">Database connection failed.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="scrollbar">
        <div style="width: 2000px;"></div>
    </div>

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

    window.addEventListener('scroll', function() {
        var tableWrapper = document.querySelector('.table-wrapper');
        var table = document.getElementById('usersTable');
        var scrollBar = document.querySelector('.scrollbar');

        var tableRect = table.getBoundingClientRect();
        var wrapperRect = tableWrapper.getBoundingClientRect();

        if (tableRect.top < window.innerHeight && tableRect.bottom > 0) {
            scrollBar.style.display = 'block';
        } else {
            scrollBar.style.display = 'none';
        }
    });
    </script>
</body>

</html>