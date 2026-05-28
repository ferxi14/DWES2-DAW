<?php
    function cancelarReserva($conn, $idsocio, $idclase) {
        try {
            $sql = "UPDATE rreservas
                    SET fecha_cancelacion = NOW()
                    WHERE idsocio = :idsocio
                      AND idclase = :idclase
                      AND fecha_cancelacion IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idsocio', $idsocio, PDO::PARAM_INT);
            $stmt->bindValue(':idclase', $idclase, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al cancelar la reserva: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function decrementarAforo($conn, $idclase) {
        try {
            $sql = "UPDATE rclases SET aforo_actual = aforo_actual - 1 WHERE idclase = :idclase";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idclase', $idclase, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al decrementar el aforo: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
