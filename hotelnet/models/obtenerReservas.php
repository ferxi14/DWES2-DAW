<?php

function obtenerReservas($conn, $idcliente){
    try {
        $sql = "SELECT r.*, h.numero, h.tipo, h.precio_noche
                FROM rreservas r
                INNER JOIN rhabitaciones h ON r.idhabitacion = h.idhabitacion
                WHERE r.idcliente=? AND r.estado='activa'
                ORDER BY r.fecha_entrada DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$idcliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

?>