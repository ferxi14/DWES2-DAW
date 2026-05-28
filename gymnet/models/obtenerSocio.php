<?php
    function obtenerSocio($conn, $email, $idsocio) {
        try {
            $sql = "SELECT idsocio, nombre, apellido, email, fecha_baja, saldo_pendiente
                    FROM rsocios
                    WHERE email = :email AND idsocio = :idsocio";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email',   $email,   PDO::PARAM_STR);
            $stmt->bindValue(':idsocio', $idsocio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener el socio: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>
