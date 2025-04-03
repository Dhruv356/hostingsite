<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../db.php";

// Fetch existing contact details
$stmt = $conn->prepare("SELECT * FROM contact LIMIT 1");
$stmt->execute();
$contact = $stmt->get_result()->fetch_assoc() ?? [];

// Handle contact update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_contact'])) {
    $location = trim($_POST['location']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $facebook = trim($_POST['facebook']);
    $twitter = trim($_POST['twitter']);
    $linkedin = trim($_POST['linkedin']);
    $instagram = trim($_POST['instagram']);

    // Check if contact details exist
    $check_stmt = $conn->query("SELECT id FROM contact LIMIT 1");
    $existing = $check_stmt->fetch_assoc();

    if ($existing) {
        // Update existing details
        $stmt = $conn->prepare("UPDATE contact SET location=?, phone=?, email=?, facebook=?, twitter=?, linkedin=?, instagram=? LIMIT 1");
        $stmt->bind_param("sssssss", $location, $phone, $email, $facebook, $twitter, $linkedin, $instagram);
    } else {
        // Insert new details if none exist
        $stmt = $conn->prepare("INSERT INTO contact (location, phone, email, facebook, twitter, linkedin, instagram) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $location, $phone, $email, $facebook, $twitter, $linkedin, $instagram);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Contact details updated successfully!'); window.location='manage_contact.php';</script>";
    } else {
        echo "<script>alert('Error updating contact details.');</script>";
    }
}

// Fetch user messages
$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Contact</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
        <h2>Manage Contact Details</h2>

        <form method="post">
            <input type="hidden" name="update_contact" value="1">
            <label>Location:</label>
            <input type="text" name="location" value="<?= htmlspecialchars($contact['location'] ?? ''); ?>" required>

            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($contact['phone'] ?? ''); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($contact['email'] ?? ''); ?>" required>

            <label>Facebook:</label>
            <input type="url" name="facebook" value="<?= htmlspecialchars($contact['facebook'] ?? ''); ?>">

            <label>Twitter:</label>
            <input type="url" name="twitter" value="<?= htmlspecialchars($contact['twitter'] ?? ''); ?>">

            <label>LinkedIn:</label>
            <input type="url" name="linkedin" value="<?= htmlspecialchars($contact['linkedin'] ?? ''); ?>">

            <label>Instagram:</label>
            <input type="url" name="instagram" value="<?= htmlspecialchars($contact['instagram'] ?? ''); ?>">

            <button type="submit">Update Contact</button>
        </form>

        <h3>User Messages</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $messages->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['message']); ?></td>
                    <td>
                        <a href="?delete_id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php
// Handle message deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $delete_stmt->bind_param("i", $delete_id);

    if ($delete_stmt->execute()) {
        echo "<script>alert('Message deleted successfully!'); window.location='manage_contact.php';</script>";
    } else {
        echo "<script>alert('Error deleting message.');</script>";
    }
}
?>
