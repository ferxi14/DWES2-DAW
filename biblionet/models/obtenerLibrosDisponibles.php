<?php
    function obtenerLibrosDisponibles($conn) {
        try {
            $sql = "SELECT l.isbn, l.titulo, l.autor, l.genero
                    FROM rlibros l
                    WHERE l.disponible = 'S'
                    AND l.isbn NOT IN (
                        SELECT isbn FROM rprestamos WHERE fecha_devolucion IS NULL
                    )
                    ORDER BY l.titulo";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener los libros disponibles: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>