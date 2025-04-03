<?php
include "db.php"; // Include database connection

// Fetch updated contact details
$stmt = $conn->prepare("SELECT * FROM contact LIMIT 1");
$stmt->execute();
$contact = $stmt->get_result()->fetch_assoc() ?? [];

// Navigation links
$nav_links = [
    'Home' => 'index.php',
    'About' => 'about.php',
    'Services' => 'service.php',
    'Pricing' => 'price.php',
    'Contact Us' => 'contact.php'
];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Info Section -->
<section class="info_section layout_padding2">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-md-3">
                <h4>Contact Info</h4>
                <p><strong>Location:</strong> <?= htmlspecialchars($contact['location'] ?? 'Not Available'); ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($contact['phone'] ?? 'Not Available'); ?></p>
                <p><strong>Email:</strong> 
                    <a href="mailto:<?= htmlspecialchars($contact['email'] ?? '#'); ?>">
                        <?= htmlspecialchars($contact['email'] ?? 'Not Available'); ?>
                    </a>
                </p>

                <!-- Social Links -->
                <div class="social_links">
                    <a href="<?= htmlspecialchars($contact['facebook'] ?? '#'); ?>" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="<?= htmlspecialchars($contact['twitter'] ?? '#'); ?>" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="<?= htmlspecialchars($contact['linkedin'] ?? '#'); ?>" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="<?= htmlspecialchars($contact['instagram'] ?? '#'); ?>" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="col-md-3">
                <h4>Links</h4>
                <div class="info_links">
                 <a href="index.php">Home</a>
                 <a href="about.php">About</a>
                    <a href="service.php">Services</a>
                    <a href="price.php">Pricing</a>
                    <a href="contact.php">Contact Us</a>
                    <!-- <a href="privacy.php">Privacy Policy</a>
                    <a href="terms.php">Terms of Service</a>
                    <a href="faq.php">FAQ</a> -->
                </div>
            </div>

            <!-- Info Section -->
            <div class="col-md-3">
                <h4>Info</h4>
                <p>Making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words.</p>
            </div>

            <!-- Subscription Section -->
            <div class="col-md-3">
                <h4>Subscribe</h4>
                <form action="subscribe.php" method="POST">
                    <input type="email" name="email" placeholder="Enter email" required />
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Info Section -->

<!-- Footer Section -->
<footer class="footer_section">
    <div class="container">
        <p>&copy; <span id="displayYear">All copyrights@ are reseverd by hostit</p>
    </div>
</footer>
<!-- End Footer Section -->

</body>
</html>
