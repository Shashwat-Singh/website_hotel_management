<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Hotel Paradise</title>
<link href='https://fonts.googleapis.com/css?family=Changa+One|Open+Sans:400,400italic,700,700italic,800' rel='stylesheet' type='text/css'>
<link rel="Stylesheet" href="main.css">
<link rel="Stylesheet" href="responsive.css">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<body>  
<header >  
<a href="loggedin.php" id="logo" >
<h1>Hotel Paradise</h1>
<h5>Banquet|Restaurant|Lounge|Stay</h5>
</a>  
<div id="wrapper">
<nav>
<ul>
<li><a href="loggedin.php" class="selected">Home</a></li>
<li><a href="loggedin_contact.php">Contact Us</a></li>
<li><a href="loggedin_feedback.php">Feedback</a></li>
<li><a href="loggedin_stay.php">Room Tariff</a></li>
<li><a href="reservation.php" >Reservation</a></li>
<li><a href="loggedout.php" >Logout</a></li>
</ul>
</nav>
</div>
</header>
<body>
<style>
p{
	font-size: 1.5em;
}
header{
	margin-top: -1.5%;
}
h7{
	font-size: 1.3em;
font-weight: bolder;
}
</style>
<p>Welcome to Hotel Paradise</p>
<h7>Your current bookings:-</h7>

<?php
$servername = "mysql.hostinger.in";
$username = "root";
$password = "";
$dbname = "db";
$email=$_SESSION["emailid"];
$cost=$requirement=$room_type="";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id,amount,email,rooms_required,room_type,special_requirement FROM reservation";
$result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
    	if($row["email"]==$email)
        {
 echo "<br><br>Booking Id= ".$row["id"]."<br>" . " Rooms required: " . $row["rooms_required"]. "<br><br>  Room Type: " . $row["room_type"]. "  <br><br>Special Requirement:- " . $row["special_requirement"]. "<br>";
   echo "Amount Payable:-".$row["amount"]."<br>"; 
    }}
 $conn->close();
?>
</body>
</html>	