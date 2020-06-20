<?php

// Biblioteca de Funciones

// Definir constantes
DEFINE("PESETAS_EUROS", 166.386);

DEFINE('DB_HOST', "localhost");
DEFINE('DB_USER', "master");
DEFINE('DB_PASSWORD', "Curso1920!");
DEFINE('DB_NAME', "bd_libreria2");


// Obtiene la fecha actual con el formato en números de Año-Mes-Día
function sqlDate()
{
    // 2019-05-01 (Formato DATE de MySQL)
    $hoy = date("Y-m-d");
    return $hoy;
}
 
// Obtiene la fecha actual con el formato en números de Año-Mes-Día Hora:Minutos:Segundos
function sqlDatetime()
{
    // 2019-05-01 17:16:18 (Formato DATETIME de MySQL)
    $hoy = date("Y-m-d H:i:s");
    return $hoy;
}

/**
 * Función que indica si un número es par.
 *
 * @param integer $numero Número con el que operar
 *
 * @return true|false Devuelve TRUE si es par, FALSE si es impar,
 *                    Si no es un número muestra un mensaje
 */
function esPar($numero)
{
    if (is_numeric($numero)) {
        if ($numero % 2 == 0) {
            return true;
        } else {
            return false;
        }
    } else {
        echo "El valor debe ser numérico.";
    }
}


// Genera el alfabeto inglés en un array
$alfabeto = range('a', 'z');
$alfabetoMayusculas = range('A', 'Z');


/** 
 * Función que recibe como parámetros una cadena de texto
 * y un valor numérico de desplazamiento
 * en el que busca cada letra de la cadena en un array que contiene el alfabeto
 * y usa el desplazamiento para pasar a otra letra
 */
function codificar($frase, $valor)
{
    $resultado = array();
    global $alfabeto, $alfabetoMayusculas;
    for ($i=0; $i < strlen($frase); $i++) {
        // Si es un espacio lo sigue mostrando
        if ($frase[$i] == " ") {
            // Añade al array el valor obtenido
            array_push($resultado, $frase[$i]);
        } else {
            // Si la letra es minúscula
            if (in_array($frase[$i], $alfabeto, true)) {
                // Suma el desplazamiento al valor de la letra actual
                $letra = array_search($frase[$i], $alfabeto);
                // Añade al array el valor obtenido
                array_push(
                    $resultado,
                    $alfabeto[($letra + $valor) % count($alfabeto)]
                );
            } else {
                // Si la letra es mayúscula
                if (in_array($frase[$i], $alfabetoMayusculas, true)) {
                    // Suma el desplazamiento al valor de la letra actual
                    $letra = array_search($frase[$i], $alfabetoMayusculas);
                    // Añade al array el valor obtenido
                    array_push(
                        $resultado,
                        $alfabetoMayusculas[($letra + $valor) % count($alfabeto)]
                    );
                }
            }
        }
    }
    return $resultado;
}

/** 
 * Función que recibe como parámetros una cadena de texto
 * y un valor numérico de desplazamiento
 * en el que busca cada letra de la cadena en un array que contiene el alfabeto
 * y usa el desplazamiento para pasar a otra letra 
 */
function decodificar($frase, $valor)
{
    // Crea un array vacío
    $resultado = array();

    global $alfabeto, $alfabetoMayusculas;

    for ($i=0; $i < strlen($frase); $i++) {
        // Si es un espacio lo sigue mostrando
        if ($frase[$i] == " ") {
            // Añade al array el valor obtenido
            array_push($resultado, $frase[$i]);
        } else {
            // Si la letra es minúscula
            if (in_array($frase[$i], $alfabeto, true)) {
                // Resta el desplazamiento al valor de la letra actual
                $letra = array_search($frase[$i], $alfabeto);

                // Mientras el resultado sea menor a cero
                while ($letra - $valor < 0) {
                    // Suma el número de letras del abecedario
                    // para volver recorrer el array
                     $valor += count($alfabeto);
                }
                // Añade al array el valor obtenido
                array_push(
                    $resultado,
                    $alfabeto[(($letra - $valor) % count($alfabeto))]
                );
            } else {
                // Si la letra es mayúscula
                if (in_array($frase[$i], $alfabetoMayusculas, true)) {
                    // Resta el desplazamiento al valor de la letra actual
                    $letra = array_search($frase[$i], $alfabetoMayusculas);

 
                    // Mientras el resultado sea menor a cero
                    while ($letra - $valor < 0) {
                        // Suma el número de letras del abecedario
                        // para volver recorrer el array
                        $valor += count($alfabeto);
                    }
                    // Añade al array el valor obtenido
                    array_push(
                        $resultado,
                        $alfabetoMayusculas[(($letra - $valor) % count($alfabeto))]
                    );
                }
            }
        }
    }
    return $resultado;
}


// Convierte caracteres especiales en entidades HTML
function escape($cadena)
{
    return htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8');
}


/**
 * 
 */

function pesetasAEuros($valor)
{
    return number_format($valor / PESETAS_EUROS, 2, ',', '.');
}

function eurosAPesetas($valor)
{
    return number_format($valor * PESETAS_EUROS, 2, ',', '.');
}

/**
 * 
 */

// función abrir fichero
function verFichero($valor, $directorio)
{
    $rutaFichero = $directorio . '/' . $valor;
    $datosFichero = fopen($rutaFichero, "r");
    $tamanno = filesize($rutaFichero);
    $texto = fread($datosFichero, $tamanno);
    return $texto;
}

// Función listar los elementos de un directorio
function listarDirectorio($directorio)
{
    // Obtiene un listado de los elementos dentro del directorio
    $arrayDirectorios = scandir($directorio);

    // Elimina del resultado los directorios "." y ".."
    unset($arrayDirectorios[array_search('.', $arrayDirectorios, true)]);
    unset($arrayDirectorios[array_search('..', $arrayDirectorios, true)]);

    // Si el directorio esta vacío no muestra nada
    if (count($arrayDirectorios) < 1) {
        return;
    }

    /*
    Crea un array donde se van a guardar
    los ficheros y sus datos (Nombre, Extensión, Tamaño en Bytes)
    */
    $listadoFicheros = array();

    foreach ($arrayDirectorios as $elemento) {
        if (is_file($directorio . '/' . $elemento)) {
            
            $partesRuta = pathinfo($directorio . '/' . $elemento);
            // Crea un array con los datos del fichero
            $datosFichero = array(
                'Nombre' => $partesRuta['filename'],
                'Extensión'  => $partesRuta['extension'],
                'Tamaño'  => filesize($directorio . '/' . $elemento)
            );
            // Añade el array $datosFichero al array $listadoFicheros
            array_push($listadoFicheros, $datosFichero);
        }
        /* No se aplica
        // Si es un directorio llama a la función para búsqueda recursiva
        if (is_dir($directorio . '/' . $elemento)) {
            listarDirectorio($directorio . '/' . $elemento);
        }
        */
    }
    return $listadoFicheros;
}


/**
 * Función obtiene los ficheros de un directorio.
 *
 * @param string $dir Directorio en el que busca los ficheros
 *
 * @return array
 */
function obtenerFicheros($dir)
{
    $raiz = scandir($dir);
    foreach ($raiz as $valor) {
        if ($valor === '.' || $valor === '..') {
            continue;
        }
        if (is_file("$dir/$valor")) {
            $resultado[]="$dir/$valor";
            continue;
        }
        foreach (obtenerFicheros("$dir/$valor") as $valor) {
            $resultado[]=$valor;
        }
    }
    return $resultado;
}


/**
 * Función conexión a Base de datos dada por parámetro.
 *
 * @param string $nombreDb Nombre de la base de datos a conectar
 *
 * @return void
 */
function conectar($nombreDb)
{
    $enlace = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, $nombreDb);
    // Comprueba la conexión
    if (mysqli_connect_errno()) {
        printf(
            "Fallo al conectarse a la base de datos: %s\n", mysqli_connect_error()
        );
        exit();
    } else {
        /* mysqli_character_set_name($enlace);
        // Establece el conjunto de caracteres a utf8
        if (!mysqli_set_charset($enlace, "utf8")) {
            printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($enlace));
            exit();
        } */
        return $enlace;
    }
    mysqli_close($enlace);
}

/**
 * Crea una tabla con los resultados obtenidos.
 *
 * @param string $nombreDb Nombre de la base de datos a conectar
 * @param string $consulta Consulta a la base de datos
 * @param int    $dto      Descuento a aplicar en tanto por ciento, por defecto 0
 * 
 * @return string Devuelve una tabla con los datos obtenidos
 *                o un mensaje de error en caso de introducirse
 *                un descuento con valor menor de 0 o mayor a 100
 */
function crearTabla($nombreDb, $consulta, $dto = 0)
{
    if ($dto < 0 || $dto > 100) {
        echo "El argumento descuento unicamente admite valores entre 0 y 100";
    } else {
        $resultado = mysqli_query(conectar($nombreDb), $consulta);
        
        if ($resultado) {
            echo "<div class=\"tabla\">
                    <div class=\"tabla-encabezado\">
                        <div class=\"tabla-fila\">
                            <div class=\"tabla-titulo izquierda\">Título</div>
                            <div class=\"tabla-titulo izquierda\">Precio</div>
                        </div>
                    </div>
                    <div class=\"tabla-cuerpo\">";
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo utf8_encode(
                    sprintf(
                        "<div class=\"tabla-fila\">
                            <div class=\"tabla-celda izquierda\">%s</div>
                            <div class=\"tabla-celda derecha\">%.2f &euro;</div>
                        </div>",
                        $fila["Titulo"],
                        $fila["Precio"] * (1 - ($dto/100))
                    )
                );
            }
            echo "</div></div>";
            mysqli_free_result($resultado);
        } else {
            echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
        }
    }
}


/**
 * Muestra el último valor ID numérico de una tabla.
 *
 * @param string $nombreDb Nombre de la base de datos a conectar
 * @param string $columna  Columna en la que hacer la búsqueda
 * @param string $tabla    Tabla a la que pertenece la columna
 * 
 * @return int Devuelve el último ID de una tabla
 */
function ultimoID($nombreDb, $columna, $tabla)
{
    $consulta = "SELECT $columna FROM $tabla ORDER BY $columna DESC LIMIT 1";
    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        if (mysqli_num_rows($resultado) >= 1) {
            while ($fila = mysqli_fetch_row($resultado)) {
                $ultimoID = $fila[0];
            }
            return $ultimoID;
        } else {
            echo "<h2 class=\"rojo\">No se ha podido obtener el ultimo valor Id</h2>";
        }
        mysqli_free_result($resultado);
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
}
}


function obtenerIdAutor($nombreDb, $nombre, $apellidos, $nacionalidad)
{
    // "SELECT `Idautor` FROM `autores` WHERE `Nombre` = \"Perico\" AND `Apellidos` = \"Los Palotes\" AND `Nacionalidad` = \"Mexicano\"";
    $consulta = "SELECT `Idautor` FROM `autores` WHERE `Nombre` = \"$nombre\" AND `Apellidos` = \"$apellidos\" AND `Nacionalidad` = \"$nacionalidad\"";
    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        if (mysqli_num_rows($resultado) >= 1) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $idAutor = $fila["Idautor"];
                return $idAutor;
            }
        } else {
            echo "<h2 class=\"rojo\">No se ha podido obtener el Idautor</h2>";
        }
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
    }
}


// Consultas

function ordenarClientes($nombreDb)
{
    $consulta = "SELECT Nombre, Apellidos FROM clientes ORDER BY Apellidos";
    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        echo "<div class=\"tabla\">
                <div class=\"tabla-encabezado\">
                    <div class=\"tabla-fila\">
                        <div class=\"tabla-titulo izquierda\">Nombre</div>
                        <div class=\"tabla-titulo izquierda\">Apellidos</div>
                    </div>
                </div>
                <div class=\"tabla-cuerpo\">";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo utf8_encode(
                sprintf(
                    "<div class=\"tabla-fila\">
                        <div class=\"tabla-celda izquierda\">%s</div>
                        <div class=\"tabla-celda izquierda\">%s</div>
                    </div>",
                    $fila["Nombre"],
                    $fila["Apellidos"]
                )
            );
        }
        echo "</div></div>";
        mysqli_free_result($resultado);
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
    }
}


function ordenarPrecioLibros($nombreDb)
{
    $consulta = "SELECT * FROM libros ORDER BY Precio";
    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        echo "<div class=\"tabla\">
            <div class=\"tabla-encabezado\">
                <div class=\"tabla-fila\">
                    <div class=\"tabla-titulo izquierda\">ISBN</div>
                    <div class=\"tabla-titulo izquierda\">Título</div>
                    <div class=\"tabla-titulo izquierda\">Precio</div>
                    <div class=\"tabla-titulo izquierda\">Existencias</div>
                </div>
            </div>
            <div class=\"tabla-cuerpo\">";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo utf8_encode(
                sprintf(
                    "<div class=\"tabla-fila\">
                        <div class=\"tabla-celda izquierda\">%s</div>
                        <div class=\"tabla-celda izquierda\">%s</div>
                        <div class=\"tabla-celda derecha\">%.2f &euro;</div>
                        <div class=\"tabla-celda derecha\">%s</div>
                    </div>",
                    $fila["ISBN"],
                    $fila["Titulo"],
                    $fila["Precio"],
                    $fila["Existencias"]
                )
            );
        }
        echo "</div></div>";
        mysqli_free_result($resultado);
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
    }
}


function ordenarAutoresApellido($nombreDb)
{
    $consulta = "SELECT Nombre, Apellidos FROM autores ORDER BY Apellidos";
    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        echo "<div class=\"tabla\">
                <div class=\"tabla-encabezado\">
                    <div class=\"tabla-fila\">
                        <div class=\"tabla-titulo izquierda\">Nombre</div>
                        <div class=\"tabla-titulo izquierda\">Apellidos</div>
                    </div>
                </div>
                <div class=\"tabla-cuerpo\">";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo utf8_encode(
                sprintf(
                    "<div class=\"tabla-fila\">
                        <div class=\"tabla-celda izquierda\">%s</div>
                        <div class=\"tabla-celda izquierda\">%s</div>
                    </div>",
                    $fila["Nombre"],
                    $fila["Apellidos"]
                )
            );
        }
        echo "</div></div>";
        mysqli_free_result($resultado);
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
    }
}


function ordenarLibreriasCiudad($nombreDb)
{
    $consulta = "SELECT Nombre, Direccion, Ciudad FROM librerias ORDER BY Ciudad";
    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        echo "<div class=\"tabla\">
                <div class=\"tabla-encabezado\">
                    <div class=\"tabla-fila\">
                        <div class=\"tabla-titulo izquierda\">Nombre</div>
                        <div class=\"tabla-titulo izquierda\">Direccion</div>
                        <div class=\"tabla-titulo izquierda\">Ciudad</div>
                    </div>
                </div>
                <div class=\"tabla-cuerpo\">";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo utf8_encode(
                sprintf(
                    "<div class=\"tabla-fila\">
                        <div class=\"tabla-celda izquierda\">%s</div>
                        <div class=\"tabla-celda izquierda\">%s</div>
                        <div class=\"tabla-celda izquierda\">%s</div>
                    </div>",
                    $fila["Nombre"],
                    $fila["Direccion"],
                    $fila["Ciudad"]
                )
            );
        }
        echo "</div></div>";
        mysqli_free_result($resultado);
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
    }
}



function ordenarPedidosDetalles($nombreDb)
{
    $consulta = "SELECT * FROM `pedidos`, `detallespedidos` "
                . "WHERE `pedidos`.`IdPedido` = `detallespedidos`.`IdPedido` "
                . "ORDER BY `pedidos`.`IdPedido` ASC";

    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        echo "<div class=\"tabla\">
            <div class=\"tabla-encabezado\">
                <div class=\"tabla-fila\">
                    <div class=\"tabla-titulo izquierda\">ID Pedido</div>
                    <div class=\"tabla-titulo izquierda\">Fecha Pedido</div>
                    <div class=\"tabla-titulo izquierda\">Descuento</div>
                    <div class=\"tabla-titulo izquierda\">ID Cliente</div>
                    <div class=\"tabla-titulo izquierda\">ID Libreria</div>
                    <div class=\"tabla-titulo izquierda\">Cantidad</div>
                    <div class=\"tabla-titulo izquierda\">ISBN</div>
                </div>
            </div>
            <div class=\"tabla-cuerpo\">";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo utf8_encode(
                sprintf(
                    "<div class=\"tabla-fila\">
                        <div class=\"tabla-celda derecha\">%s</div>
                        <div class=\"tabla-celda derecha\">%s</div>
                        <div class=\"tabla-celda derecha\">%d &#37;</div>
                        <div class=\"tabla-celda derecha\">%s</div>
                        <div class=\"tabla-celda derecha\">%s</div>
                        <div class=\"tabla-celda derecha\">%s</div>
                        <div class=\"tabla-celda izquierda\">%s</div>
                    </div>",
                    $fila["IdPedido"],
                    $fila["FechaPedido"],
                    $fila["Descuento"],
                    $fila["IdCliente"],
                    $fila["IdLibreria"],
                    $fila["Cantidad"],
                    $fila["ISBN"]
                )
            );
        }
        echo "</div></div>";
        mysqli_free_result($resultado);
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
    }
}


// Obtener id pedidos

function obtenerIdPedido($nombreDb, $fecha)
{
    $consulta = "SELECT DISTINCT `IdPedido` FROM `pedidos` WHERE `FechaPedido` = \"" . $fecha . "\"";
    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        while ($fila = mysqli_fetch_row($resultado)) {
            echo "No se ha podido obtener el IdPedido";
        }
        if (mysqli_num_rows($resultado) >= 1) {
            while ($fila = mysqli_fetch_row($resultado)) {
                $ultimoID = $fila[0];
            }
            return $ultimoID;
        } else {
            echo "No se ha podido obtener el ultimo valor IdPedido";
        }
        mysqli_free_result($resultado);
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado</h2>";
    }
}


// Mejoras

/**
 * 
 * 
 */
function consultaSelect($nombreTabla, $clausulaWhere = '')
{
    // Comprueba si esta declarada la cláusula WHERE
    $parametrosWhere = '';
    if (!empty($clausulaWhere)) {
        // Comprueba si contiene la palabra WHERE
        if (substr(strtoupper(trim($clausulaWhere)), 0, 5) != "WHERE") {
            // Si no la tiene la añade
            $parametrosWhere = " WHERE " . $clausulaWhere;
        } else {
            $parametrosWhere = " " . trim($clausulaWhere);
        }
    }

     // Crea la consulta con los datos proporcionados
    $consulta = "SELECT `IdPedido` FROM " . $nombreTabla . $parametrosWhere;

    // Devuelve la consulta
    return $consulta;
}



/**
 * 
 * 
 */
function consultaInsert($nombreTabla, $datosFormulario)
{
    // Obtiene los indices del array como nombre de los campos
    $campos = array_keys($datosFormulario);

    // Crea la consulta con los datos proporcionados
    $consulta = "INSERT INTO " . $nombreTabla
                . "(`" . implode('`,`', $campos) . "`)"
                . "VALUES('" . implode("','", $datosFormulario) . "')";

    // Devuelve la consulta
    return $consulta;
}


/**
 * 
 * 
 */
function consultaDelete($nombreTabla, $clausulaWhere = '')
{
    // Comprueba si esta declarada la cláusula WHERE
    $parametrosWhere = '';
    if (!empty($clausulaWhere)) {
        // Comprueba si contiene la palabra WHERE
        if (substr(strtoupper(trim($clausulaWhere)), 0, 5) != "WHERE") {
            // Si no la tiene la añade
            $parametrosWhere = " WHERE " . $clausulaWhere;
        } else {
            $parametrosWhere = " " . trim($clausulaWhere);
        }
    }

     // Crea la consulta con los datos proporcionados
    $consulta = "DELETE FROM " . $nombreTabla . $parametrosWhere;

    // Devuelve la consulta
    return $consulta;
}


/**
 * 
 * 
 */
function consultaUpdate($nombreTabla, $datosFormulario, $clausulaWhere = '')
{
    // Comprueba si esta declarada la cláusula WHERE
    $parametrosWhere = '';
    if (!empty($clausulaWhere)) {
        // Comprueba si contiene la palabra WHERE
        if (substr(strtoupper(trim($clausulaWhere)), 0, 5) != "WHERE") {
            // Si no la tiene la añade
            $parametrosWhere = " WHERE " . $clausulaWhere;
        } else {
            $parametrosWhere = " " . trim($clausulaWhere);
        }
    }

    // Crea la estructura de la consulta UPDATE
    $consulta = "UPDATE " . $nombreTabla . " SET ";

    // Crea el conjunto de datos columna = valor de cada entrada
    $setDatos = array();
    foreach ($datosFormulario as $columna => $valor) {
         $setDatos[] = "`" . $columna . "` = '" . $valor . "'";
    }

    // Añade el conjunto de datos a la consulta UPDATE
    $consulta .= implode(', ', $setDatos);

    // Añade la cláusula WHERE a la consulta UPDATE
    $consulta .= $parametrosWhere;

    // Devuelve la consulta
    return $consulta;
}



function ejecutarConsulta($consulta)
{
    $nombreDb = DB_NAME;
    $resultado = mysqli_query(conectar($nombreDb), $consulta);

    if ($resultado) {
        // echo "Consulta " . $consulta . " realizada con éxito.<br>";
        return $resultado;

    } else {
        echo "<h2 class=\"rojo\">Error: No se ha podido realizar la consulta</h2>";
        echo "Consulta: " . $consulta . "<br>";
    }
}


// Dar de baja
function darBaja($nombreTabla, $clausulaWhere)
{   
    $consulta = consultaSelect($nombreTabla, $clausulaWhere);
    $resultado = ejecutarConsulta($consulta);
        
    if ($resultado) {
        $resultadoSelect = array();
        
        if (mysqli_num_rows($resultado) >= 1) {
            while ($fila = mysqli_fetch_row($resultado)) {
                array_push($resultadoSelect, $fila[0]);
            } 
            
            foreach ($resultadoSelect as $key => $valorId) {
                $clausulaWhere = "WHERE IdPedido = '$valorId'";

                // Borrar de la tabla detallespedidos
                $nombreTabla = "detallespedidos";
                $consulta = consultaDelete($nombreTabla, $clausulaWhere);
                
                $resultado = ejecutarConsulta($consulta);
        
                if ($resultado) {
                    echo "Detalles del pedido con ID "
                        . $valorId . " Eliminado con éxito.<br>";
                }

                // Borrar de la tabla pedidos
                $nombreTabla = "pedidos";
                $consulta = consultaDelete($nombreTabla, $clausulaWhere);
                $resultado = ejecutarConsulta($consulta);

                if ($resultado) {
                    echo "Pedido con ID "
                        . $valorId . " Eliminado con éxito.<br>";
                }
                echo "<br><br>";
            }
        } else {
            echo "<h2 class=\"rojo\">No se ha podido realizar la consulta.</h2>";
            echo "Consulta - " . $consulta . "<br>";
        }
    } else {
        echo "<h2 class=\"rojo\">No se ha obtenido ningún resultado.</h2>";
    }
}


?>