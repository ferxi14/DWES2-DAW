<?php
    function limpiar_campo($campoformulario) {
        $campoformulario = trim($campoformulario);
        $campoformulario = stripslashes($campoformulario);
        $campoformulario = htmlspecialchars($campoformulario);
        return $campoformulario;
    }

    $numero_decimal = $numero_binario = $mostrarBinario = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero_decimal = limpiar_campo($_POST["numero_decimal"]);

        if (is_numeric($numero_decimal) && $numero_decimal >= 0) {
            $numero_binario = decbin($numero_decimal);
            $mostrarBinario = true;
        }
        else {
            $resultado = "Por favor, ingresa un número decimal válido (mayor o igual a 0).";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Conversión</title>
</head>
<body>
    <h1>Conversor binario</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        Número Decimal: <input type="number" name="numero_decimal" value="<?php echo htmlspecialchars($numero_decimal); ?>" required><br><br>

        <?php
        if ($mostrarBinario): ?>
            <label for="binario">Número Binario:</label>
            <input type="text" id="binario" value="<?php echo htmlspecialchars($numero_binario); ?>" readonly><br><br>
        <?php endif; ?>

        <input type="submit" value="Enviar">
        <input type="reset" value="Borrar">
    </form>
</body>
</html>