<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_morgue = "localhost";
$database_morgue = "mwaura";
$username_morgue = "root";
$password_morgue = "";
$morgue = mysql_pconnect($hostname_morgue, $username_morgue, $password_morgue) or trigger_error(mysql_error(),E_USER_ERROR); 
?>