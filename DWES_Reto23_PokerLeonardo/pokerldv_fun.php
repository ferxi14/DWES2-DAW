<?php
/* Funciones programa */

// Funcion para limpiar campos de entrada
function limpiar_campo($campo){
    $campo = trim($campo);
    $campo = stripslashes($campo);
    $campo = htmlspecialchars($campo);
    return $campo;
}

// Funcion para obtener los jugadores del formulario
function obtener_jugadores(){
    $jugadores = [];

    for ($i = 1; $i <= 4; $i++) {
        $nombre = limpiar_campo($_POST['nombre' . $i]);
        $jugadores[] = [
            'nombre' => $nombre,
            'cartas' => [],
            'jugada' => ''
        ];
    }
    return $jugadores;
}

// Funcion para generar la baraja
function generarBaraja(){
    $valores = ['J', 'Q', 'K', '1'];
    $palos = ['C', 'D', 'P', 'T'];
    $baraja = [];

    foreach ($valores as $valor) {
        foreach ($palos as $palo) {
            $baraja[] = $valor . $palo . "1.PNG";
            $baraja[] = $valor . $palo . "2.PNG";
        }
    }

    shuffle($baraja);
    return $baraja;
}

function repartirCartas(&$baraja, &$jugadores){
    foreach ($jugadores as &$jugador) {
        $jugador['cartas'] = array_splice($baraja, 0, 4);
    }
    //var_dump($jugadores);
}

// Funcion que evalua las jugadas de cada jugador
function evaluarJugada($cartas){
    $valores = [];
    $jugada = 'Nada';

    foreach ($cartas as $carta) {
        $valores[] = substr($carta, 0, 1);
    }

    $conteo = array_count_values($valores);
    arsort($conteo);
    $numValores = count($conteo);
    var_dump($conteo);

    if (max($conteo) == 4)
        $jugada = 'Poker';

    if (max($conteo) == 3)
        $jugada = 'Trio';

    if (max($conteo) == 2 && $numValores == 2)
        $jugada = 'Doble Pareja';

    if (max($conteo) == 2)
        $jugada = 'Pareja';

    return $jugada;
}

// Funcion que asigna la jugada a cada jugador
function asignarJugada(&$jugadores){
    foreach ($jugadores as &$jugador) {
        $jugador['jugada'] = evaluarJugada($jugador['cartas']);
    }
}

// Funcion para el valor de la escala de jugadas
function valorJugada($jugada) {
    $valor = 0;

    switch ($jugada) {
        case "Poker":
            $valor = 4;
            break;
        case "Trio":
            $valor = 3;
            break;
        case "Doble pareja":
            $valor = 2;
            break;
        case "Pareja":
            $valor = 1;
            break;
        default:
            $valor = 0;
            break;
    }

    return $valor;
}

// Funcion de obtencion de ganadores comparando sus jugadas
function obtenerGanadores($jugadores) {
    $ganadores = [];
    $max = -1; 

    foreach ($jugadores as $j) {
        $valor = valorJugada($j['jugada']);

        if ($valor > $max) {
            $max = $valor;
            $ganadores = [$j];
        } elseif ($valor == $max) {
            $ganadores[] = $j;
        }
    }

    return $ganadores;
}

// Función de calculo de premios
function calcularPremio($jugadaGanadora, $bote, $numGanadores) {
    switch ($jugadaGanadora) {
        case "Poker":
            $porcentaje = 1;
            break;
        case "Trio":
            $porcentaje = 0.7;
            break;
        case "Doble Pareja":
            $porcentaje = 0.5;
            break;
        case "Pareja":
            $porcentaje = 0;
            break;
        default:
            $porcentaje = 0;
            break;
    }

    $premio = ($bote * $porcentaje) / max(1, $numGanadores);
    return $premio;
}

// Función de impresión
function mostrarResultado($jugadores, $ganadores, $jugadaGanadora, $premio) {
    echo "<h2>Resultados del Juego</h2><br>";

    foreach ($jugadores as $j) {
        echo "<h3>" . $j['nombre'] . "</h3>";

        foreach ($j['cartas'] as $carta) {
            echo "<img src='images/$carta' width='70' alt='$carta'>";
        }

        echo "<p><strong>Jugada: {$j['jugada']}</strong></p><hr>";
    }

    echo "<h3>Jugada ganadora: $jugadaGanadora</h3>";
    echo "<h4>Ganador/es: " . implode(', ', array_column($ganadores, 'nombre')) . "</h4>";
    echo "<h4>Premio por jugador: " . number_format($premio, 2) . " €</h4>";
}
?>