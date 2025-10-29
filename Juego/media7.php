<?php
    include "media7fun.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $numCartas = limpiar_campo($_POST['numcartas']);
        $jugadores = obtenerJugadores();

        if ($numCartas < 1 || $numCartas > 10) {
            trigger_error("Número de cartas no válido", E_USER_ERROR);
        }

        $cartasTotales = [];

        repartirCartas($jugadores, $cartasTotales);
        mostrarResultados($jugadores);

        $ganadores = mostrarGanador($jugadores);
        darPremios($ganadores, $jugadores);
    }

?>