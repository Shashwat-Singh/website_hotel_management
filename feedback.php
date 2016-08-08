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
<style >
header{
  margin-top: -1.7%;
}
</style>
<header>  
<a href="index.php" id="logo" >
<h1>Hotel Paradise</h1>
<h5>Banquet|Restaurant|Lounge|Stay</h5>
</a>  
<div id="wrapper">
<nav>
<ul>
<li><a href="index.php" >Home</a></li>
<li><a href="about.php">Contact Us</a></li>
<li><a href="feedback.php" class="selected">Feedback</a></li>
<li><a href="stay.php">Stay</a></li>
<li><a href="login_register.php">Login</a></li>
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
$nameErr = $feedbackErr= "";
$name = $feedback= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
  $nameErr = "Only letters and white space allowed"; 
}  
  }
  
  if (empty($_POST["feedback"])) {
    $feedbackErr = "Feedback is required";
  } else {
    $feedback= test_input($_POST["feedback"]);
  }
 }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<fieldset>
Name:<br>
<input type="text" size="20" name="name" value="<?php echo "$name"; ?>">
<br><span class="error">* <?php echo $nameErr;?></span>
 <br><br>
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
echo '<script type="text/javascript">'; 
echo 'alert("Thank You for your valuable feedback");'; 
echo 'window.location.href = "index.php";';
echo '</script>';
}
$stmt->close();
$conn->close();
?>

</body>
</html>