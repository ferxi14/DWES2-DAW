<?php
function obtenerCliente($conn, $email, $clave)
{
    try {
        $sql = "SELECT *
            FROM rusuarios
            WHERE email = :email
            AND idusuario = :idusuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':idusuario', $clave, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}
?>