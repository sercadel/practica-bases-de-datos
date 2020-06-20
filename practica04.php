<?php

include "biblioteca.php";

$consulta = "SELECT Titulo, Precio FROM libros ORDER BY Precio";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <?php crearTabla("bd_libreria2", $consulta); ?>
    </div>
</body>
</html>