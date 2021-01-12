<?php 
session_start();
include("connection.php");
include("functions.php");  
$user_data = check_login($conn);
 ?>
<div align="center">
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Customer line up site</title>
 </head>
 <body>

    <a href="logout.php">Logout</a>
 	<h1>Welcome to customer line-up</h1>

 	<br>
 	hello, <?php echo $user_data['user_name']; ?> 
 	<br>
 	
 	<a href="qrcode.php">Reserve Token</a>
 	
 </body>
 </html>
</div>
