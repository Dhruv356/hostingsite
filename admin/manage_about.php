<?php
include '../db.php'; // Database connection
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Function to fetch section data
function getSectionData($conn, $section) {
    $stmt = $conn->prepare("SELECT * FROM about_server WHERE section = ? LIMIT 1");
    $stmt->bind_param("s", $section);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    return $data ?: ['title' => '', 'description' => '', 'image' => '', 'read_more_link' => ''];
}

// Fetch current section data
$section = $_GET['section'] ?? 'about'; 
$data = getSectionData($conn, $section);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $read_more_link = trim($_POST['read_more_link']);

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "../images/"; // Directory for uploads
        $image_name = basename($_FILES['image']['name']);
        $image_path = $upload_dir . $image_name;
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = "images/" . $image_name; // Store relative path in DB
        } else {
            die("Error uploading image. Check folder permissions.");
        }
    } else {
        $image = $data['image']; // Keep old image if no new image is uploaded
    }
    

    // Check if section exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM about_server WHERE section = ?");
    $stmt->bind_param("s", $section);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Update existing data
        $stmt = $conn->prepare("UPDATE about_server SET title=?, description=?, image=?, read_more_link=? WHERE section=?");
        $stmt->bind_param("sssss", $title, $description, $image, $read_more_link, $section);
    } else {
        // Insert new data
        $stmt = $conn->prepare("INSERT INTO about_server (section, title, description, image, read_more_link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $section, $title, $description, $image, $read_more_link);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Content saved successfully!'); window.location='manage_about.php?section=$section';</script>";
    } else {
        echo "<script>alert('Error saving content.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Content</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h3>Edit Sections:</h3>
<ul>
    <li><a href="manage_about.php?section=about">Edit About Section</a></li>
    <li><a href="manage_about.php?section=server">Edit Server Section</a></li>
</ul>

<form method="post" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>

    <label>Description:</label>
    <textarea name="description" required><?= htmlspecialchars($data['description']); ?></textarea>

    <label>Image:</label>
    <input type="file" name="image">
    <?php if (!empty($data['image']) && file_exists("../" . $data['image'])): ?>
    <img src="<?= htmlspecialchars($data['image']); ?>" width="150" alt="Current Image">
<?php else: ?>
    <img src="images/default.jpg" width="150" alt="Default Image">
<?php endif; ?>


    <label>Read More Link:</label>
    <input type="text" name="read_more_link" value="<?= htmlspecialchars($data['read_more_link']); ?>" required>

    <button type="submit">Save Changes</button>
</form>

</body>
</html>
