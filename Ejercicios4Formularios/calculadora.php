<?php
function limpiar_campo($campoformulario) {
  $campoformulario = trim($campoformulario);
  $campoformulario = stripslashes($campoformulario);
  $campoformulario = htmlspecialchars($campoformulario);

  return $campoformulario;
   
}

function sumar($a, $b) {
  return $a + $b;
}

function restar($a, $b) {
  return $a - $b;
}

function multiplicar($a, $b) {
  return $a * $b;
}

function dividir($a, $b) {
  if ($b != 0) {
    return $a / $b;
  } else {
    return "Error: División por cero";
  }
}

$operando1 = $operando2 = $operacion = $resultado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $operando1 = limpiar_campo($_POST["operando1"]);
  $operando2 = limpiar_campo($_POST["operando2"]);
  $operacion = limpiar_campo($_POST["operacion"]);
  
  switch ($operacion) {
    case 'suma':
        $resultado = sumar($operando1, $operando2);
        $operacion = "+";
        break;
    case 'resta':
        $resultado = restar($operando1, $operando2);
        $operacion = "-";
        break;
    case 'multiplicacion':
        $resultado = multiplicar($operando1, $operando2);
        $operacion = "*";
        break;
    case 'division':
        $resultado = dividir($operando1, $operando2);
        $operacion = "/";
        break;
    default:
        $resultado = "Operación no válida";
        break;
  }
}
echo "<h2>Resultado de la operación:</h2>";
echo $operando1 . " " . $operacion . " " . $operando2 . " = " . $resultado;
echo "<br>";
?>