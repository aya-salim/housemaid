<?php
session_start();
include "condb.php";

if (!isset($_SESSION['uid'])) {
    header("Location: index.php");
    exit;
}

$uid = $_SESSION['uid'];

// Delete expired rents and update housemaid status
$today = date("Y-m-d");
$expired = $conn->prepare("SELECT * FROM rent WHERE uid = ? AND date < ?");
$expired->execute([$uid, $today]);
foreach ($expired->fetchAll(PDO::FETCH_ASSOC) as $ex) {
    $conn->prepare("DELETE FROM rent WHERE id = ?")->execute([$ex['id']]);
    $conn->prepare("UPDATE housemaid SET status = 'Available' WHERE hname = ?")->execute([$ex['hname']]);
}

// Get active rents
$rented = $conn->prepare("SELECT * FROM rent WHERE uid = ?");
$rented->execute([$uid]);
$rentedRows = $rented->fetchAll(PDO::FETCH_ASSOC);

// Get housemaids by place
$maids = [];
if (isset($_GET['place'])) {
    $place = $_GET['place'];
    $stmt = $conn->prepare("SELECT * FROM housemaid WHERE place = ?");
    $stmt->execute([$place]);
    $maids = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Housemaid OM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: url('images/back.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        header {
            background: rgba(0,0,0,0.85);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }
        .site-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            font-size: 16px;
            transition: 0.3s;
        }
        .site-nav a:hover {
            color: #f1c40f;
        }
        .main-content {
            display: flex;
            justify-content: space-between;
            padding: 40px;
            gap: 40px;
        }
        .maids-section {
            flex: 3;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: flex-start;
        }
        .maid-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            overflow: hidden;
            color: white;
            width: 260px;
            transition: transform 0.3s ease;
        }
        .maid-card:hover {
            transform: scale(1.03);
        }
        .maid-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .maid-card h3 {
            font-size: 20px;
            margin: 15px 0 5px;
        }
        .maid-card .status {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .maid-card .status.available {
            color: #2ecc71;
        }
        .maid-card .status.busy {
            color: #e74c3c;
        }
        .rent-btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 15px;
            transition: background 0.3s;
        }
        .rent-btn:hover {
            background: #2980b9;
        }

        .rents-panel {
            flex: 1;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            border-radius: 15px;
            padding: 25px;
            max-height: 85vh;
            overflow-y: auto;
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        .rents-panel h2 {
            font-size: 22px;
            color: #f39c12;
            margin-bottom: 20px;
            text-align: center;
        }
        .rented-item {
            text-align: center;
            margin-bottom: 25px;
            background: rgba(255,255,255,0.05);
            padding: 10px;
            border-radius: 10px;
        }
        .rented-item img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid #f39c12;
        }
        .rented-item h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .rented-item p {
            font-size: 14px;
            color: #ccc;
        }

        @media (max-width: 991px) {
            .main-content {
                flex-direction: column;
                align-items: center;
            }
            .maids-section, .rents-panel {
                width: 90%;
            }
            .rents-panel {
                margin-top: 40px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <h2>Housemaid OM</h2>
    </div>
    <div class="site-nav">
        <a href="home.php">Maps</a>
        <a href="index.php">Logout</a>
        <a href="cart.php">Cart</a>
    </div>
</header>

<div class="main-content">
    <!-- Housemaids Section -->
    <div class="maids-section">
        <?php
        if (count($maids) > 0) {
            foreach ($maids as $row) {
                $statusClass = strtolower($row['status']);
                echo "
                <div class='maid-card'>
                    <img src='images/{$row['img']}' >
                    <h3 style='color:black;'>{$row['hname']}</h3>
                    <div class='status {$statusClass}'>{$row['status']}</div>";
                if ($row['status'] === 'Available') {
                    echo "<a href='housemaid.php?id={$row['id']}' class='rent-btn'>Rent</a>";
                }
                echo "</div>";
            }
        } else {
            echo "<p style='color:white;'>No housemaids found for this location.</p>";
        }
        ?>
    </div>

    <!-- Active Rents Panel -->
    <div class="rents-panel">
        <h2>Your Active Rents</h2>
        <?php
        if (count($rentedRows) > 0) {
            foreach ($rentedRows as $r) {
                echo "
                <div class='rented-item'>
                    <img src='images/{$r['image']}'>
                    <h4>{$r['hname']}</h4>
                    <p>Rent Date: {$r['date']}</p>
                </div>";
            }
        } else {
            echo "<p style='text-align:center; color:#ccc;'>No active rents</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
