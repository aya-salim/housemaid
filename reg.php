<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Registration - Housemaid OM</title>
    <link rel="icon" href="images/logo.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
    @import url('https://fonts.googleapis.com/css?family=Noto+Sans:400,700&display=swap');

    body {
        background-image: url("images/signup_cleaner.png");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        min-height: 100vh;
        font-family: 'Noto Sans', sans-serif;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .box {
        background-color: rgba(0, 0, 0, 0.85);
        padding: 50px 40px;
        border-radius: 10px;
        width: 350px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }
    .text-center {
        color: #fff;
        text-transform: uppercase;
        font-size: 24px;
        margin-bottom: 30px;
        display: block;
        text-align: center;
    }
    .input-container {
        position: relative;
        margin-bottom: 20px;
    }
    .input-container input,
    select {
        width: 100%;
        padding: 10px 10px 10px 5px;
        background: transparent;
        border: none;
        border-bottom: 2px solid #aaa;
        color: white;
        font-size: 16px;
        margin-top: 10px;
        outline: none;
        transition: border-color 0.3s;
    }
    select {
        background-color: rgba(255,255,255,0.1);
        border-radius: 5px;
    }
    .input-container label {
        position: absolute;
        top: 10px;
        left: 5px;
        color: #aaa;
        font-size: 16px;
        transition: 0.3s;
        pointer-events: none;
    }
    .input-container input:focus ~ label,
    .input-container input:valid ~ label {
        top: -10px;
        font-size: 12px;
        color: #e74c3c;
    }
    select:focus {
        border-color: #007BFF;
    }
    .btn {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        width: 45%;
    }
    .btn.cancel {
        background-color: grey;
        margin-left: 10%;
    }
    .btn:hover {
        opacity: 0.9;
    }
    </style>
</head>
<body>

<div class="box">
    <form action="" method="post">
        <span class="text-center">Registration</span>

        <div class="input-container">
            <input type="text" name="uname" required />
            <label>Username</label>
        </div>

        <div class="input-container">
            <input type="email" name="email" required />
            <label>Email</label>
        </div>

        <div class="input-container">
            <select name="place" id="place" required>
                <option value="" style="color:black;">-- Choose Place --</option>
                <option value="Al Batinah" style="color:black;">Al Batinah</option>
                <option value="Al Dhahirah" style="color:black;">Al Dhahirah</option>
                <option value="Al Sharqiyah" style="color:black;">Al Sharqiyah</option>
                <option value="Al Wusta" style="color:black;">Al Wusta</option>
                <option value="Muscat" style="color:black;">Muscat</option>
            </select>
        </div>

        <div class="input-container">
            <input type="password" name="pass" required />
            <label>Password</label>
        </div>

        <div class="input-container">
            <input type="password" name="passr" required />
            <label>Confirm Password</label>
        </div>

        <div style="text-align:center;">
            <button type="submit" class="btn" name="reg">Register</button>
            <button type="submit" class="btn cancel" name="can">Cancel</button>
        </div>

        <?php
        include "condb.php";

        if (isset($_POST['reg'])) {
            if (!empty($_POST['email']) && !empty($_POST['uname']) && !empty($_POST['pass']) && !empty($_POST['passr']) && !empty($_POST['place'])) {
                $us = $_POST['uname'];
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $passr = $_POST['passr'];
                $place = $_POST['place'];
                $privilege = 2;

                if ($pass == $passr) {
                    // Corrected SQL syntax with closing parenthesis
                    $sql = "INSERT INTO users (uname, uemail, upass, place, privilege) VALUES (:us, :em, :pass, :place, :privilege)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':us' => $us,
                        ':em' => $email,
                        ':pass' => $pass,
                        ':place' => $place,
                        ':privilege' => $privilege
                    ]);
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<p style='color:red;text-align:center;margin-top:20px;'>Passwords do not match!</p>";
                }
            } else {
                echo "<p style='color:red;text-align:center;margin-top:20px;'>Please fill all the fields!</p>";
            }
        }

        if (isset($_POST['can'])) {
            header("Location: index.php");
            exit();
        }
        ?>
    </form>
</div>

</body>
</html>