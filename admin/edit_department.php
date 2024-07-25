<?php
$department_id = $_GET['id'];
$result = $conn->query("SELECT * FROM departments WHERE department_id = '$department_id'");
$department = $result->fetch_assoc();
?>

<h2>Edit Department</h2>
<form action="process_department.php?action=edit" method="post">
    <input type="hidden" name="department_id" value="<?php echo htmlspecialchars($department['department_id']); ?>">
    <input type="text" name="department_name" placeholder="Department Name"
        value="<?php echo htmlspecialchars($department['department_name']); ?>" required>
    <input type="submit" value="Update Department">
</form>