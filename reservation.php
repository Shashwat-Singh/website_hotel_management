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
<header class="reserve">  
<a href="loggedin.php" id="logo" >
<h1>Hotel Paradise</h1>
<h5>Banquet|Restaurant|Lounge|Stay</h5>
</a>  
<div id="wrapper">
<nav>
<ul>
<li><a href="loggedin.php" >Home</a></li>
<li><a href="loggedin_contact.php">Contact Us</a></li>
<li><a href="loggedin_feedback.php">Feedback</a></li>
<li><a href="loggedin_stay.php">Room Tariff</a></li>
<li><a href="reservation.php" class="selected">Reservation</a></li>
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
<?php
$nameErr = $contactErr=$requirementErr=$room_typeErr=$spl_requirementErr= "";
$name = $contact=$requirement=$room_type=$spl_requirement= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (empty($_POST["requirement"])) {
    $requirementErr = "Your room requirement is needed";
  } else 
    $requirement = $_POST["requirement"];

if (empty($_POST["room_type"]) || $_POST["room_type"]=='Select Room Type' ) {
    $room_typeErr = "Your room type is required";
  } else 
    $room_type =$_POST["room_type"];

if (empty($_POST["spl_requirement"])) {
    $spl_requirementErr = "Please mention 'no' in case of no special requirement";
  } else 
    $spl_requirement = $_POST["spl_requirement"];

}
?>
<h6>Reservation Form</h6>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<fieldset>
No of Rooms Required<br>
<input type="radio" name="requirement" value="1" <?php if($requirement=="1")  echo ' checked="checked"';?>>1<br>
<input type="radio" name="requirement" value="2"<?php if($requirement=="2")  echo  'checked="checked"';?>>2<br>
<input type="radio" name="requirement" value="3"<?php if($requirement=="3")  echo ' checked="checked"';?>>3<br>
<input type="radio" name="requirement" value="4"<?php if($requirement=="4")  echo ' checked="checked"';?>>4<br>
<span class="error">* <?php echo $requirementErr;?></span>
<br><br>
<select name="room_type">
  <option value="Select Room Type"> Select Room Type</option>
  <option value="Standard Single" <?php echo ($room_type == 'Standard Single')?'selected="selected"':''; ?>>Standard Single</option>
  <option value="Standard Double"<?php echo ($room_type == 'Standard Double')?'selected="selected"':''; ?>>Standard Double</option>
  <option value="Junior Suite"<?php echo ($room_type == 'Junior Suite')?'selected="selected"':''; ?>>Junior Suite</option>
  <option value="Executive Suite"<?php echo ($room_type == 'Executive Suite')?'selected="selected"':''; ?>>Executive Suite</option>
</select><br>
<span class="error">* <?php echo $room_typeErr;?></span>
<br><br>
Any Special Requirement:<br>
<textarea name="spl_requirement" rows="5" column="10"><?php echo $spl_requirement; ?></textarea>
<br><span class="error">* <?php echo $spl_requirementErr;?></span>
<br>
<input type="submit" value="Book" id="but">
</fieldset>
</form>

<?php
$servername = "mysql.hostinger.in";
$username = "root";
$password = "";
$dbname = "db";
$email=$_SESSION["emailid"];
$name=$_SESSION["name"];
$contact=$_SESSION["contact"];
$amount="";
$a1="1500";
$a2="1800";  
$a3="3000";
$a4="3300";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// prepare and bind
$stmt = $conn->prepare("INSERT INTO reservation (name,contact,email,rooms_required,room_type,special_requirement,amount) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sdsdssd",$name,$contact,$email,$requirement,$room_type,$spl_requirement,$amount);

// set parameters and execute
if($requirement && $room_type && $spl_requirement)
{
if($room_type==='Standard Single')
$amount=$a1*$requirement;
else if($room_type==='Standard Double')
$amount=$a2*$requirement;
else if($room_type==='Junior Suite')
$amount=$a3*$requirement;
else if($room_type==='Executive Suite')  
$amount=$a4*$requirement;
$stmt->execute();
$to = "$email";
$subject = "Reservation at Hotel Paradise";
$txt = "Hello $name, this email is with reference to the reservation you made on our site today, details for which are mentioned below 
\n\n $name \n $contact \n No of rooms required-$requirement \n Room Type-$room_type 
 Special Requirements-$spl_requirement \n Amount Payable-$amount \n\n Regards, \n Hotel Paradise ";
$headers = "From: admin@hotelparadise.esy.es" . "\r\n" .
mail($to,$subject,$txt,$headers);
header("Location: reservation_success.php");
exit;
}
$stmt->close();
$conn->close();
?>

</body>
</html>