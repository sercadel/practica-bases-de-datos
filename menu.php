<?php

// Menú con un formulario de las opciones de consultas

echo
"<div class=\"opciones\">
    <form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">
        <div class=\"menu\">
            <input type=\"submit\" name=\"opcion1\" value=\"Dar de alta Autores y Libros\">
            <input type=\"submit\" name=\"opcion2\" value=\"Dar de baja Pedidos\">
            <input type=\"submit\" name=\"consulta1\" value=\"Clientes Ordenados por Apellidos\">
            <input type=\"submit\" name=\"consulta2\" value=\"Precio Libros de menor a mayor\">
            <input type=\"submit\" name=\"consulta3\" value=\"Autores Ordenados por Apellidos\">
            <input type=\"submit\" name=\"consulta4\" value=\"Librerías Ordenadas por Ciudad\">
            <input type=\"submit\" name=\"consulta5\" value=\"Pedidos con Detalles Asociados\">
        </div>
    </form>
</div>";

?>