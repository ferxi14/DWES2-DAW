<?php
    function obtenerCanciones($conn) {
        try {
            $sql = 'SELECT TrackId, Name, Composer, UnitPrice FROM track LIMIT 50';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            trigger_error("Error en la obtencion de las canciones: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>