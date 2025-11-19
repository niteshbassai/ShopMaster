<?php
session_start();  // Start the session to handle login state
include('config/database.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to find the admin with the given email
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the admin exists
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Password is correct, set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            // Redirect to the admin dashboard
            header("Location: admin/dashboard.php");
            exit();
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "Admin not found.";
    }
} else {
    echo "Please submit the login form.";
}
?>
