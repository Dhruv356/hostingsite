<?php
include 'header.php'; 
include 'db.php'; 

// Fetch sliders from the database
$stmt = $conn->prepare("SELECT * FROM sliders ORDER BY id DESC");
$stmt->execute();
$sliders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Dynamic Slider</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>

<section class="slider_section">
  <div id="customCarousel1" class="carousel slide" data-ride="carousel" data-interval="1000" data-pause="hover">

    <div class="carousel-inner">
      
    <?php foreach ($sliders as $index => $slide): ?>
    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
        <div class="container">
            <div class="row align-items-center">
                
                <!-- Text Content -->
                <div class="col-md-6">
                    <div class="detail-box">
                        <h1><?= htmlspecialchars($slide['title']) ?></h1>
                        <p><?= nl2br(htmlspecialchars($slide['description'])) ?></p>
                        <div class="btn-box">
                            <a href="#" class="btn-1">Read More</a>
                            <a href="#" class="btn-2">Contact Us</a>
                        </div>
                    </div>
                </div>
                
                <!-- Image Content -->
                <div class="col-md-6 text-center">
                    <div class="img-box">
                        <img src="<?= htmlspecialchars($slide['image']) ?>" 
                             alt="Slider Image"
                             class="slider-image img-fluid"
                             loading="lazy"
                             onerror="this.src='images/default.jpg'; console.error('Image not found: <?= htmlspecialchars($slide['image']) ?>');">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php endforeach; ?>

    </div>

    <!-- Carousel Controls -->
    <a class="carousel-control-prev fixed-btn" href="#customCarousel1" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next fixed-btn" href="#customCarousel1" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
  </div>
</section>

<?php include 'footer.php'; ?>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
