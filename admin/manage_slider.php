<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../db.php";

// Fetch sliders from the database
$sliders = $conn->query("SELECT * FROM sliders ORDER BY id DESC");

// Handle slider submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    
    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "../images/"; // Upload folder (outside of admin panel)
        $image_name = time() . "_" . basename($_FILES['image']['name']); // Unique filename
        $image_path = $upload_dir . $image_name;
        $db_image_path = "images/" . $image_name; // Save relative path for database

        // Validate image type and size
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            die("<script>alert('Invalid file type. Only JPG, PNG, and GIF are allowed.'); window.history.back();</script>");
        }
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) { // 2MB max
            die("<script>alert('File size too large. Max 2MB allowed.'); window.history.back();</script>");
        }

        // Move uploaded file and insert into database
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
            $stmt = $conn->prepare("INSERT INTO sliders (title, description, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $description, $db_image_path);
            if ($stmt->execute()) {
                echo "<script>alert('Slider added successfully!'); window.location='manage_slider.php';</script>";
            } else {
                echo "<script>alert('Error adding slider.');</script>";
            }
        } else {
            echo "<script>alert('Error uploading image.');</script>";
        }
    } else {
        echo "<script>alert('Please select an image.');</script>";
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Sanitize input
    // Fetch image path before deleting
    $stmt = $conn->prepare("SELECT image FROM sliders WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    if (!empty($image) && file_exists("../" . $image)) {
        unlink("../" . $image); // Delete file from server
    }

    // Delete slider from database
    $stmt = $conn->prepare("DELETE FROM sliders WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Slider deleted successfully!'); window.location='manage_slider.php';</script>";
    } else {
        echo "<script>alert('Error deleting slider.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Sliders</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
        <h2>Manage Sliders</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" required>

            <label>Description:</label>
            <textarea name="description" required></textarea>

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Add Slider</button>
        </form>

        <h3>Existing Sliders</h3>
        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $sliders->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['description']); ?></td>
                    <td>
    <img class="slider-preview" 
         src="../<?= htmlspecialchars($row['image']); ?>"  
         width="100" 
         alt="Slider Image"
         onerror="this.src='../images/default.jpg'; console.error('Image not found: <?= $row['image'] ?>');">
    
</td>



                    <td>
                        <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
