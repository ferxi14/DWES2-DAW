<HTML>
<HEAD> <TITLE> Ejercicios FORMULARIOS  </TITLE>
</HEAD>
<BODY>
<?php
    $operando1 = $operando2 = $operacion = $resultado = "";

    function limpiar_campo($campoformulario) {
        $campoformulario = trim($campoformulario);
        $campoformulario = stripslashes($campoformulario);
        $campoformulario = htmlspecialchars($campoformulario);
        return $campoformulario;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $operando1 = limpiar_campo($_POST["operando1"]);
        $operando2 = limpiar_campo($_POST["operando2"]);
        $operacion = limpiar_campo($_POST["operacion"]);
  
        switch ($operacion) {
            case 'suma':
                $resultado = $operando1 + $operando2;
                $operacion = "+";
                break;
            case 'resta':
                $resultado = $operando1 - $operando2;
                $operacion = "-";
                break;
            case 'multiplicacion':
                $resultado = $operando1 * $operando2;
                $operacion = "*";
                break;
            case 'division':
                if ($operando2 != 0) {
                    $resultado = $operando1 / $operando2;
                    $operacion = "/";
                } else {
                    $resultado = "Error: División por cero";
                }
                break;
            default:
                $resultado = "Operación no válida";
                break;
        }
    }
?>

<H1> CALCULADORA </h1>
<form name='calculadora' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>

Operando 1:
<input type='text' name='operando1' value=''><br><br>
Operando 2:
<input type='text' name='operando2' value=''><br><br>
Selecciona operacion:
<br>
<input type='radio' name='operacion' value='suma'>Suma</br>
<input type='radio' checked name='operacion' value='resta'>Resta</br>
<input type='radio' name='operacion' value='multiplicacion'>Multiplicación</br>
<input type='radio' name='operacion' value='division'>División</br>

<input type="submit" value="enviar">

<input type="reset" value="borrar">

<?php
    echo "<h2>Resultado de la operación:</h2>";
    echo $operando1 . " " . $operacion . " " . $operando2 . " = " . $resultado;
    echo "<br>";
?>
</FORM>
</BODY>
</HTML>