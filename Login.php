<?php require_once('Connections/morguesite.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_morguesite, $morguesite);
$query_Login = "SELECT * FROM users";
$Login = mysql_query($query_Login, $morguesite) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Username'])) {
  $loginUsername=$_POST['Username'];
  $password=$_POST['Password'];
  $MM_fldUserAuthorization = "UserLevel";
  $MM_redirectLoginSuccess = "Account.php";
  $MM_redirectLoginFailed = "Login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_morguesite, $morguesite);

  $LoginRS__query=sprintf("SELECT Username, Password, UserLevel FROM users WHERE Username=%s AND Password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));

  $LoginRS = mysql_query($LoginRS__query, $morguesite) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {

    $loginStrGroup  = mysql_result($LoginRS,0,'UserLevel');

	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="st.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="css/agency.min.css" rel="stylesheet">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
</head>
<body>
<p>&nbsp;</p>
<div id="holder">
<div id="header"></div>
<div id="navbar">
		<nav>
			<ul>
				<li><a href="Login.php">Login</a></li>
				<li><a href="Register.php">Register</a></li>
				<li><a href="Forgotpassword.php">Forgot Password</a></li>
			</ul>
		</nav>
</div>
<div id="content">
	<div id="PageHeading">
	  <h1>Log In!</h1>
	</div>
	<div id="ContentLeft">
	  <h6>&nbsp;</h6>
	  <h6>Insert UserName and Password</h6>
	</div>
	<div id="ContentRight">
	  <form id="LoginForm" name="LoginForm" method="POST" action="<?php echo $loginFormAction; ?>"  onsubmit="return validateform()" >
	    <table width="400" border="0" align="center">
	      <tr>
	        <td><h6><span id="sprytextfield1">UserName:
	          <label for="Username"></label>
	          <br />
	          <br />
  <input name="Username" type="text" class="StyleTxtField" id="Username" />
	          </span></h6></td>
          </tr>
	      <tr>
	        <td>&nbsp;</td>
          </tr>
	      <tr>
	        <td><h6><span id="sprypassword1">Password:
	          <label for="Password"></label>
	          <br />
	          <br />
  <input name="Password" type="password" class="StyleTxtField" id="Password" />
	          </span></h6></td>
          </tr>
	      <tr>
	        <td>&nbsp;</td>
          </tr>
	      <tr>
	        <td><input class="btn btn-lg btn-primary " type="submit" name="LoginButton" id="LoginButton" value="Login" /></td>
          </tr>
	      <tr>
	        <td>&nbsp;</td>
          </tr>
        </table>
      </form>
	</div>
</div>
<div id="footer"></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");

function validateform(){
var Username=document.LoginForm.Username.value;
var Password=document.LoginForm.Password.value;

if (Username==null || Username==""){
  alert("Username can't be blank");
  return false;
if (Password==null || Password==""){
  alert("Password can't be blank");
  return false;
}else if(password.length<6){
  alert("Password must be at least 6 characters long.");
  return false;
}
}}
</script>
</body>
</html>
<?php

/*****
* Query database to retrieve stored
* username and password then check validity below
*****/

$Query_username = "something1";
$Query_pswd = "something2";

$Username = $_POST['Username'];
$Password = $_POST['Password'];

if(($Username == $Query_username) && ($Password == $Query_pswd)) {

  echo "OK, logged in, good to go.";
} else {
  $message = "Username and/or Password incorrect.\\nTry again.";
  echo "<script type='text/javascript'>alert('$message');</script>";
}

?>

<?php
mysql_free_result($Login);
?>
