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
<style>
header{
  margin-top: -1.7%;
}
</style>  
<header >  
<a href="loggedin.php" id="logo" >
<h1>Hotel Paradise</h1>
<h5>Banquet|Restaurant|Lounge|Stay</h5>
</a>  
<div id="wrapper">
<nav>
<ul>
<li><a href="loggedin.php" >Home</a></li>
<li><a href="loggedin_contact.php">Contact Us</a></li>
<li><a href="loggedin_feedback.php" class="selected">Feedback</a></li>
<li><a href="loggedin_stay.php" >Room Tariff</a></li>
<li><a href="reservation.php" >Reservation</a></li>
<li><a href="loggedout.php" >Logout</a></li>
</ul>
</nav>
</div>
</header>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<p class="feedbackhead">Feedback Form</p>
<?php
// define variables and set to empty values
$feedbackErr= "";
$feedback= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["feedback"])) {
    $feedbackErr = "Feedback is required";
  } else {
    $feedback= $_POST["feedback"];
  }
 }

?>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<fieldset>
Feedback:<br>
<textarea name="feedback" rows="4" cols="20"><?php echo $feedback;?></textarea>
<br><span class="error">* <?php echo $feedbackErr;?></span>
  <br><br>
<input type="submit" value="Submit" id="but">
</fieldset>
</form>

<?php
$servername = "mysql.hostinger.in";
$username = "root";
$password = "";
$dbname = "db";
$name=$_SESSION["name"];
$email=$_SESSION["emailid"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO feedback (name,feedback) VALUES (?,?)");
$stmt->bind_param("ss",$name,$feedback);

// set parameters and execute
if($name && $feedback)
{
$stmt->execute();
$to = "$email";
$subject = "Regarding your feedback";
$txt = "Dear $name, thanks for providing your valuable feedback \n\n Regards, \n Hotel Paradise ";
$headers = "From: admin@hotelparadise.esy.es" . "\r\n" .
mail($to,$subject,$txt,$headers);
echo '<script type="text/javascript">'; 
echo 'alert("Feedback Submitted Successfully");'; 
echo 'window.location.href = "loggedin.php";';
echo '</script>';
// header("Location: loggedin.php");
}
$stmt->close();
$conn->close();
?>

</body>
</html>