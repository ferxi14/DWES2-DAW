<?php

function obtenerCliente($conn, $email, $clave){
    try {
        $sql = "SELECT *
                FROM rclientes
                WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

?>