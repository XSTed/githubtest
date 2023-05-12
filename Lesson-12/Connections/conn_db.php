<?php 
//PDO SQL連線指令
$dsn = "mysql:host=localhost;dbname=pharmacy;charset=utf8";
$user = "root";
$password = "12345678";
$link = new PDO($dsn,$user,$password);
// set database credentials
// $servername = "localhost";
// $user = "root";
// $password = "12345678";
// $dbname = "pharmacy";

// // create a PDO object and set the database credentials
// try {
// $link = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $user, $password);
//   // set the PDO error mode to exception
//   $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }
