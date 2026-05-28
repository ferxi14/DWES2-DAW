<?php
    function obtenerClasesDisponibles($conn) {
        try {
            // Clases activas con aforo libre (aforo_actual < aforo_maximo)
            $sql = "SELECT idclase, nombre, monitor, dia_semana, hora_inicio, duracion_min,
                           aforo_maximo, aforo_actual, precio
                    FROM rclases
                    WHERE activa = 'S'
                      AND aforo_actual < aforo_maximo
                    ORDER BY dia_semana, hora_inicio";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener las clases disponibles: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
