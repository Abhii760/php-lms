<?php
// Include the database connection file
include '../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'add') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $tel_number = $_POST['tel_number'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $category_id = $_POST['category_id'];
    $department_id = $_POST['department_id'];

    // Determine the prefix based on the category_id
    $prefix = '';
    switch ($category_id) {
        case 'CAT-STU':
            $prefix = 'STU';
            break;
        case 'CAT-LEC':
            $prefix = 'LEC';
            break;
        case 'CAT-AUT':
            $prefix = 'AUT';
            break;
        case 'CAT-ADM':
            $prefix = 'ADM';
            break;
    }

    // Fetch the last user ID for the specified category
    $query = "SELECT user_id FROM users WHERE user_id LIKE '$prefix%' ORDER BY user_id DESC LIMIT 1";
    $stmt = $pdo->query($query);
    $last_user_id = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];

    // Extract the numeric part and increment it
    if ($last_user_id) {
        $numeric_part = (int)substr($last_user_id, 3);
        $new_numeric_part = str_pad($numeric_part + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $new_numeric_part = '001';
    }

    // Construct the new user ID
    $new_user_id = $prefix . $new_numeric_part;

    // Insert the new user into the database
    $insert_query = "INSERT INTO users (user_id, username, password, first_name, last_name, email, tel_number, dob, address, category_id, department_id) 
                     VALUES (:user_id, :username, :password, :first_name, :last_name, :email, :tel_number, :dob, :address, :category_id, :department_id)";
    $stmt = $pdo->prepare($insert_query);
    $success = $stmt->execute([
        ':user_id' => $new_user_id,
        ':username' => $username,
        ':password' => $password,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':tel_number' => $tel_number,
        ':dob' => $dob,
        ':address' => $address,
        ':category_id' => $category_id,
        ':department_id' => $department_id
    ]);

    if ($success) {
        echo "<script>
                alert('New user added successfully.');
                window.history.back();
              </script>";
    } else {
        echo "<script>
                alert('User did not add successfully.');
                window.history.back();
              </script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from the database
    $stmt = $pdo->prepare('DELETE FROM users WHERE user_id = ?');
    $stmt->execute([$user_id]);

    if ($stmt) {
        echo "<script>
                alert('New user added successfully.');
                window.history.back();
              </script>";
    } else {
        echo "<script>
                alert('User did not add successfully.');
                window.history.back();
              </script>";
    }


    // Redirect to the users.php page
    header('Location: ../../admin.php?page=users');
    exit;
}