<?php
    function obtenerCliente($conn, $email, $clave) {
        try {
            $sql = "SELECT dni, nombre, apellidos, email, clave
                    FROM Clientes
                    WHERE email = :email AND clave = :clave";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':clave', $clave, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }
?>