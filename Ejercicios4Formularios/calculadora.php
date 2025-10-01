<?php
function limpiar_campo($campoformulario) {
  $campoformulario = trim($campoformulario); //elimina espacios en blanco por izquierda/derecha
  $campoformulario = stripslashes($campoformulario); //elimina la barra de escape "\", utilizada para escapar caracteres
  $campoformulario = htmlspecialchars($campoformulario);  
  //convierte caracteres especiales a entidades HTML
  // Ciertos caracteres tienen significados especiales en HTML, y deben ser representados por entidades HTML 
  // si se desea preservar su significado
  //  &(ampersand) = &amp;
  //  " (double quote) = &quot;
  //  ' (single quote) = &#039;
  //  < menor que = &lt;

  return $campoformulario;
   
}

$operando1 = $operando2 = $operacion = $resultado = "";
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
echo "<h2>Resultado de la operación:</h2>";
echo $operando1 . " " . $operacion . " " . $operando2 . " = " . $resultado;
echo "<br>";
?>