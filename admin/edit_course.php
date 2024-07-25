<?php
$course_id = $_GET['id'];
$result = $conn->query("SELECT * FROM courses WHERE course_id = '$course_id'");
$course = $result->fetch_assoc();
?>

<h2>Edit Course</h2>
<form action="process_course.php?action=edit" method="post">
    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['course_id']); ?>">
    <input type="text" name="course_name" placeholder="Course Name"
        value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
    <textarea name="description" placeholder="Description"
        required><?php echo htmlspecialchars($course['description']); ?></textarea>
    <input type="submit" value="Update Course">
</form>