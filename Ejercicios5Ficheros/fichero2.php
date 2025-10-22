<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficheros</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>
        <label for="apellido1">Apellido 1:</label>
        <input type="text" name="apellido1" required><br>
        <label for="apellido2">Apellido 2:</label>
        <input type="text" name="apellido2" required><br>
        <label for="fecha_nac">Fecha de nacimiento</label>
        <input type="date" name="fecha_nac" required><br>
        <label for="localidad">Localidad:</label>
        <input type="text" name="localidad" required><br>
        <input type="submit" value="Enviar">
        <input type="reset" value="Borrar">
    </form>
</body>
</html>

<?php

function limpiar_campo($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

// Función para escribir un campo carácter por carácter en el archivo
function escribir_campo($archivo, $campo) {
    for ($i = 0; $i < strlen($campo); $i++){
        fwrite($archivo, $campo[$i]);
    }
    fwrite($archivo, "##");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = limpiar_campo($_POST['nombre']);
    $apellido1 = limpiar_campo($_POST['apellido1']);
    $apellido2 = limpiar_campo($_POST['apellido2']);
    $fecha_nac = limpiar_campo($_POST['fecha_nac']);
    $localidad = limpiar_campo($_POST['localidad']);

    $archivo = fopen("files/alumnos2.txt", "a");

    if ($archivo){
        escribir_campo($archivo, $_POST['nombre']);
        escribir_campo($archivo, $_POST['apellido1']);
        escribir_campo($archivo, $_POST['apellido2']);
        escribir_campo($archivo, $_POST['fecha_nac']);
        escribir_campo($archivo, $_POST['localidad']);

        fwrite($archivo, "\n");
        fclose($archivo);
        echo "Datos guardados correctamente.";
    }
    else{
        echo "No se pudo abrir el archivo";
    }
}
?>