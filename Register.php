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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="Register.php";
  $loginUsername = $_POST['Username'];
  $LoginRS__query = sprintf("SELECT Username FROM users WHERE Username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_morguesite, $morguesite);
  $LoginRS=mysql_query($LoginRS__query, $morguesite) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm")) {
  $insertSQL = sprintf("INSERT INTO users (Fname, Lname, Email, Username, Password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['FName'], "text"),
                       GetSQLValueString($_POST['LName'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Username'], "text"),
                       GetSQLValueString($_POST['Password'], "text"));

  mysql_select_db($database_morguesite, $morguesite);
  $Result1 = mysql_query($insertSQL, $morguesite) or die(mysql_error());

  $insertGoTo = "Login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_morguesite, $morguesite);
$query_Register = "SELECT * FROM users";
$Register = mysql_query($query_Register, $morguesite) or die(mysql_error());
$row_Register = mysql_fetch_assoc($Register);
$totalRows_Register = mysql_num_rows($Register);
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
	  <h1>sign up</h1>
	</div>
	<div id="ContentLeft">
	  <h2>your message here</h2>
	  <p>&nbsp;</p>
	  <h6>your message</h6>
	</div>
  <div id="ContentRight">
    <form id="RegisterForm" name="RegisterForm" method="POST" action="<?php echo $editFormAction;?>" onsubmit="return matchpass(); return matchpass();">
      <table width="400" border="0" align="center">
        <tr>
          <td><table border="0">
            <tr>
              <td><h6><span id="sprytextfield1">First Name:
                <label for="FName"></label>
                <br />
                <br />
  <input name="FName" type="text" class="StyleTxtField" id="FName" required="required" />
                </span></h6></td>
              <td><h6><span id="sprytextfield2">Last Name:
                <label for="LName"></label>
                <br />
                <br />
  <input name="LName" type="text" class="StyleTxtField" id="LName" required="required"/>
                </span></h6></td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><h6><span id="sprytextfield3">Email:
            <label for="Email"></label>
            <br />
            <br />
              <input name="Email" type="email" class="StyleTxtField" id="Email" required="required" />
          </span></h6></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><h6><span id="sprytextfield4">Username:
            <label for="Username"></label>
            <br />
            <br />
  <input name="Username" type="text" class="StyleTxtField" id="Username" required="required" />
            </span></h6></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><table border="0">
            <tr>
              <td><h6><span id="sprypassword1">Password:
                <label for="Password"></label>
                <br>
                <br>
  <input name="Password" type="password" required="required" class="StyleTxtField" id="Password" required="required" />
                </span></h6></td>
              <td><h6><span id="spryconfirm1">Confirm Password:
                <label for="PasswordConfirm"></label>
                <br>
                <br>
  <input name="PasswordConfirm" type="password" class="StyleTxtField" id="PasswordConfirm"  required="required"/>
  <div id="password_error" class="val_error"></div>>
                </span></h6></td>
              </tr>
            </table></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td><input type="submit" name="RegisterButton" id="RegisterButton" value="Register" /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          </tr>
        </table>
      <input type="hidden" name="MM_insert" value="RegisterForm" />
      </form>
  </div>
</div>
</div>
<div id="footer"></div>
</div>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "Password");

function matchpass(){
var Password=document.RegisterForm.Password.value;
var PasswordConfirm=document.RegisterForm.PasswordConfirm.value;

if(Password==PasswordConfirm){
return true;
}
else{
alert("password must be same!");
return false;
}
}

function validateemail()
{
var x=document.RegisterForm.Email.value;
var atposition=x.indexOf("@");
var dotposition=x.lastIndexOf(".");
if (atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length){
  alert("Please enter a valid e-mail address \n atpostion:"+atposition+"\n dotposition:"+dotposition);
  return false;
  }
}
</script>
</body>
</html>
<?php
mysql_free_result($Register);
?>
