<?php
    function contarReservasActivas($conn, $idsocio) {
        try {
            $sql = "SELECT COUNT(*) FROM rreservas
                    WHERE idsocio = :idsocio
                      AND fecha_cancelacion IS NULL
                      AND fechahorapago IS NOT NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idsocio', $idsocio, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            trigger_error("Error al contar reservas activas: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
