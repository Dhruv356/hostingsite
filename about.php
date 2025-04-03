<?php
include 'header.php';
include 'db.php';

// Function to fetch section data
function getSectionData($conn, $section) {
    $stmt = $conn->prepare("SELECT * FROM about_server WHERE section = ? LIMIT 1");
    $stmt->bind_param("s", $section);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    return $data ?: [
        'title' => 'Coming Soon',
        'description' => 'Content will be updated soon.',
        'image' => 'images/default.jpg', // Default image
        'read_more_link' => '#'
    ];
}

// Fetch About and Server section data
$about = getSectionData($conn, 'about');
$server = getSectionData($conn, 'server');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="about.css">
</head>
<body>

<!-- About Section -->
<section class="about_section layout_padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2><?= htmlspecialchars($about['title']) ?></h2>
                    </div>
                    <p><?= nl2br(htmlspecialchars($about['description'])) ?></p>
                    <a href="<?= htmlspecialchars($about['read_more_link']) ?>">Read More</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="img-box">
                <img src="<?= htmlspecialchars($about['image']) ?>" alt="About Us" onerror="this.src='images/default.jpg';">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- Server Section -->
<section class="server_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-box">
                    <img src="<?= htmlspecialchars($server['image']) ?>" alt="Server Management">
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <div class="heading_container">
                        <h2><?= htmlspecialchars($server['title']) ?></h2>
                        <p><?= nl2br(htmlspecialchars($server['description'])) ?></p>
                    </div>
                    <a href="<?= htmlspecialchars($server['read_more_link']) ?>">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
