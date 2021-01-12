<?php
session_start();
require_once "connection.php";
include("functions.php");  
$user_data = check_login($conn);

if(isset($_POST["token"]) and isset($_POST["supermarket"])){

    $superMarket = $_POST["supermarket"];

    if($superMarket == 1){
        $tokenLetters = "ess";
    }else{
        $tokenLetters = "coo";
    }

    $query = "select * from tokens where id = $superMarket";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);

        $token = intval(substr($row["token"], 3));
        $token++;


        $query1 = "update tokens set token = \"$tokenLetters$token\" where id = $superMarket";
        mysqli_query($conn, $query1);

    }else{
        $tokenLetters = $tokenLetters."1";
        $query2 = "insert into tokens (id, token) values ($superMarket, \"$tokenLetters\")";
        mysqli_query($conn, $query2);
    }
}
?>
  <div align="center"> 
  	<meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

 
      <h1>generate QR (quick response) code</h1>
      <p>Supermarket store id for Esselunga: 1, for Coop: 2.</p>
     
	  <!-- lets create qr in dynamic way -->
	  <form action="qrcode.php" method="post">
	  	<p>Enter your preffered date below.
	  	for example 01-01-2021. day-month-year format.</p>
	  	<input type="text" name="date" placeholder="enter date here"/><br>
	  	<P>Enter your expected time slot below.
	  	for example 11:00am-11:15am</P>
	  	<input type="text" name="time" placeholder="enter time here"/><br>
	  	<p>Choose your preffered supermarket </p>
	  	<input type="radio" name="supermarket" id="esselunga" value="1"> Esselunga<br>
	  	<input type="radio" name="supermarket" id="esselunga" value="2"> Coop<br>
	  	<P>Choose atleast one the category sections!</P>
	  	<select multiple name="wishList[]" style="width:100px ;">
	  	<option value = "Fruits_vegetables">fruits vegetables </option>
	  	<option value = "Dairy_products">dairy products </option>
	  	<option value = "Stationery_products">stationery products </option>
	  	<option value = "Cleaning_products">cleaning products </option>
	  	<option value = "Snacks_drinks">snacks drinks </option>
	    </select><br>
	  <input type="submit" class="button" name="token" value="Get Token"/><br>
	  </form>

	  <?php
	  if( isset($_POST['token']) && (isset($_POST['wishList'])) && (isset($_POST['supermarket'])) && (isset($_POST['date'])) && (isset($_POST['time'])) ) 
	  {
	  	$date = trim($_POST['date']);
	  	$time = trim($_POST['time']);
	  	$supermarket = trim($_POST['supermarket']);
	  	$data = implode(",",$_POST['wishList']);

		 // here we have to display token number.
	  	$query = "select * from tokens";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
        $token = $row["token"];

        if (($superMarket == 1) && (intval($row["id"]) === 1)) {
            echo "<h1>Esselunga Token: $token</h1>";
        }
        if (($superMarket == 2) && (intval($row["id"]) === 2)) {
            echo "<h1>Coop Token: $token</h1>";
        }
        }
        }
		 
		  
		  // set timezone
		  date_default_timezone_set('Europe/Rome');
		  // display the date and time with greetings
		  function show_date(){
		  	return date('l,jS F H:i');
		  }
		  function greeting(){
		  	$hour = date('H');
		  	if($hour < 12){
		  		$greeting = "Good morning!";
		  	}
		  	else{
		  		$greeting = "Good day!";
		  	}
		  	return $greeting;
		  }
		  echo show_date();
		  echo "<br/>". greeting();

		  // qr code with data...
		  echo "<img src='https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl= $date, $time, $supermarket, $data' height=250 width=250/>";
		  echo "Take screenshot before leaving! ";	  
	  }else{
	  	echo "You are required to fill all the fields.";
	  }
	  ?>
	  <div align="center"></div>
	  <!DOCTYPE html>
	  <html>
	  <head>
	  	<title></title>
	  </head>
	  <body>
	  	<a href="index.php">Go to home page</a>
	  
	  </body>
	  </html>
	  </div>
</div>
