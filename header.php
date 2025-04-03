<?php
// Define navigation menu items
$menuItems = [
    'index.php'   => 'Home',
    'about.php'   => 'About',
    'services.php' => 'Services',
    'price.php'   => 'Pricing',
    'contact.php' => 'Contact Us'
];

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostit</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg custom_nav-container">
    <a class="navbar-brand" href="index.php">
        <span>Hostit</span>
    </a>

    <!-- Mobile Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <?php foreach ($menuItems as $link => $title): ?>
                <li class="nav-item <?= ($current_page == $link) ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= $link ?>">
                        <?= htmlspecialchars($title) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Search and Call Section -->
        <div class="quote_btn-container d-flex align-items-center">
            <form class="form-inline">
                <button class="btn nav_search-btn" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <a href="tel:+01123455678990" class="d-flex align-items-center ml-3">
                <i class="fas fa-phone"></i>
                <span class="ml-2">Call: +01 123455678990</span>
            </a>
        </div>
    </div>
</nav>

<!-- Bootstrap JS (For Responsive Navbar) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
