<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Housemaid OM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: url('images/hero_cleaner.png') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 40px;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
            color: #fff;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 25px;
            color: #fff;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            width: 240px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .price {
            font-size: 18px;
            color: #f1c40f;
        }

        .total {
            font-size: 22px;
            text-align: center;
            margin: 30px 0 10px;
            color: #fff;
            font-weight: bold;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .submit-btn, .cancel-btn {
            font-size: 16px;
            padding: 12px 30px;
            margin: 10px;
            border: none;
            border-radius: 30px;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn {
            background: #28a745;
        }

        .submit-btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .cancel-btn {
            background: #dc3545;
        }

        .cancel-btn:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        .empty-msg {
            text-align: center;
            font-size: 20px;
            color: #eee;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" action="">
        <h1>Your Cart</h1>
        <div class="gallery">
            <?php
            session_start();
            include "condb.php";

            $uid = $_SESSION['uid'];
            $sql = "SELECT * FROM cart WHERE uid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$uid]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $n = $stmt->rowCount();
            $total = 0;

            if ($n > 0) {
                foreach ($rows as $row) {
                    echo "<div class='card'>
                            <img src='images/{$row['image']}' alt='Image'>
                            <div class='price'>Price: {$row['price']} OMR</div>
                          </div>";
                    $total += $row['price'];
                }
            } else {
                echo "<p class='empty-msg'>Your cart is empty.</p>";
            }

            echo "<div class='total'>Total Price: $total OMR</div>";

            if (isset($_POST['next']) && $n > 0) {
                // Insert into rent table
                $insertSql = "INSERT INTO rent (uid, hname, date, image) 
                              SELECT uid, hname, date, image FROM cart WHERE uid = ?";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->execute([$uid]);

                // Update housemaid status to Busy
                foreach ($rows as $row) {
                    $update = $conn->prepare("UPDATE housemaid SET status = 'Busy' WHERE hname = ?");
                    $update->execute([$row['hname']]);
                }

                // Clear cart
                $deleteSql = "DELETE FROM cart WHERE uid = ?";
                $deleteStmt = $conn->prepare($deleteSql);
                $deleteStmt->execute([$uid]);

                echo "<script>window.location.href='buy.php?total=$total';</script>";
                exit;
            }

            if (isset($_POST['cancel'])) {
                header("Location: home.php");
                exit;
            }
            ?>
        </div>

        <div class="btn-container">
            <input type="submit" name="next" value="Buy" class="submit-btn">
            <input type="submit" name="cancel" value="Cancel" class="cancel-btn">
        </div>
    </form>
</div>

</body>
</html>
