<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../db.php";

// Handle Add, Update, and Delete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? "";
    $plan = trim($_POST['plan']);
    $price = trim($_POST['price']);
    $features = trim($_POST['features']);

    if (!empty($id)) {
        // Update existing plan
        $stmt = $conn->prepare("UPDATE pricing SET plan=?, price=?, features=? WHERE id=?");
        $stmt->bind_param("sdsi", $plan, $price, $features, $id);
    } else {
        // Insert new plan
        $stmt = $conn->prepare("INSERT INTO pricing (plan, price, features) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $plan, $price, $features);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Plan saved successfully!'); window.location='manage_pricing.php';</script>";
    } else {
        echo "<script>alert('Error saving plan.');</script>";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM pricing WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Plan deleted successfully!'); window.location='manage_pricing.php';</script>";
    } else {
        echo "<script>alert('Error deleting plan.');</script>";
    }
}

// Fetch Plans
$plans = $conn->query("SELECT * FROM pricing");

// Check if editing
$edit_id = $_GET['edit'] ?? "";
$edit_plan = $edit_price = $edit_features = "";
if (!empty($edit_id)) {
    $stmt = $conn->prepare("SELECT * FROM pricing WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_result = $stmt->get_result()->fetch_assoc();
    if ($edit_result) {
        $edit_plan = $edit_result['plan'];
        $edit_price = $edit_result['price'];
        $edit_features = $edit_result['features'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Pricing</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
        <h2>Manage Pricing</h2>

        <!-- Add / Edit Form -->
        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($edit_id); ?>">
            <input type="text" name="plan" placeholder="Plan Name" value="<?= htmlspecialchars($edit_plan); ?>" required>
            <input type="number" name="price" placeholder="Price" step="0.01" value="<?= htmlspecialchars($edit_price); ?>" required>
            <textarea name="features" placeholder="Enter features, separated by new lines" required><?= htmlspecialchars($edit_features); ?></textarea>
            <button type="submit"><?= $edit_id ? "Update Plan" : "Add Plan"; ?></button>
        </form>

        <h3>Existing Plans</h3>
        <ul>
            <?php while ($row = $plans->fetch_assoc()): ?>
                <li>
                    <?= htmlspecialchars($row['plan']); ?> - $<?= htmlspecialchars($row['price']); ?>  
                    <a href="?edit=<?= $row['id']; ?>">Edit</a> | 
                    <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
