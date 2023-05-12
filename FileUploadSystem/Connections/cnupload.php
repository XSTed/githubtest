<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnupload = "localhost";
$database_cnupload = "upload";
$username_cnupload = "root";
$password_cnupload = "12345678";
$cnupload = mysql_pconnect($hostname_cnupload, $username_cnupload, $password_cnupload) or trigger_error(mysql_error(),E_USER_ERROR); 
?>