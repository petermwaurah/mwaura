<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "Login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<div id="holder">
<div id="header"></div>
<div id="navbar">
		<nav>
			<ul>
				<li><a href="#">Login</a></li>
				<li><a href="#">Register</a></li>
				<li><a href="#">Forgot Password</a></li>
			</ul>
		</nav>
</div>
<div id="content">
	<div id="PageHeading">
	  <h1>Admin CP</h1>
	</div>
	<div id="ContentLeft">
	  <a href="Logout.php">
	  <p>LogOut</p>
	  </a>
	  <p><a href="AdminManageUsers.php">Manage Users</a></p>
	</div>
	<div id="ContentRight">
	  <table width="400" border="0" align="center">
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
	        <td><h6><span id="sprytextfield4">Phone Number:
	          <label for="Username"></label>
	          <br />
	          <br />
  <input name="Username" type="number" class="StyleTxtField" id="Username" required="required" />
            </span></h6></td>
          </tr>
	      <tr>
	        <td>&nbsp;</td>
          </tr>
	      <tr>
	        <td><table border="0">
	          <tr>
	            <td><h6><span id="sprytextfield5">Date of birth:
	              <label for="DOB"></label>
	              <br />
	              <br />
  <input name="Password" type="date" required="required" class="StyleTxtField" id="date" required="required" />
	              </span></h6></td>
	            <td><h6><span id="sprytextfield6">Death Date:
	              <label for="DeathDate"></label>
	              <br />
	              <br />
  <input name="DeathDate" type="date" class="StyleTxtField" id="DeathDate"  required="required"/>
  <div id="password_error" class="val_error"></div>>
	              </span></h6></td>
	            </tr>
            </table></td>
          </tr>
	      <tr>
	        <td>&nbsp;</td>
          </tr>
	      <tr>
	        <td><input type="submit" name="RegisterButton" id="RegisterButton" value="Submit" /></td>
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
	    <tr>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td></td>
        </tr>
      </table>
	</div>
</div>
<div id="footer"></div>
</div>

</div>
<div id="footer"></div>
</div>
</div>
</body>
</html>
