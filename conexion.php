<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "escuela";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=$bdname", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
  $pdo->exec("SET NAMES UTF8");
} catch (PDOException $e) {
  //  echo "Connection failed: " . $e->getMessage();
}
