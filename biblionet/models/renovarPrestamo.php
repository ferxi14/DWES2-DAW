<?php
    function obtenerDatosPrestamo($conn, $idusuario, $isbn) {
        try {
            $sql = "SELECT renovado, fecha_limite
                    FROM rprestamos
                    WHERE idusuario = :idusuario AND isbn = :isbn AND fecha_devolucion IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idusuario', $idusuario, PDO::PARAM_INT);
            $stmt->bindValue(':isbn',      $isbn,      PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener datos del préstamo: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function renovarPrestamo($conn, $idusuario, $isbn) {
        try {
            // Ampliar fecha_limite 14 días más y marcar como renovado
            $sql = "UPDATE rprestamos
                    SET fecha_limite = DATE_ADD(fecha_limite, INTERVAL 14 DAY),
                        renovado = 'S'
                    WHERE idusuario = :idusuario AND isbn = :isbn AND fecha_devolucion IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idusuario', $idusuario, PDO::PARAM_INT);
            $stmt->bindValue(':isbn',      $isbn,      PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al renovar el préstamo: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
