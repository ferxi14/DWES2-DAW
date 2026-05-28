<?php
    function insertarReserva($conn, $idsocio, $idclase, $precio) {
        try {
            $sql = "INSERT INTO rreservas (idsocio, idclase, fecha_reserva, fechahorapago, precio_pagado)
                    VALUES (:idsocio, :idclase, NOW(), NOW(), :precio)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idsocio', $idsocio, PDO::PARAM_INT);
            $stmt->bindValue(':idclase', $idclase, PDO::PARAM_INT);
            $stmt->bindValue(':precio',  $precio,  PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al insertar la reserva: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function incrementarAforo($conn, $idclase) {
        try {
            $sql = "UPDATE rclases SET aforo_actual = aforo_actual + 1 WHERE idclase = :idclase";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idclase', $idclase, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al incrementar el aforo: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
