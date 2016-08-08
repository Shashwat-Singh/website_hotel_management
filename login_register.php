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
<li><a href="feedback.php">Feedback</a></li>
<li><a href="stay.php">Stay</a></li>
<li><a href="login_register.php" class="selected">Login</a></li>
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
$emailidErr = $passwordErr= "";
$emailid = $pass= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["emailid"])) 
    $emailidErr = "Email id is required";

   else 
    $emailid = $_POST["emailid"];
 


if (empty($_POST["pass"]))
    $passwordErr = "Password is required";
  
     else 
     $pass = $_POST["pass"];

}
?>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<fieldset>
Email Id:<br>
<input type="text" name="emailid" value="<?php echo "$emailid"; ?>">
<br><span class="error">* <?php echo $emailidErr;?></span>
<br><br>
Password:<br>
<input type="password" name="pass" value="<?php echo "$pass"; ?>">
<br><span class="error">* <?php echo $passwordErr;?></span>
<br>
<input type="submit" value="Login" id="but">
<input type="button" id="but" value="Register" onclick="location.href = 'register.php';">

</fieldset>
</form>

<?php
$servername = "mysql.hostinger.in";
$username = "root";
$password = "";
$dbname = "db";
$found=0;

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($emailid && $pass)
{

$sql = "SELECT name,contact,email,password FROM register";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($row["email"]==$emailid && $row["password"]==$pass)
        {$found=1;
        $_SESSION["name"]=$row["name"];
        $_SESSION["contact"]=$row["contact"];	
        }
        }
        if($found==1)
        {	
        $_SESSION["emailid"]=$emailid;
        header("Location: loggedin.php");	
        }
        }
if($found==0)
      {
     echo '<script language="javascript">';
echo 'alert("Invalid email id or password,please register if you havent done that yet.")';
echo '</script>';
     }}
  ?>
</body>
