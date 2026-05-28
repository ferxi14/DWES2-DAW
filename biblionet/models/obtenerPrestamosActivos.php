<?php
    function obtenerPrestamosActivos($conn, $idusuario) {
        try {
            $sql = "SELECT p.isbn, l.titulo, l.autor, p.fecha_prestamo, p.fecha_limite, p.renovado
                    FROM rprestamos p
                    JOIN rlibros l ON p.isbn = l.isbn
                    WHERE p.idusuario = :idusuario AND p.fecha_devolucion IS NULL
                    ORDER BY p.fecha_prestamo";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idusuario', $idusuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener los préstamos activos: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
