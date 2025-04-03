<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "../db.php";

// Handle Add Service
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image = $_FILES['image'];

    // Validate image
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowed_types)) {
        echo "<script>alert('Invalid file type! Only JPG, PNG, and GIF are allowed.');</script>";
        exit();
    }

    // Secure file upload
    $image_name = time() . "_" . basename($image["name"]);
    $target_dir = "../images/";
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO services (title, description, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $image_name);
        if ($stmt->execute()) {
            echo "<script>alert('Service added successfully!'); window.location.href='manage_services.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('File upload failed!');</script>";
    }
}

// Fetch Services
$result = $conn->query("SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Services</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
        <h2>Manage Services</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Service Title" required>
            <textarea name="description" placeholder="Service Description" required></textarea>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Add Service</button>
        </form>

        <h3>Existing Services</h3>
        <ul>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <li>
                    <img src="../images/<?= htmlspecialchars($row['image']); ?>" width="50">
                    <?= htmlspecialchars($row['title']); ?> - <?= htmlspecialchars($row['description']); ?>
                    <a href="delete_service.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
