<?php
function obtenerUsuario($conn, $email, $idusuario) {

    try {

        $sql = "SELECT *
                FROM rusuarios
                WHERE email = :email
                AND idusuario = :idusuario";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':idusuario', $idusuario);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

?>