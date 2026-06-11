<?php

function insertarReserva($conn, $idcliente, $idhabitacion, $fecha_entrada, $fecha_salida){
    try {
        $fecha_reserva = date('Y-m-d');
        $estado = 'activa';
        
        $sql = "INSERT INTO rreservas (idcliente, idhabitacion, fecha_reserva, fecha_entrada, fecha_salida, estado)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $resultado = $stmt->execute([$idcliente, $idhabitacion, $fecha_reserva, $fecha_entrada, $fecha_salida, $estado]);
        
        if ($resultado) {
            $sql_update = "UPDATE rhabitaciones SET disponible='N' WHERE idhabitacion=?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->execute([$idhabitacion]);
        }
        
        return $resultado;
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

?>