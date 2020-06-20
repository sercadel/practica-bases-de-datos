<?php

include "biblioteca.php";


// Formato fecha DATE AÑO-MES-DÍA - 2019-05-01
$patronFecha = '/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/';

$nombreDb = "bd_libreria2";
$obtenerDatos = "IdPedido";
$columnaValor = "FechaPedido";
$tabla = "pedidos";
$tabla2 = "detallespedidos";

$errores = array();

if (isset($_POST["fecha"])) {
    // Comprobar la fecha introducida
    if (preg_match($patronFecha, trim($_POST["fecha"]))) {
        
        $valor = $_POST["fecha"];
        darBaja($nombreDb, $obtenerDatos, $valor, $columnaValor, $tabla, $tabla2);
    } else {
        $errores += ["Fecha" => "La fecha introducida no es correcta"];
    }
}

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
    <div class="contenedor-volver">
        <a class="volver" href="index.php">Volver al Menú Principal</a>
    </div>
<?php

?>
    <h1 class="">Dar de baja un pedido</h1>
    <div class="contenedor">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="campos">
                <fieldset>
                    <legend>Fecha</legend>
                    <label for="fecha">Fecha</label>
                    <input type="text" name="fecha" id="fecha" <?php
                    if (isset($nombre) && empty($errores["Fecha"])
                    ) {
                        echo "value=\"" . escape($_POST["fecha"]) . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["Fecha"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                            . $errores["Fecha"]. "
                        </span>";
                    }
                    ?>
                </fieldset>
            </div>
            <div class="enviar">
                <input type="reset" name="restablecer" value="Restablecer">
                <input type="submit" name="borrar" value="Borrar">
            </div>
        </form>
    </div>
</body>
</html>