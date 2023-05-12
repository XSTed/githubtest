<?php 
//PDO SQL連線指令
$dsn = "mysql:host=localhost;dbname=pharmacy;charset=utf8";
$user = "root";
$password = "12345678";
$link = new PDO($dsn,$user,$password);
?>