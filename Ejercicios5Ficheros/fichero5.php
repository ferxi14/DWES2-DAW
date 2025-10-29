<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichero 5</title>
</head>

<body>
    <h2>Operacion Ficheros</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="fichero">Fichero(Path/nombre):</label>
        <input type="text" id="fichero" name="fichero" required>

        <br>

        <label for="operaciones">Operaciones:</label><br>
        <input type="radio" name="operacion" value="all"> Mostrar Fichero <br>
        <input type="radio" name="operacion" value="line"> Mostrar línea <input type="number" name="numlinea" min="1">
        del fichero<br>
        <input type="radio" name="operacion" value="lines"> Mostrar <input type="number" name="numlineas" min="1">
        primeras líneas <br>

        <br>
        <input type="submit" value="Enviar">
        <input type="reset" value="Borrar">

    </form>

    <?php
    // FUNCIONES 
    function mostrar_todo($archivo){
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            if ($linea == false)
                break;
            echo nl2br(htmlspecialchars($linea));
        }
    }

    function mostrar_linea($archivo, $num){
        $contador = 1;
        while (($linea = fgets($archivo)) !== false) {
            if ($contador == $num) {
                echo nl2br(htmlspecialchars($linea));
                return;
            }
            $contador++;
        }
        echo "<p style='color:red;'>Error: la línea $num no existe.</p>";
    }

    function mostrar_n_lineas($archivo, $num){
        for ($i = 0; $i < $num && !feof($archivo); $i++) {
            $linea = fgets($archivo);
            if ($linea == false)
                break;
            echo nl2br(htmlspecialchars($linea));
        }
    }
    // PROCESAMIENTO DEL FORMULARIO
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fichero = $_POST['fichero'];
        $ruta = "files/" . $fichero;
        $operacion = $_POST['operacion'];

        if (!file_exists($ruta)) {
            echo "<p>Error: El archivo '$fichero' no existe en la ruta especificada.</p>";
        }
        $archivo = fopen($ruta, "r");
        if (!$archivo) {
            echo "<p>Error: No se pudo abrir el archivo.</p>";
        }
        switch ($operacion) {
            case 'all':
                mostrar_todo($archivo);
                break;
            case 'line':
                $num = (int) ($_POST['numlinea'] ?? 0);
                mostrar_linea($archivo, $num);
                break;
            case 'lines':
                $num = (int) ($_POST['numlineas'] ?? 0);
                mostrar_n_lineas($archivo, $num);
                break;
            default:
                echo "No se ha seleccionado ninguna operación.";
        }
        fclose($archivo);
    }

    ?>
</body>

</html>