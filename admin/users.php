<?php
// Include the database connection file

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

<h2>Manage Users</h2>

<!-- Add User Form -->
<h3>Add User</h3>
<form id="addUserForm" action="./admin/users/process_user.php?action=add" method="post">
    <input type="text" id="username" name="username" placeholder="Username" required>
    <span id="usernameError" class="error-message"></span>
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
                    echo '<td class="actions">';
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

<!-- Arrow Keys for Navigation -->
<div class="arrow-keys">
    <button id="leftArrow" class="arrow-btn">&larr;</button>
    <button id="rightArrow" class="arrow-btn">&rarr;</button>
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

document.addEventListener('scroll', function() {
    const table = document.querySelector('.table-wrapper');
    const arrowKeys = document.querySelector('.arrow-keys');
    const tablePosition = table.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    if (tablePosition.top < windowHeight && tablePosition.bottom > 0) {
        arrowKeys.style.display = 'block';
    } else {
        arrowKeys.style.display = 'none';
    }
});

let scrollInterval;

function startScrolling(direction) {
    const table = document.querySelector('.table-wrapper');
    scrollInterval = setInterval(() => {
        table.scrollLeft += direction * 10; // Adjust the value for speed
    }, 10); // Adjust the interval for smoothness
}

function stopScrolling() {
    clearInterval(scrollInterval);
}

document.getElementById('leftArrow').addEventListener('mousedown', function() {
    startScrolling(-1);
});

document.getElementById('leftArrow').addEventListener('mouseup', stopScrolling);
document.getElementById('leftArrow').addEventListener('mouseleave', stopScrolling);

document.getElementById('rightArrow').addEventListener('mousedown', function() {
    startScrolling(1);
});

document.getElementById('rightArrow').addEventListener('mouseup', stopScrolling);
document.getElementById('rightArrow').addEventListener('mouseleave', stopScrolling);

document.getElementById('rightArrow').addEventListener('mouseleave', stopScrolling);

document.getElementById('username').addEventListener('keyup', function() {
    console.log(this.value);
    var username = this.value;
    var usernameError = document.getElementById('usernameError');
    var submitButton = document.querySelector('input[type="submit"]');

    // Clear the message if the input is empty
    if (username.length === 0) {
        usernameError.textContent = '';
        submitButton.disabled = true;
        return;
    }

    // Check if the username is at least 4 characters long
    if (username.length < 4) {
        usernameError.textContent = 'Your username should be at least 4 characters.';
        usernameError.style.color = 'red';
        submitButton.disabled = true;
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './admin/check_username.php', true); // Adjust the path if necessary
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.exists) {
                usernameError.textContent = 'Username already exists. Please choose another.';
                usernameError.style.color = 'red';
                submitButton.disabled = true;
            } else {
                usernameError.textContent = 'Username available.';
                usernameError.style.color = 'green';
                submitButton.disabled = false;
            }
        }
    };
    xhr.send('username=' + encodeURIComponent(username));
});
</script>