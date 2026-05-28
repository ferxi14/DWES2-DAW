<?php
    function obtenerPrestamosFechas($conn, $idusuario, $inicio, $fin) {
        try {
            $sql = "SELECT p.isbn, l.titulo, l.autor,
                           p.fecha_prestamo, p.fecha_limite, p.fecha_devolucion, p.renovado
                    FROM rprestamos p
                    JOIN rlibros l ON p.isbn = l.isbn
                    WHERE p.idusuario = :idusuario
                      AND DATE(p.fecha_prestamo) >= :inicio
                      AND DATE(p.fecha_prestamo) <= :fin
                    ORDER BY p.fecha_prestamo ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':idusuario', $idusuario, PDO::PARAM_INT);
            $stmt->bindValue(':inicio',    $inicio,    PDO::PARAM_STR);
            $stmt->bindValue(':fin',       $fin,       PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener los préstamos: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
