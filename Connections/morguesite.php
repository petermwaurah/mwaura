<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_morguesite = "localhost";
$database_morguesite = "user_id";
$username_morguesite = "root";
$password_morguesite = "";
$morguesite = mysql_pconnect($hostname_morguesite, $username_morguesite, $password_morguesite) or trigger_error(mysql_error(),E_USER_ERROR); 
?>