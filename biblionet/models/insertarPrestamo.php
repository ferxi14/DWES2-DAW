<?php
    function insertarPrestamo($conn, $idusuario, $isbn) {
        try {
            // fecha_limite = fecha_prestamo + 21 días
            $sql = "INSERT INTO rprestamos (idusuario, isbn, fecha_prestamo, fecha_limite, renovado)
                    VALUES (:idusuario, :isbn, NOW(), DATE_ADD(NOW(), INTERVAL 21 DAY), 'N')";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idusuario', $idusuario, PDO::PARAM_INT);
            $stmt->bindValue(':isbn',      $isbn,      PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al insertar el préstamo: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function marcarLibroNoDisponible($conn, $isbn) {
        try {
            $sql = "UPDATE rlibros SET disponible = 'N' WHERE isbn = :isbn";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':isbn', $isbn, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al actualizar disponibilidad del libro: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function actualizarPrestamosActivos($conn, $idusuario, $nuevovalor) {
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