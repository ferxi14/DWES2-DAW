<?php

function cancelarReserva($conn, $idcliente, $idhabitacion, $fecha_reserva){
    try {
        $fecha_cancelacion = date('Y-m-d');
        
        $sql = "UPDATE rreservas
                SET estado='cancelada', fecha_cancelacion=?
                WHERE idcliente=? AND idhabitacion=? AND fecha_reserva=?";
        $stmt = $conn->prepare($sql);
        $resultado = $stmt->execute([$fecha_cancelacion, $idcliente, $idhabitacion, $fecha_reserva]);
        
        if ($resultado) {
            // Verificar si la habitación tiene otras reservas activas
            $sql_check = "SELECT COUNT(*) as count FROM rreservas 
                         WHERE idhabitacion=? AND estado='activa'";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->execute([$idhabitacion]);
            $reservas = $stmt_check->fetch();
            
            if ($reservas['count'] == 0) {
                $sql_update = "UPDATE rhabitaciones SET disponible='S' WHERE idhabitacion=?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->execute([$idhabitacion]);
            }
        }
        
        return $resultado;
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

?>