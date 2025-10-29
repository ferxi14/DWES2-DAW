<?php
    include "media7fun.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $num_cartas = $_POST['numcartas'];

        $jugadores = obtenerJugadores();

        $cartasTotales = array();
        $contadorCartas = 0;

        if ($num_cartas >= 1 && $num_cartas <= 10) {
            echo "<h2>Resultado de la tirada</h2>";

            foreach($jugadores as $nombre => &$jugador) {
                echo "<table border='1'><tr><td>$nombre</td>";

                $jugador['cartas'] = array();

                for($i = 0; $i < $jugador['numcartas']; $i++) {
                    $num = rand(1,10);
                    // Si es 8,9,10 se asignan las letras J, Q, K
                    if ($num == 8)
                        $num = "J";
                    if ($num == 9)
                        $num = "Q";
                    if ($num == 10)
                        $num = "K";
                    // Palos de la baraja
                    $letra = rand(1,4);
                    if ($letra == 1)
                        $letra = "C";
                    if ($letra == 2)
                        $letra = "D";
                    if ($letra == 3)
                        $letra = "P";
                    if ($letra == 4)
                        $letra = "T";

                    $carta = (string)$num.$letra;

                    if(!in_array($carta, $cartasTotales)) {
                        array_push($cartasTotales, $carta);

                        //Cartas por jugador
						array_push($jugador['cartas'], $carta);
						imprimirCartas($num, $letra);

                        if ($num == "J" || $num == "Q" || $num == "K") {
                            $jugador['puntos'] += 0.5;
                        } else {
                            $jugador['puntos'] += $num;
                        }
                    } else {
                        $i--;
                    }
                }
                echo "</tr></table>";
				echo ("$nombre tiene un total de <b>{$jugador['puntos']}</b> puntos<br><br>");
            }
            var_dump($cartasTotales);
			var_dump($jugadores);

            $ganadores = mostrarGanador($jugadores);

			darPremios($ganadores, $jugadores);
        } else {
			trigger_error("Error en el numero de cartas por jugador", E_USER_ERROR);
		}
    }

?>