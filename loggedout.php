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
<header class="head_about">  
<a href="index.php" id="logo" >
<h1>Hotel Paradise</h1>
<h5>Banquet|Restaurant|Lounge|Stay</h5>
</a>  
</header>
<?php
echo '<script type="text/javascript">'; 
echo 'alert("Logged out Successfully");'; 
echo 'window.location.href = "index.php";';
echo '</script>';
?>

<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
?>
<input type="button" id="but" value="Login again" onclick="location.href = 'login_register.php';">
</body>
</html>