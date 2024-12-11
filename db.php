<?php

$servername = "localhost";
$username = "root";
$password = "admin";
$baseDatos = "biblioteca";

// Create connection
$conexion = new mysqli($servername, $username, $password, $baseDatos);

// Check connection
if($conexion->connect_error){
    die("Connection failed: " . $conexion->connect_error);
}

if(!$conexion->set_charset("utf8mb4")){
    die("Error loading character set utf8mb4: " . $conexion->error);
}

?>