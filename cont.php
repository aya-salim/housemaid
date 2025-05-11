<!DOCTYPE html>
<html >
    <head>
    <link rel="icon" href="images/logo.png" type="image/png">

        <title>Housemaid OM</title>
		 <link rel="stylesheet" href="mainn.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="1contactform.css">
    
    </head>
    <body style="background-image:url('images/cont.png');background-attachment:fixed;background-position:center;background-repeat:no-repeat;background-size:cover;">
	
        <header class = "header" id = "header">
            <div class = "head-top">
                <div class = "site-name">
                    <form action=""method="post">
                </div>
                <div class = "site-nav">
                   <a href="index.php"style='color:white;'> <span id = "nav-btn" name="logout">Login page</i></span></a>
				   
                </div>
            </div>
			
</form>
            <div class = 'head-bottom flex'>
                <h2>Contact Us</h2>
               
            </div>
       

     <section class="contact">
        
        <div class="container">
            <div class="contactInfo">
                <div class="box">
                    <div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Address</h3>
                        <p>3478 Muscat,<br>Oman,<br>25689</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                    <div class="text">
                        <h3>Phone</h3>
                        <p>+968 93644644</p>
                    </div>
                </div>
                <div class="box">
                    <div class="icon"><i class="fa fa-envelope-o" aria-hidden="true"></i></i></div>
                    <div class="text">
                        <h3>Email</h3>
                        <p>housemaid.om@gmail.com</p>
                    </div>
                </div>
            </div>
			
            <div class="contactForm">
                <form method="post" action="">
                    <h2>Send Message</h2>
                    <div class="inputBox">
                        <input type="text" name="name">
                        <span>Full Name</span>
                    </div>
                    <div class="inputBox">
                        <input type="text" name="mail">
                        <span>Eamil</span>
                    </div>
                    <div class="inputBox">
                        <textarea name="msg" id="" ></textarea>
                        <span>Type your Message...</span>
                    </div>
                    <div class="inputBox">
                        <input type="submit" value="Send" name="sub">
                    </div>
                
			</form>
			 </div>
        </div>
		 </header>
    </section>      
    </body>
</html>

<?php
	include "condb.php";
	if(isset($_POST['sub']))
	{
		if(!empty($_POST['mail'])
			&& !empty($_POST['name'])
			&& !empty($_POST['msg']))
			{
				$mail = $_POST['mail'];
				$name = $_POST['name'];
				$msg = $_POST['msg'];
				
				include"condb.php";
				$sql ="insert into cont (fname, email, msg) values(:name, :mail, :msg)";
				$stmt = $conn -> prepare($sql);
				$stmt -> execute(array(
				':name' => $name,
				':mail' => $mail,
				':mas' => $msg
				));
				
				
				
			}
			else{
				echo "Please fill all the boxes...";
			}
	}
	
?>