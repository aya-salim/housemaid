<?php
include "condb.php";
session_start();
$uid = $_SESSION['uid'];

// Get user place
$userPlaceStmt = $conn->prepare("SELECT place FROM users WHERE id = ?");
$userPlaceStmt->execute([$uid]);
$userPlace = $userPlaceStmt->fetchColumn();

$id = $_GET['id'];
$sql = "SELECT * FROM housemaid WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent Housemaid - Housemaid OM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.png" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            background-image: url("images/book_cleaner.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0,0,0,0.2);
            width: 400px;
            text-align: center;
        }
        .container img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .container h2 {
            margin: 10px 0 5px;
            font-size: 24px;
            color: #333;
        }
        .container p {
            margin: 5px 0;
            font-size: 18px;
            color: #555;
        }
        .inputBox {
            margin: 20px 0;
        }
        .card-number-input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
            border: 1px solid #aaa;
            border-radius: 5px;
            outline: none;
        }
        .submit-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" action="">

        <?php
        if ($stmt->rowCount() > 0) {
            foreach ($rows as $row) {
                $maidPlace = $row['place'];
                $price_per_hour = ($userPlace === $maidPlace) ? 3 : 5;

                echo "
                    <img src='images/{$row['img']}' alt='{$row['hname']}'>
                    <h2>{$row['hname']}</h2>
                    <p>{$row['place']}</p>
                    <div class='inputBox'>
                        <p style='font-size:18px;'>Price: {$price_per_hour} OMR per hour</p>
                        <label style='display:block; margin-top:10px;'>Number of hours</label>
                        <input type='number' name='nhour' class='card-number-input' required>

                        <label style='display:block; margin-top:15px;'>Select Rent Date</label>
                        <input type='date' name='date' class='card-number-input' required>
                    </div>
                ";

                if (isset($_POST['next']) && !empty($_POST['nhour']) && !empty($_POST['date'])) {
                    $total_price = $price_per_hour * $_POST['nhour'];
                    $hname = $row['hname'];
                    $img = $row['img'];
                    $date = $_POST['date'];

                    $sqlInsert = "INSERT INTO cart (uid, hname, price, date, image) 
                                  VALUES (:uid, :hn, :price, :dt, :img)";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->execute([
                        ':uid' => $uid,
                        ':hn' => $hname,
                        ':price' => $total_price,
                        ':dt' => $date,
                        ':img' => $img
                    ]);

                    echo "<script>window.location.href='home.php';</script>";
                    exit();
                }
            }
        } else {
            echo "<p>No housemaid found.</p>";
        }
        ?>

        <input type="submit" name="next" value="Buy" class="submit-btn">
    </form>
</div>

</body>
</html>
