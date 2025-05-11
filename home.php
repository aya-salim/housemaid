<!DOCTYPE html>
<html style="background-image:url('./images/back.jpg');background-attachment:fixed;background-position:center;background-repeat:no-repeat;background-size:cover;">
    <head>
        <meta charset="utf-8">
        <title>Housemaid OM</title>
        <link rel="icon" href="images/logo.png" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="main.css">
        <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
        <link rel = "icon" href = "images/logo.jpg" type = "image/png">
		
		
		 <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <script src="https://use.fontawesome.com/be1ba39dfe.js"></script>
        <link rel="stylesheet" href="product_style.css">
        <style>
               body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('./images/back.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        header {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px 40px;
            text-align: center;
        }
        .site-nav {
            margin-top: 10px;
        }
        .site-nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            font-size: 16px;
        }
        .head-bottom {
            margin-top: 20px;
        }
        .head-bottom h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .head-bottom p {
            font-size: 18px;
            margin: 5px 0;
        }
        .section-body {
            padding: 50px 20px;
            text-align: center;
        }
        .section-body h1 {
            font-size: 32px;
            margin-bottom: 30px;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }
        .image-holder {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            overflow: hidden;
            width: 250px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: transform 0.3s;
        }
        .image-holder:hover {
            transform: translateY(-8px);
        }
        .image-holder img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        @media (max-width: 768px) {
            .gallery {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
    </head>
    <body>
	
        <header class = "header" id = "header">
            <div class = "head-top">
                <div class = "site-name">
                    <form action=""method="post">
                </div>
                <div class = "site-nav">
                   <a href="index.php"> <span id = "nav-btn" name="logout">LOGOUT</i></span></a><br>
				   <a href="cart.php"> <span id = "nav-btn" name="logout">Cart</i></span></a>
                </div>
            </div>
			
</form>
            <div class = 'head-bottom flex'>
                <h2>Housemaid OM</h2>
                <p>Find trusted, professional housemaids easily.</p>
                <p>Browse available maids, check their profiles, and hire the perfect help for your home.</p>
                <p>Fast, simple, and reliable — your comfort is just one click away!</p>
            </div>
        </header>
  <center>      
<div class="section-body">
    <h1 style="color:black;">Select Housemaid Place</h1>
    <div class="gallery">
        <div class="image-holder">
            <a href="rent.php?place=Muscat">
                <img src="images/Muscat.png" alt="Muscat">
                Muscat
            </a>
        </div>

        <div class="image-holder">
            <a href="rent.php?place=Al Wusta">
                <img src="images/Al Wusta.png" alt="Al Wusta">
                Al Wusta
            </a>
        </div>

        <div class="image-holder">
            <a href="rent.php?place=Al Sharqiyah">
                <img src="images/Al Sharqiyah.png" alt="Al Sharqiyah">
                Al Sharqiyah
            </a>
        </div>

        <div class="image-holder">
            <a href="rent.php?place=Al Dhahirah">
            <img src="images/Al Dhahirah.png" alt="Al Dhahirah">
                Al Dhahirah
            </a>
        </div>

        <div class="image-holder">
            <a href="rent.php?place=Al Batinah">
                <img src="images/Al Batinah.png" alt="Al Batinah">
                Al Batinah
            </a>
        </div>

    </div>
    <br><br>
    <div class="gallery">
        <div class="image-holder">
            <a href='cont.php'><button>> CONTACT US <</button></a>
        </div>
    </div>
</div>
</center>
    </body>
</html>

<?php
session_start();
?>