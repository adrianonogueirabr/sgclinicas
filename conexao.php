<?php


//conexao local

$servername =     "localhost";
$database = "sgclinic_db"; 
$username = "root";
$password = "";

$sql = "mysql:host=$servername;dbname=$database;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

global $con;
// Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
try { 
    $con = new PDO($sql, $username, $password, $dsn_Options); 
} catch (PDOException $error) {
    echo 'Connection error: ' . $error->getMessage();
}
