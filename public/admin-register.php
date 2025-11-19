<?php
// Include the header
include('../includes/header.php');

// Initialize form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    // Validate email and password
    if (empty($email) || empty($password) || empty($confirm_password)) {
        echo "<p style='color:red;'>Please fill in all fields.</p>";
    } elseif ($password !== $confirm_password) {
        echo "<p style='color:red;'>Passwords do not match. Please try again.</p>";
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Store the admin details in the database
        include('../config/database.php');

        // Check if the email already exists
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p style='color:red;'>An account with this email already exists.</p>";
        } else {
            // Insert the new admin into the database
            $sql = "INSERT INTO admins (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $hashed_password);
            if ($stmt->execute()) {
                // Redirect to the admin dashboard after successful registration
                session_start();
                $_SESSION['admin_id'] = $conn->insert_id;  // Set session variable for admin
                $_SESSION['admin_email'] = $email;  // Store email in session
                header("Location: ../admin/dashboard.php");  // Redirect to dashboard
                exit();
            } else {
                echo "<p style='color:red;'>Error creating account. Please try again.</p>";
            }
        }
    }
}
?>

<section class="admin-register">
    <h2>Create Admin Account</h2>
    <form action="admin-register.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="cta-button">Create Account</button>
    </form>
</section>

<?php
// Include the footer
include('../includes/footer.php');
?>
