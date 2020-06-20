<?php

include "biblioteca.php";

if (isset($_POST["opcion1"])) {
    header("location: practica06.php");
}

if (isset($_POST["opcion2"])) {
    header("location: practica07.php");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>índice</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<h1 class="">¿Qué desea hacer?</h1>

    <?php include "menu.php"; ?>

    <div class="contenedor">
        <div class="columna centrar">
            <?php if (isset($_POST["consulta1"])) {
                echo "<h1 class=\"\">Clientes Ordenados por Apellidos</h1>";
                ordenarClientes("bd_libreria2");
            }

            if (isset($_POST["consulta2"])) {
                echo "<h1 class=\"\">Libros Ordenados por Precio de menor a mayor</h1>";
                ordenarPrecioLibros("bd_libreria2");
            }

            if (isset($_POST["consulta3"])) {
                echo "<h1 class=\"\">Autores Ordenados por Apellidos</h1>";
                ordenarAutoresApellido("bd_libreria2");
            }

            if (isset($_POST["consulta4"])) {
                echo "<h1 class=\"\">Librerías Ordenadas por el campo Ciudad</h1>";
                ordenarLibreriasCiudad("bd_libreria2");
            }

            if (isset($_POST["consulta5"])) {
                echo "<h1 class=\"\">Pedidos con los Detalles Asociados</h1>";
                ordenarPedidosDetalles("bd_libreria2");
            } ?>
        </div>
    </div>
</body>
</html>