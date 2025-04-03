<?php
include "db.php";
$result = $conn->query("SELECT * FROM pricing");

$pricing_plans = [];
if ($result) {
    foreach ($result->fetch_all(MYSQLI_ASSOC) as $row) {
        $pricing_plans[] = [
            'id' => $row['id'],
            'price' => $row['price'],
            'name' => $row['plan'],
            'features' => explode("\n", $row['features']),
            'link' => '#'
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans</title>
    <link rel="stylesheet" href="price.css">
</head>
<body>
    <section class="plans_section layout_padding">
        <div class="container">
            <div class="heading_wrapper heading_center">
                <h2>Our Pricing</h2>
            </div>
            <div class="plans_container">
                <?php foreach ($pricing_plans as $plan): ?>
                    <div class="plan_box">
                        <div class="plan_details">
                            <h2>₹<span><?= htmlspecialchars($plan['price']) ?></span></h2>
                            <h6><?= htmlspecialchars($plan['name']) ?></h6>
                            <ul class="plan_features">
                                <?php foreach ($plan['features'] as $feature): ?>
                                    <li><?= htmlspecialchars($feature) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="plan_btn">
                            <a href="<?= htmlspecialchars($plan['link']) ?>">See Detail</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>
</html>
