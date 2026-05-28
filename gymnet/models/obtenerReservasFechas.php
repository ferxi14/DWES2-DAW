<?php
    function obtenerReservasFechas($conn, $idsocio, $inicio, $fin) {
        try {
            $sql = "SELECT r.idclase, c.nombre, c.monitor, c.dia_semana, c.hora_inicio,
                           r.fecha_reserva, r.fecha_cancelacion, r.precio_pagado
                    FROM rreservas r
                    JOIN rclases c ON r.idclase = c.idclase
                    WHERE r.idsocio = :idsocio
                      AND DATE(r.fecha_reserva) >= :inicio
                      AND DATE(r.fecha_reserva) <= :fin
                    ORDER BY r.fecha_reserva ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idsocio', $idsocio, PDO::PARAM_INT);
            $stmt->bindValue(':inicio',  $inicio,  PDO::PARAM_STR);
            $stmt->bindValue(':fin',     $fin,     PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener las reservas: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
