<?php
function limpiar_campo($input) {

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);  

    return $input;
}

function obtenerJugadores() {
    $jugadores = array();
	$numCartas = $_POST['numcartas'];

    foreach (['nombre1', 'nombre2', 'nombre3', 'nombre4'] as $jugador) {
        if(!empty($_POST[$jugador])){
            
            $jugadores[limpiar_campo($_POST[$jugador])] = array(
                                        'numcartas' => $numCartas,
                                        'cartas' => array(),
                                        'puntos' => 0
                                    );
        }
    }

	if (count($jugadores) < 2 )
		trigger_error("Debe haber minimo 2 jugadores", E_USER_ERROR);

	return $jugadores;
}

function mostrarGanador($jugadores) {
	$puntosMax = 0;
	$ganadores = array();

	//Recorremos el array y encontramos la puntuación máxima
	foreach ($jugadores as $nombre => $jugador) {
		if($jugador['puntos'] <= 7.5) {
			if ($jugador['puntos'] > $puntosMax)
				$puntosMax = $jugador['puntos'];
		}
	}
	
	//Encontrar todos los jugadores con la puntuación máxima
	foreach ($jugadores as $nombre => $jugador) {
		if ($jugador['puntos'] == $puntosMax)
			$ganadores[] = $nombre;
	}

	// Mostrar el resultado según haya empate o no
	if (count($ganadores) > 1) {
		echo "<h2>Hay un empate con $puntosMax puntos entre los siguientes jugadores:</h2>";
		foreach ($ganadores as $ganador) {
			echo "$ganador<br>";
		}
	} else if (count($ganadores) == 1) {
		echo "<h2>¡El ganador es {$ganadores[0]} con $puntosMax puntos!</h2>";
	} else {
		echo "<h2>NO HAY GANADORES</h2>";
	}

	return $ganadores;
}

function imprimirCartas($num, $letra) {
	echo "<td><img src='images/".$num.$letra.".PNG'></td>";
}

function darPremios($ganadores, $jugadores) {
    $apuesta = floatval(limpiar_campo($_POST['apuesta']));
    $bote = $apuesta;
    $porcentajeJugadores = 0;
    $porcentajeBanca = 0;

    // Comprobar si alguien consiguió exactamente 7.5 puntos
    $haySieteYMedia = false;
    $encontrado = false;
    
    foreach ($jugadores as $jugador) {
        if (!$encontrado && $jugador['puntos'] == 7.5) {
            $haySieteYMedia = true;
            $encontrado = true;
        }
    }

    // Asignar porcentajes según haya 7.5 o no
    if ($haySieteYMedia) {
        $porcentajeJugadores = 0.80;
        $porcentajeBanca = 0.20;
    } else {
        $porcentajeJugadores = 0.50;
        $porcentajeBanca = 0.50;
    }

    // Calcular las cantidades
    $totalJugadores = $bote * $porcentajeJugadores;
    $banca = $bote * $porcentajeBanca;
    $premioPorJugador = 0;

    if (count($ganadores) > 0) {
        $premioPorJugador = $totalJugadores / count($ganadores);
    }

    echo "<h3>Reparto de premios</h3>";
    echo "Importe total apostado: <b>$bote €</b><br>";

    if (count($ganadores) > 0) {
        if (count($ganadores) > 1) {
            echo "<p>Empate entre jugadores, cada uno recibe <b>$premioPorJugador €</b></p>";
        } else {
            echo "<p>El ganador {$ganadores[0]} recibe <b>$premioPorJugador €</b></p>";
        }
    } else {
        echo "<p>No hay ganadores. La banca se queda con todo el bote.</p>";
        $banca = $bote;
    }

    // Guardar datos en el fichero
    $fechaActual = date("dmYHis"); 
    $nombreFichero = "apuestas_" . $fechaActual . ".txt";
    $contenidoFichero = "";
    $importeGanadores = 0;

    foreach ($ganadores as $ganador) {
        $puntos = $jugadores[$ganador]['puntos'];
        $iniciales = obtenerIniciales($ganador);
        $importeGanadores += $premioPorJugador;
        $contenidoFichero .= "$iniciales#$puntos#$premioPorJugador\n";
    }

    $numGanadores = count($ganadores);
    $contenidoFichero .= "TOTAL PREMIOS#$numGanadores#$importeGanadores\n";

    // Escribir en el fichero
    file_put_contents($nombreFichero, $contenidoFichero);
}

function obtenerIniciales($nombre) {
    $palabras = explode(" ", trim($nombre));
    $iniciales = "";
    foreach ($palabras as $palabra) {
        $iniciales .= strtoupper(substr($palabra, 0, 2));
    }
    return $iniciales;
}
?>