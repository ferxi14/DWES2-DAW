<?php
    include 'pokerldv_fun.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jugadores = obtener_jugadores();
        $bote = limpiar_campo($_POST['bote']);

        $baraja = generarBaraja();
        var_dump($baraja);
        repartirCartas($baraja, $jugadores);

        asignarJugada($jugadores);
        var_dump($jugadores);

        $ganadores = obtenerGanadores($jugadores);
        $jugadaGanadora = $ganadores[0]['jugada'];
        $numGanadores = count($ganadores);
        $premio = calcularPremio($jugadaGanadora, $bote, $numGanadores);


        mostrarResultado($jugadores, $ganadores, $jugadaGanadora, $premio);
    }
?>