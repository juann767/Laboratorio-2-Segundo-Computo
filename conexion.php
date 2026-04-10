<?php
//mysqli o pdo 

$host = "127.0.0.1";
$user = "juan123";
$pass = "12345678Perro"; 
$base = "lab2";        

// Aquí cambiamos $bab por $base para que coincida
$conexion = new mysqli($host, $user, $pass, $base); 

if ($conexion->connect_error){
    die("Error de conexion: " . $conexion->connect_error);
}

?>