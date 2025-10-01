<?php
    function limpiar_campo($campoformulario) {
        $campoformulario = trim($campoformulario);
        $campoformulario = stripslashes($campoformulario);
        $campoformulario = htmlspecialchars($campoformulario);
        return $campoformulario;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero_decimal = limpiar_campo($_POST["numero_decimal"]);
        $numero_binario = decbin($numero_decimal);
    }
?>