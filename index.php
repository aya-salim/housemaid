<?php
session_start();
include "condb.php"; // $conn = PDO
$error = "";

if (isset($_POST['login'])) {
    if (!empty($_POST['user']) && !empty($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE uname = ?");
        $stmt->execute([$user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $pass === $row['upass']) {
            $_SESSION['uid'] = $row['id'];
            $_SESSION['username'] = $row['uname'];
            $_SESSION['privilege'] = $row['privilege'];

            if ($row['privilege'] == 0) {
                header("Location: admin.php");
            } elseif ($row['privilege'] == 1) {
                header("Location: account_housemaid.php");
            } else {
                header("Location: home.php");
            }
            exit;
        } else {
            $error = "Wrong username or password.";
        }
    } else {
        $error = "Please enter both username and password.";
    }
}

if (isset($_POST['reg'])) {
    header("Location: reg.php");
    exit;
}

if (isset($_POST['con'])) {
    header("Location: cont.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="images/logo.png" type="image/png">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans:400,700&display=swap');
        body {
            background-image: url("images/hero_cleaner.png");
            background-size: cover;
            background-position: center;
            font-family: 'Noto Sans', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .box {
            background-color: rgba(0, 0, 0, 0.85);
            padding: 60px 80px;
            border-radius: 8px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            width: 350px;
        }
        .text-center {
            text-align: center;
            font-size: 24px;
            text-transform: uppercase;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .input-container {
            position: relative;
            margin-bottom: 25px;
        }
        .input-container label {
            position: absolute;
            top: 0;
            left: 0;
            color: #bbb;
            font-size: 16px;
            pointer-events: none;
            transition: 0.3s ease;
        }
        .input-container input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #999;
            background: transparent;
            padding: 10px 0;
            color: white;
            font-size: 16px;
        }
        .input-container input:focus {
            border-color: #e74c3c;
            outline: none;
        }
        .input-container input:focus ~ label,
        .input-container input:valid ~ label {
            top: -14px;
            font-size: 12px;
            color: #e74c3c;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            background: #e74c3c;
            color: white;
            text-transform: uppercase;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background: #c0392b;
        }
        .error {
            color: #e74c3c;
            background: #ffe6e6;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="box">
        <form action="" method="post">
            <div class="text-center">Login</div>
            <div class="input-container">
                <input type="text" name="user" >
                <label>Username</label>
            </div>
            <div class="input-container">
                <input type="password" name="pass" >
                <label>Password</label>
            </div>
            <div style="margin-top: 30px; text-align: center;">
                <button type="submit" name="login" class="btn">Login</button>
                <button type="submit" name="reg" class="btn">Signup</button>
                <button type="submit" name="con" class="btn">Contact</button>
            </div>
            <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        </form>
    </div>
</body>
</html>
