<h2>Manage Departments</h2>

<!-- Add Department Form -->
<h3>Add Department</h3>
<form action="process_department.php?action=add" method="post">
    <input type="text" name="department_id" placeholder="Department ID" required>
    <input type="text" name="department_name" placeholder="Department Name" required>
    <input type="submit" value="Add Department">
</form>

<!-- List Departments -->
<h3>List Departments</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Department Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM departments");
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['department_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['department_name']) . '</td>';
            echo '<td>
                <a href="admin.php?page=edit_department&id=' . htmlspecialchars($row['department_id']) . '">Edit</a>
                <a href="process_department.php?action=delete&id=' . htmlspecialchars($row['department_id']) . '">Delete</a>
            </td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>