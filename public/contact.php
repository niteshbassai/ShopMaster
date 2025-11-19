<?php
// Include the header
include('../includes/header.php');

// Initialize form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data to avoid malicious input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation (make sure fields are not empty)
    if (empty($name) || empty($email) || empty($message)) {
        echo "<p style='color:red;'>All fields are required.</p>";
    } else {
        // For now, just display the message for debugging purposes
        echo "<p>Thank you for your message, $name. We'll get back to you shortly.</p>";

        // You can later send the email or store the message in the database here

        // Redirect to avoid form resubmission on page refresh
        header("Location: contact.php");
        exit();
    }
}
?>

<section class="contact">
    <h2>Contact Us</h2>
    <form action="contact.php" method="POST">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>

        <label for="message">Your Message:</label>
        <textarea id="message" name="message" rows="5" required><?php echo isset($message) ? $message : ''; ?></textarea>

        <button type="submit" class="cta-button">Send Message</button>
    </form>
</section>

<?php
// Include the footer
include('../includes/footer.php');
?>
