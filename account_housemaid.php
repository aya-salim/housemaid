<?php
session_start();
include("condb.php"); // PDO connection

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Amina Yusuf';
    $_SESSION['privilege'] = 1;
}

if ($_SESSION['privilege'] != 1) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hname = $_POST['hname'];
    $place = $_POST['place'];
    $status = $_POST['status'];
    $img_path = "";

    if (!empty($_FILES['img']['name'])) {
        $img_path = "images/" . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], $img_path);
    }

    try {
        // Update housemaid
        $sql = "UPDATE housemaid SET hname = ?, place = ?, status = ?"
             . (!empty($img_path) ? ", img = ?" : "")
             . " WHERE hname = ?";
        $stmt = $conn->prepare($sql);

        if (!empty($img_path)) {
            $stmt->execute([$hname, $place, $status, $img_path, $username]);
        } else {
            $stmt->execute([$hname, $place, $status, $username]);
        }

        // Update users table
        $sql2 = "UPDATE users SET uname = ?, place = ? WHERE uname = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$hname, $place, $username]);

        $_SESSION['username'] = $hname;
        $username = $hname;
        $message = "Profile updated successfully!";
    } catch (Exception $e) {
        $message = "Error updating profile.";
    }
}

// Load current data
$stmt = $conn->prepare("SELECT * FROM housemaid WHERE hname = ?");
$stmt->execute([$username]);
$maid = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$maid) {
    echo "<p style='color:red; text-align:center;'>Error: No profile found for <b>$username</b>.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Housemaid Info</title>
    <style>
        body { font-family: Arial; background: #f0f0f5; padding: 40px; }
        .container { background: #fff; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 20px; color: #333; }
        label { display: block; margin-top: 15px; color: #555; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        img { max-width: 100px; margin-top: 10px; display: block; }
        .btn { background: #28a745; color: white; padding: 12px; border: none; cursor: pointer; border-radius: 5px; margin-top: 20px; }
        .btn:hover { background: #218838; }
        .message { text-align: center; color: green; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Your Profile</h2>
        <?php if ($message) echo "<p class='message'>$message</p>"; ?>
        <form method="post" enctype="multipart/form-data">
            <label>Full Name:</label>
            <input type="text" name="hname" value="<?= htmlspecialchars($maid['hname']) ?>" required>

            <label>Current Image:</label>
            <img src="images/<?= htmlspecialchars($maid['img']) ?>" alt="Profile Image">
            <input type="file" name="img">

            <label>Place:</label>
            <input type="text" name="place" value="<?= htmlspecialchars($maid['place']) ?>" required>

            <label>Status:</label>
            <select name="status" required>
                <option value="Available" <?= $maid['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                <option value="Busy" <?= $maid['status'] == 'Busy' ? 'selected' : '' ?>>Busy</option>
                <option value="On Leave" <?= $maid['status'] == 'On Leave' ? 'selected' : '' ?>>On Leave</option>
            </select>

            <button class="btn" type="submit">Update Info</button>
        </form>
    </div>
</body>
</html>
