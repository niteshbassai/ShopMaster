<?php
// Include the header
include('../includes/header.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Validate email and password
    if (empty($email) || empty($password)) {
        echo "<p style='color:red;'>Please fill in both fields.</p>";
    } else {
        // Check if the email exists in the database
        include('../config/database.php');
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<p style='color:red;'>No account found with that email.</p>";
        } else {
            $admin = $result->fetch_assoc();
            
            // Verify the password
            if (password_verify($password, $admin['password'])) {
                // Start session and store admin information
                session_start();
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_email'] = $admin['email'];

                // Redirect to the admin dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<p style='color:red;'>Incorrect password. Please try again.</p>";
            }
        }
    }
}
?>

<section class="admin-login">
    <h2>Admin Login</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="cta-button">Login</button>
    </form>
</section>

<?php
// Include the footer
include('../includes/footer.php');
?>
