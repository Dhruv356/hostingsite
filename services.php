<?php
include 'header.php'; 
include "db.php"; // Connect to database

// Fetch services from database
$result = $conn->query("SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="stylesheet" href="services.css">
</head>
<body>
    
<!-- Services Section -->
<section class="service_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Our Services</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php while ($service = $result->fetch_assoc()) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="images/<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['title']) ?>">
                        </div>
                        <div class="detail-box">
                            <h4><?= htmlspecialchars($service['title']) ?></h4>
                            <p><?= htmlspecialchars($service['description']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

</body>
<?php include 'footer.php'; ?>
</html>
