<?php
    function registrarDevolucion($conn, $idusuario, $isbn) {
        try {
            $sql = "UPDATE rprestamos
                    SET fecha_devolucion = NOW()
                    WHERE idusuario = :idusuario AND isbn = :isbn AND fecha_devolucion IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idusuario', $idusuario, PDO::PARAM_INT);
            $stmt->bindValue(':isbn',      $isbn,      PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al registrar la devolución: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function marcarLibroDisponible($conn, $isbn) {
        try {
            $sql = "UPDATE rlibros SET disponible = 'S' WHERE isbn = :isbn";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al marcar el libro como disponible: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function actualizarPrestamosActivosDevolver($conn, $idusuario, $nuevovalor) {
        try {
            $sql = "UPDATE rusuarios SET prestamos_activos = :valor WHERE idusuario = :idusuario";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':valor',     $nuevovalor, PDO::PARAM_INT);
            $stmt->bindValue(':idusuario', $idusuario,  PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al actualizar préstamos activos: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
