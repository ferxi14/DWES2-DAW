<?php
    function obtenerReservasActivas($conn, $idsocio) {
        try {
            $sql = "SELECT r.idclase, c.nombre, c.monitor, c.dia_semana, c.hora_inicio, r.precio_pagado
                    FROM rreservas r
                    JOIN rclases c ON r.idclase = c.idclase
                    WHERE r.idsocio = :idsocio
                      AND r.fecha_cancelacion IS NULL
                      AND r.fechahorapago IS NOT NULL
                    ORDER BY c.dia_semana, c.hora_inicio";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idsocio', $idsocio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener las reservas activas: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
