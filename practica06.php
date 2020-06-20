<?php

include "biblioteca.php";

// Array que almacena los errores en el formulario
$errores = array();

// Comprueba los datos enviados del formulario
// AUTOR
if (isset($_POST['enviar-autor']) || isset($_POST['enviar-libro'])) {
    // Nombre:
    if (empty($_POST["nombre"])) {
        $errores += ["Nombre" => "El campo  Nombre es requerido"];
    } else {
        $nombre = trim(escape($_POST["nombre"]));
        // Comprueba que sólo tenga letras
        if (!preg_match("/^[A-Za-z\s]+$/", $nombre)) {
            $errores += ["Nombre" => "Sólo se permiten letras en el campo Nombre"];
        }
    }

    // Apellidos:
    if (empty($_POST["apellidos"])) {
        $errores += ["Apellidos" => "El campo Apellidos es requerido"];
    } else {
        $apellidos = trim(escape($_POST["apellidos"]));
        // Comprueba que sólo tenga letras
        if (!preg_match("/^[A-Za-z\s]+$/", $apellidos)) {
            $errores += ["Apellidos" => "Sólo se permiten letras en el campo Apellidos"];
        }
    }

    // Nacionalidad:
    if (empty($_POST["nacionalidad"])) {
        $errores += ["Nacionalidad" => "El campo Nacionalidad es requerido"];
    } else {
        $nacionalidad = trim(escape($_POST["nacionalidad"]));
        // Comprueba que sólo tenga letras
        if (!preg_match("/^[A-ZÑña-z\s]+$/", $nacionalidad)) {
            $errores += ["Nacionalidad" => "Sólo se permiten letras en el campo Nacionalidad"];
        }
    }
}

// LIBRO
if (isset($_POST['enviar-libro'])) {
    // ISBN
    if (empty($_POST["isbn"])) {
        $errores += ["ISBN" => "El campo ISBN es requerido"];
    } else {
        $isbn = trim(escape($_POST["isbn"]));
        // Comprueba que tenga el formato ISBN-10
        if (!preg_match("/[0-9]{1}-[0-9]{4}-[0-9]{4}-[0-9]{1}/", $isbn)) {
            $errores += ["ISBN" => "El formato valido en el campo ISBN es X-XXXX-XXXX-X"];
        }
    }

    // Título:
    if (empty($_POST["titulo"])) {
        $errores += ["Título" => "El campo Título es requerido"];
    } else {
        $titulo = trim($_POST["titulo"]);
    }

    // Precio
    if (empty($_POST["precio"])) {
        $errores += ["Precio" => "El campo Precio es requerido"];
    } else {
        if (is_numeric($_POST["precio"])) {
            $precio = escape($_POST["precio"]);
        } else {
            $errores += ["Precio" => "Sólo se permiten números en el campo Precio"];
        }
    }

    // Existencias
    if (empty($_POST["existencias"])) {
        $errores += ["Existencias" => "El campo Existencias es requerido"];
    } else {
        if (is_numeric($_POST["existencias"])) {
            $existencias = trim(escape($_POST["existencias"]));
        } else {
            $errores += ["Existencias" => "Sólo se permiten números en el campo Existencias"];
        }
    }
}


// Array que almacena los errores en el formulario
$erroresDb = array();

if (isset($_POST['enviar-autor']) && empty($errores)) {
    // Comprobar si existe el autor en la base de datos
    $consulta = "SELECT Idautor FROM `autores`
                WHERE Nombre = \"" . $nombre . "\"
                AND Apellidos = \"" . $apellidos . "\"
                AND Nacionalidad = \"" . $nacionalidad . "\"";
    $existeAutor = mysqli_query(conectar("bd_libreria2"), $consulta);

    if (!mysqli_num_rows($existeAutor) >= 1) {
        // obtiene el último id de la tabla
        $idAutor = ultimoID("bd_libreria2", "Idautor", "autores");

        // añade el autor a la base de datos
        $consulta = "INSERT INTO `autores`
                    (`Idautor`, `Nombre`, `Apellidos`, `Nacionalidad`)
                        VALUES  (" . ++$idAutor . ", \"" . $nombre . "\",
                                \"" . $apellidos . "\", \"" . $nacionalidad . "\")";
        
        $resultado = mysqli_query(conectar("bd_libreria2"), $consulta);

        if ($resultado) {
            echo "El autor " . $nombre . " " . $apellidos . "
                se ha añadido con éxito a la base de datos<br>";
        } else {
            $erroresDb += ["Autor" => "No se pudo añadir el autor "
                        . $nombre . " " . $apellidos
                        . " a la base de datos."
            ];
        }
    } else {
        $erroresDb += ["Autor" => "Ya existe el autor  "
                        . $nombre . " " . $apellidos
                        . "  en la base de datos."
        ];
    }
}
if (isset($_POST['enviar-libro']) && empty($errores)) {
    // Comprobar si existe el autor en la base de datos
    $idAutor = obtenerIdAutor("bd_libreria2", $nombre, $apellidos, $nacionalidad);
    /* $consulta = "SELECT Idautor FROM `autores`
                WHERE Nombre = \"" . $nombre . "\"
                AND Apellidos = \"" . $apellidos . "\"
                AND Nacionalidad = \"" . $nacionalidad . "\"";
    $existeAutor = mysqli_query(conectar("bd_libreria2"), $consulta); */
    
    if ($idAutor) {
        // Comprobar si existe el libro en la base de datos
        $consulta = "SELECT ISBN FROM `libros`
                    WHERE ISBN = \"" . $isbn . "\"
                    AND Titulo = \"" . $titulo . "\"";
        
        $existeLibro = mysqli_query(conectar("bd_libreria2"), $consulta);

        if (!mysqli_num_rows($existeLibro) >= 1) {
            // Obtiene el Idautor del autor del libro
            $idAutor = obtenerIdAutor("bd_libreria2", $nombre, $apellidos, $nacionalidad);
            
            // añade el libro a la base de datos
            $consulta = "INSERT INTO `libros`
                        (`ISBN`, `Titulo`, `Precio`, `IdAutor`, `Existencias`)
                            VALUES  (\"" . $isbn . "\", \"" . $titulo . "\",
                                    " . $precio . ", " . $idAutor . ", " . $existencias . ")";
            
            $resultado = mysqli_query(conectar("bd_libreria2"), $consulta);
            if ($resultado) {
                echo "El libro " . $titulo
                    . " se ha añadido con éxito a la base de datos.";
            } else {
                $erroresDb += ["Libro" => "No se pudo añadir el Libro "
                        . $titulo
                        . " a la base de datos."
                ];
            }
        } else {
            $erroresDb += ["Libro" => "Ya existe el libro "
                        . $titulo . " con el ISBN " . $isbn
                        . " en la base de datos."
            ];
        }
    } else {
        $erroresDb += ["Autor" => "No existe el Autor "
                        . $nombre . " " . $apellidos
                        . " en la base de datos."
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta Autores y Libros</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor-volver">
        <a class="volver" href="index.php">Volver al Menú Principal</a>
    </div>
<?php

// Muestra los errores
if (!empty($erroresDb["Autor"])) {
    echo "<span class=\"error\">
        <img src=\"img/error.png\" alt=\"ERROR\">
        &nbsp;&nbsp;"
    . $erroresDb["Autor"]. "</span>";
}

if (!empty($erroresDb["Libro"])) {
    echo "<span class=\"error\">
        <img src=\"img/error.png\" alt=\"ERROR\">
        &nbsp;&nbsp;"
    . $erroresDb["Libro"]. "</span>";
}

?>
    <h1 class="">Añadir un Autor o un Libro a la base de datos</h1>
    <div class="centrar">
        <p>Para añadir un autor a la base de datos complete el apartado Autor.</p>
        <p>Para añadir un libro complete los apartados Autor y Libro.</p>
        <p>El autor debe existir en la base de datos antes de agregar un libro.</p>
    </div>
    <div class="contenedor">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="campos">
                <fieldset>
                    <legend>Autor</legend>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" <?php
                    if (isset($nombre) && empty($errores["Nombre"])
                    ) {
                        echo "value=\"" . escape($_POST["nombre"]) . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["Nombre"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                            . $errores["Nombre"]. "
                        </span>";
                    }
                    ?>
                    
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" <?php
                    if (empty($errores["Apellidos"]) && isset($apellidos)
                    ) {
                        echo "value=\"" . escape($_POST["apellidos"]) . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["Apellidos"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                        . $errores["Apellidos"]. "</span>";
                    }?>
                    
                    <label for="nacionalidad">Nacionalidad</label>
                    <input type="text" name="nacionalidad" id="nacionalidad" <?php
                    if (empty($errores["Nacionalidad"]) && isset($nacionalidad)) {
                        echo "value=\"" . escape($_POST["nacionalidad"]) . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["Nacionalidad"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                        . $errores["Nacionalidad"]. "</span>";
                    }
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Libro</legend>
                    
                    <label for="isbn">ISBN</label>
                    <input type="text" name="isbn" id="isbn" 
                    <?php
                    if (empty($errores["ISBN"]) && isset($isbn)) {
                        echo "value=\"" . escape($_POST["isbn"]) . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["ISBN"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                        . $errores["ISBN"]. "</span>";
                    } ?>
                    
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" 
                    <?php
                    if (empty($errores["Título"]) && isset($titulo)) {
                        echo "value=\"" . $_POST["titulo"] . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["Título"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                        . $errores["Título"]. "</span>";
                    }
                    ?>
                    
                    <label for="precio">Precio</label>
                    <input type="text" name="precio" id="precio" 
                    <?php
                    if (empty($errores["Precio"]) && isset($precio)) {
                        echo "value=\"" . escape($_POST["precio"]) . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["Precio"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                        . $errores["Precio"]. "</span>";
                    }
                    ?>
                    
                    <label for="existencias">Existencias</label>
                    <input type="text" name="existencias" id="existencias" 
                    <?php
                    if (empty($errores["Existencias"]) && isset($existencias)) {
                        echo "value=\"" . escape($_POST["existencias"]) . "\"";
                    } ?>
                    >
                    <?php
                    if (!empty($errores["Existencias"])) {
                        echo "<span class=\"error\">
                            <img src=\"img/error.png\" alt=\"ERROR\">
                            &nbsp;&nbsp;"
                        . $errores["Existencias"]. "</span>";
                    }
                    ?>
                </fieldset>
            </div>
            <div class="enviar">
                <input type="reset" name="restablecer" value="Restablecer">
                <input type="submit" name="enviar-autor" value="Añadir Autor">
                <input type="submit" name="enviar-libro" value="Añadir Libro">
            </div>
        </form>
    </div>
</body>
</html>