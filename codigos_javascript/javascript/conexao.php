<?php
session_start();
$servername = "localhost";
$database = "sgc_clinica"; 
$username = "root";
$password = "";
$sql = "mysql:host=$servername;dbname=$database;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

global $conn;
// Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
try { 
  $conn = new PDO($sql, $username, $password, $dsn_Options);  
  
} catch (PDOException $error) {
  //echo 'Connection error: ' . $error->getMessage();
  echo 'Problema em conectar a base de dados';
}
?>