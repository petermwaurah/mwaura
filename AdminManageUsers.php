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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_POST['DeleteUserhiddenField'])) && ($_POST['DeleteUserhiddenField'] != "") && (isset($_POST['UserID']))) {
  $deleteSQL = sprintf("DELETE FROM users WHERE UserID=%s",
                       GetSQLValueString($_POST['DeleteUserhiddenField'], "int"));

  mysql_select_db($database_morguesite, $morguesite);
  $Result1 = mysql_query($deleteSQL, $morguesite) or die(mysql_error());

  $deleteGoTo = "AdminManageUsers.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_ManageUsers = 10;
$pageNum_ManageUsers = 0;
if (isset($_GET['pageNum_ManageUsers'])) {
  $pageNum_ManageUsers = $_GET['pageNum_ManageUsers'];
}
$startRow_ManageUsers = $pageNum_ManageUsers * $maxRows_ManageUsers;

mysql_select_db($database_morguesite, $morguesite);
$query_ManageUsers = "SELECT * FROM users ORDER BY `Timestamp` DESC";
$query_limit_ManageUsers = sprintf("%s LIMIT %d, %d", $query_ManageUsers, $startRow_ManageUsers, $maxRows_ManageUsers);
$ManageUsers = mysql_query($query_limit_ManageUsers, $morguesite) or die(mysql_error());
$row_ManageUsers = mysql_fetch_assoc($ManageUsers);

if (isset($_GET['totalRows_ManageUsers'])) {
  $totalRows_ManageUsers = $_GET['totalRows_ManageUsers'];
} else {
  $all_ManageUsers = mysql_query($query_ManageUsers);
  $totalRows_ManageUsers = mysql_num_rows($all_ManageUsers);
}
$totalPages_ManageUsers = ceil($totalRows_ManageUsers/$maxRows_ManageUsers)-1;

$queryString_ManageUsers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ManageUsers") == false && 
        stristr($param, "totalRows_ManageUsers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ManageUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ManageUsers = sprintf("&totalRows_ManageUsers=%d%s", $totalRows_ManageUsers, $queryString_ManageUsers);
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
	  <h1>page heading</h1>
	</div>
	<div id="ContentLeft">
	  <h2><a href="Logout.php">Log Out</a></h2>
	</div>
	<div id="ContentRight">
	  <table width="662" border="1">
	    <tbody>
	      <tr>
	        <td width="652" align="right" valign="top">Showing&nbsp;<?php echo ($startRow_ManageUsers + 1) ?>to <?php echo min($startRow_ManageUsers + $maxRows_ManageUsers, $totalRows_ManageUsers) ?>of <?php echo $totalRows_ManageUsers ?></td>
          </tr>
	      <tr>
	        <td><?php if ($totalRows_ManageUsers > 0) { // Show if recordset not empty ?>
              <?php do { ?>
	              <table width="500" border="1" align="center">
	                <tbody>
	                  <tr>
	                    <td><?php echo $row_ManageUsers['Fname']; ?><?php echo $row_ManageUsers['Lname']; ?> |<?php echo $row_ManageUsers['Email']; ?>
	                      <form id="DeleteUserForm" name="DeleteUserForm" method="post" action="">
	                        <input name="DeleteUserhiddenField" type="hidden" id="DeleteUserhiddenField" value="<?php echo $row_ManageUsers['UserID']; ?>" />
	                        <input type="button" name="DeleteUserButton" id="DeleteUserButton" value="Delete User" />
                        </form></td>
                      </tr>
	                  <tr>
	                    <td>&nbsp;</td>
                      </tr>
	                  <tr>
	                    <td>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
	              <?php } while ($row_ManageUsers = mysql_fetch_assoc($ManageUsers)); ?>
              <?php } // Show if recordset not empty ?></td>
          </tr>
	      <tr>
	        <td align="right" valign="top"><?php if ($pageNum_ManageUsers < $totalPages_ManageUsers) { // Show if not last page ?>
	            Next
  <?php } // Show if not last page ?>
|
<?php if ($pageNum_ManageUsers > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_ManageUsers=%d%s", $currentPage, max(0, $pageNum_ManageUsers - 1), $queryString_ManageUsers); ?>">Previous</a>
  <?php } // Show if not first page ?>            </td>
          </tr>
        </tbody>
      </table>
	</div>
</div>
<div id="footer"></div>
</div>
</body>
</html>
<?php
mysql_free_result($ManageUsers);
?>
