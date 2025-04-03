<?php
include "db.php";

// Fetch contact details
$stmt = $conn->prepare("SELECT * FROM contact LIMIT 1");
$stmt->execute();
$contact = $stmt->get_result()->fetch_assoc() ?? [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Contact Section -->
<section class="contact_section">
    <div class="container">
        <h2 class="contact_heading">Get In Touch</h2>
        

        <form action="send_message.php" method="POST" class="contact_form">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="phone" placeholder="Your Phone" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit" class="contact_btn">SEND</button>
        </form>
    </div>

</section>

</body>
</html>
