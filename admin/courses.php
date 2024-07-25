<h2>Manage Courses</h2>

<!-- Add Course Form -->
<h3>Add Course</h3>
<form action="process_course.php?action=add" method="post">
    <input type="text" name="course_id" placeholder="Course ID" required>
    <input type="text" name="course_name" placeholder="Course Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="submit" value="Add Course">
</form>

<!-- List Courses -->
<h3>List Courses</h3>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Course Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM courses");
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['course_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['course_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
            echo '<td>
                <a href="admin.php?page=edit_course&id=' . htmlspecialchars($row['course_id']) . '">Edit</a>
                <a href="process_course.php?action=delete&id=' . htmlspecialchars($row['course_id']) . '">Delete</a>
            </td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>