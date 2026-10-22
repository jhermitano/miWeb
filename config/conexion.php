<?php
// config/conexion.php

$db_host = 'jvdeveloperpasco.com';
$db_user = 'jvdevelo_Jeysell';
$db_pass = 'Jeysell28'; // Modifica si tienes contraseña en MySQL
$db_name = 'jvdevelo_jvdeveloper_db';

try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>