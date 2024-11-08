<?php
// parametros para conectar con la base de datos
$host = "localhost:3306";
$user = "root";
$password = "root";
$bd = "social_network";

// Conectar a la base de datos
$connect = mysqli_connect($host, $user, $password);

if (!$connect) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Seleccionar la base de datos
if (!mysqli_select_db($connect, $bd)) {
    die("Error seleccionando la base de datos: " . mysqli_error($connect));
}

// Verificar si la sesión ya está iniciada y evitar múltiples inicios de sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>