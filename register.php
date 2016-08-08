<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Hotel Paradise</title>
<link href='https://fonts.googleapis.com/css?family=Changa+One|Open+Sans:400,400italic,700,700italic,800' rel='stylesheet' type='text/css'>
<link rel="Stylesheet" href="main.css">
<link rel="Stylesheet" href="responsive.css">
<meta name="viewport" content="width=device-width,initial-scale=1.0">  
<header>  
<a href="index.php" id="logo" >
<h1>Hotel Paradise</h1>
<h5>Banquet|Restaurant|Lounge|Stay</h5>
</a>  
</header>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<?php
$nameErr = $contactErr=$emailidErr=$passwordErr=$confirmpasswordErr= "";
$name = $contact=$emailid=$pass=$confirmpassword= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if (empty($_POST["name"])) 
    $nameErr = "Name is required";

else if (!preg_match("/^[a-zA-Z ]*$/",$_POST["name"])) 
  $nameErr = "Only letters and white space allowed";

   else 
    $name = $_POST["name"];
 


if (empty($_POST["contact"]))
    $contactErr = "Contact is required";
  
  else if(strlen($_POST["contact"])>0 && strlen($_POST["contact"])<10 || strlen($_POST["contact"])>10 || !preg_match("/^[0-9]{10}$/", $_POST["contact"]))
  $contactErr = "Please enter a valid 10 digit contact number";
  
   else 
     $contact = $_POST["contact"];
    
if (empty($_POST["emailid"])) {
    $emailidErr = "Email is required";
  } 

    else if (!filter_var( $_POST["emailid"], FILTER_VALIDATE_EMAIL)) {
      $emailidErr = "Invalid email format"; 
    }
  
else {
    $emailid= $_POST["emailid"];
    }


if (empty($_POST["pass"]))
    $passwordErr = "Password is required";
  
  
else if(strlen($_POST["pass"])<6)
     $passwordErr = "Password should have atleast 6 characters"; 

     else 
       	$pass = $_POST["pass"];
       

if (empty($_POST["confirmpassword"]))
    $confirmpasswordErr = "Password is required";
  
    else if($_POST["confirmpassword"] != $pass)
  $confirmpasswordErr = "Passwords dont match";   	
     else 
     $confirmpassword = $_POST["confirmpassword"];

}
?>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<fieldset>
Name:<br>
<input type="text" name="name" value="<?php echo "$name"; ?>">
<br><span class="error">* <?php echo $nameErr;?></span>
<br>
Contact Number:<br>
<input type="tel" name="contact" value="<?php echo "$contact"; ?>">
<br><span class="error">* <?php echo $contactErr;?></span>
<br>
E-mail Id: <br><input type="email" name="emailid" size="25" value="<?php echo "$emailid"; ?>">
<br><span class="error">* <?php echo $emailidErr;?></span>
<br>
Password:<br>
<input type="password" name="pass" value="<?php echo "$pass"; ?>">
<br><span class="error">* <?php echo $passwordErr;?></span>
<br>
Confirm Password:<br>
<input type="password" name="confirmpassword" value="<?php echo "$confirmpassword"; ?>">
<br><span class="error">* <?php echo $confirmpasswordErr;?></span>
<br>
<span style="display:inline-block; width: 3.2%;"></span>
<input type="submit" value="Submit" id="but">
<input type="button" id="but" value="I Already have an account" onclick="location.href = 'login_register.php';">
</form>

<?php
$servername = "mysql.hostinger.in";
$username = "root";
$password = "";
$dbname = "db";
$found="";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($name && $contact && $emailid && $pass && $confirmpassword)
{

$sql = "SELECT email FROM register";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($row["email"]==$emailid)
        $found=1;
        }
        if($found==1)
        	{
          echo '<script type="text/javascript">'; 
echo 'alert("Your Record already Exists please login with your registered details");'; 
echo 'window.location.href = "login_register.php";';
echo '</script>';
          }}
      if($found==0)
      {
$stmt = $conn->prepare("INSERT INTO register (name,contact,email,password) VALUES (?,?,?,?)");
$stmt->bind_param("sdss",$name,$contact,$emailid,$pass);
$stmt->execute();
echo "Registration done successfully";
header("Location: registeration_success.php");
exit;
}
}
?>

</body>
</html>




