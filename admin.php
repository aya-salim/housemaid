<?php
session_start();
include("condb.php");

// Check if admin
if (!isset($_SESSION['username']) || $_SESSION['privilege'] != '0') {
    header("Location: index.php");
    exit();
}

$message = "";

// Add new admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_admin'])) {
    $uname = $_POST['uname'];
    $uemail = $_POST['uemail'];
    $upass = $_POST['upass'];
    $place = $_POST['place'];

    try {
        $stmt = $conn->prepare("INSERT INTO users (uname, uemail, upass, place, privilege) VALUES (?, ?, ?, ?, '0')");
        $stmt->execute([$uname, $uemail, $upass, $place]);
        $message = "New admin added successfully!";
    } catch (Exception $e) {
        $message = "Error: Email might already exist.";
    }
}

// Update privilege
if (isset($_GET['action']) && $_GET['action'] === 'set' && isset($_GET['id'], $_GET['level'])) {
    $stmt = $conn->prepare("UPDATE users SET privilege = ? WHERE id = ?");
    $stmt->execute([$_GET['level'], $_GET['id']]);
    header("Location: admin.php");
    exit();
}

// Delete user
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    header("Location: admin.php");
    exit();
}

// Get all non-admin users
$stmt = $conn->prepare("SELECT * FROM users WHERE privilege IN ('1', '2')");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 40px;
            margin: 0;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 8px 14px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            margin: 3px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #343a40;
            color: white;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            color: white;
        }
        .badge-housemaid { background: #28a745; }
        .badge-customer { background: #17a2b8; }
        #searchBox {
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .message {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Dashboard</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>

    <h3>Add New Admin</h3>
    <form method="post">
        <input type="hidden" name="new_admin" value="1">
        <label>Full Name:</label>
        <input type="text" name="uname" required>
        <label>Email:</label>
        <input type="email" name="uemail" required>
        <label>Password:</label>
        <input type="text" name="upass" required>
        <label>Place:</label>
        <input type="text" name="place" required>
        <button type="submit" class="btn">Add Admin</button>
    </form>

    <h3>Manage Users</h3>
    <label>Search Users:</label>
    <input type="text" id="searchBox" placeholder="Search by name or email..." onkeyup="filterTable()">

    <table id="userTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Place</th>
                <th>Privilege</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['uname']) ?></td>
                <td><?= htmlspecialchars($user['uemail']) ?></td>
                <td><?= htmlspecialchars($user['place']) ?></td>
                <td>
                    <?php if ($user['privilege'] == '1'): ?>
                        <span class="badge badge-housemaid">Housemaid</span>
                    <?php else: ?>
                        <span class="badge badge-customer">Customer</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="?action=set&id=<?= $user['id'] ?>&level=1" class="btn">Make Housemaid</a>
                    <a href="?action=set&id=<?= $user['id'] ?>&level=2" class="btn">Make Customer</a>
                    <a href="?action=delete&id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function filterTable() {
    const input = document.getElementById("searchBox");
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        row.style.display = (name.includes(filter) || email.includes(filter)) ? "" : "none";
    });
}
</script>
</body>
</html>