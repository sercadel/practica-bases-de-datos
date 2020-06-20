<?php

include "biblioteca.php";

$hoy = sqlDate();
$ultimoID = "SELECT IdPedido FROM `pedidos` ORDER BY `pedidos`.`IdPedido` DESC LIMIT 1";
$resultadoId = mysqli_query(conectar("bd_libreria2"), $ultimoID);
while ($fila = mysqli_fetch_assoc($resultadoId)) {
    $idPedido = $fila["IdPedido"];
}

$consulta = "INSERT INTO `pedidos`
    (`IdPedido`, `FechaPedido`, `Descuento`, `IdCliente`, `IdLibreria`)
    VALUES  (" . ++$idPedido . ", \" . $hoy . \", 4, 1, 1),
            (" . ++$idPedido . ", \" . $hoy . \", 4, 2, 2),
            (" . ++$idPedido . ", \" . $hoy . \", 4, 3, 3)";

$resultado = mysqli_query(conectar("bd_libreria2"), $consulta);

if ($resultado) {
    $consulta = "INSERT INTO `detallespedidos`
        (`Cantidad`, `ISBN`, `IdPedido`)
        VALUES (10, \"1-2345-6789-0\", 48),
               (10, \"1-2345-6789-0\", 49),
               (10, \"1-2345-6789-0\", 50)";
    
    $resultado = mysqli_query(conectar("bd_libreria2"), $consulta);

    if ($resultado) {
        echo "Añadidas las entradas con éxito";
    } else {
        echo "No se han ingresado los Detalles de los Pedidos<br>";
    }
} else {
    echo "Error: " . $consulta . "<br>";
}

?>