<?php

DEFINE('DB_HOST', "localhost");
DEFINE('DB_USER', "master");
DEFINE('DB_PASSWORD', "Curso1920!");
DEFINE('DB_NAME', "bd_libreria2");


$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Comprueba la conexión
if (mysqli_connect_errno()) {
    echo "Fallo al conectarse a la base de datos: " . mysqli_connect_error();
}

?>