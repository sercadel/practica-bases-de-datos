<?php

include "biblioteca.php";


// Formato fecha DATE AÑO-MES-DÍA - 2019-05-01
$patronFecha = '/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/';

$nombreTabla = "pedidos";
$clausulaWhere = "";

$errores = array();

if (isset($_POST["fecha-inicio"]) && !empty($_POST["fecha-inicio"])) {
    
    // Comprobar la fecha introducida
    if (preg_match($patronFecha, trim($_POST["fecha-inicio"]))) {
        $fechaInicio = $_POST["fecha-inicio"];
    } else {
        $errores += ["Fecha Inicio" => "La fecha introducida no es correcta"];
    }

    if (isset($_POST["fecha-fin"]) && !empty($_POST["fecha-fin"])) {
        // Comprobar la fecha introducida
        if (preg_match($patronFecha, trim($_POST["fecha-fin"]))) {
            $fechaFin = $_POST["fecha-fin"];
        } else {
            $errores += ["Fecha Fin" => "La fecha introducida no es correcta"];
        }
    } else {
        if (empty($_POST["fecha-fin"])) {
            // Si el campo fecha Fin esta vacío
            // se usa el mismo valor que Fecha Inicio
            $fechaFin = $fechaInicio;
        }
    }
    
    if (isset($fechaInicio) && isset($fechaFin)) {
        
        $clausulaWhere = "FechaPedido BETWEEN '$fechaInicio' AND '$fechaFin'";

        darBaja($nombreTabla, $clausulaWhere);
    }
} else {
    if (isset($_POST["fecha-inicio"]) && empty($_POST["fecha-inicio"])) {
        $errores += ["Fecha Inicio" => "El campo Fecha Inicio es requerido."];
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
    <div class="centrar">
        <p>Para borrar los pedidos de una fecha complete el campo Fecha Inicio.</p>
        <p>Si quiere borrar los pedidos en un rango de fechas complete los dos campos.</p>
        <p>El formato de fecha es AÑO-MES-DÍA. ej. 2019-01-01</p>
    </div>
    <div class="contenedor">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="campos">
                <fieldset>
                    <legend>Fecha</legend>
                    <label for="fecha-inicio">Fecha Inicio</label>
                    <input type="text" name="fecha-inicio" id="fecha-inicio" <?php
                    if (isset($nombre) && empty($errores["Fecha Inicio"])
                    ) {
                        echo "value=\"" . escape($_POST["fecha-inicio"]) . "\"";
                    } ?>
                    placeholder="AAA-MM-DD">
                    <?php
                    if (!empty($errores["Fecha Inicio"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                            . $errores["Fecha Inicio"]. "
                        </span>";
                    }
                    ?>

                    <label for="fecha-fin">Fecha Fin</label>
                    <input type="text" name="fecha-fin" id="fecha-fin" <?php
                    if (isset($nombre) && empty($errores["Fecha Fin"])
                    ) {
                        echo "value=\"" . escape($_POST["fecha-fin"]) . "\"";
                    } ?>
                    placeholder="AAA-MM-DD">
                    <?php
                    if (!empty($errores["Fecha Fin"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                            . $errores["Fecha Fin"]. "
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