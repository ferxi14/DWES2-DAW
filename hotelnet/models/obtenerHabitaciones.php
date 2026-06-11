<?php

function obtenerHabitaciones($conn){
    try {
        $sql = "SELECT *
                FROM rhabitaciones
                WHERE disponible='S'
                ORDER BY tipo, precio_noche";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

?>