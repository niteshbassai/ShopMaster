<?php
// Include database or email sending logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Process the data (send email or store in the database)
    // For now, we will just echo the data
    echo "<p>Thank you for your message, $name. We'll get back to you shortly.</p>";

    // Redirect back to the contact page after processing
    header("Location: contact.php");
    exit();
}
?>
