<?php
    function obtenerCliente($conn, $email) {
        try {
            $sql = "SELECT * FROM customer WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            trigger_error("Error en la obtencion de los datos del usuario: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>