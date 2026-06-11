<?php
function obtenerAlquileres($conn, $idusuario, $desde, $hasta)
{
    try {

        $sql = "SELECT a.idpelicula,
                        p.titulo,
                        p.director,
                        a.fecha_alquiler,
                        a.fecha_limite,
                        a.fecha_devolucion,
                        a.renovado
                FROM ralquileres a
                INNER JOIN rpeliculas p
                    ON a.idpelicula = p.idpelicula
                WHERE a.idusuario = :idusuario
                AND a.fecha_alquiler BETWEEN :desde AND :hasta
                ORDER BY a.fecha_alquiler";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(
            ':idusuario',
            $idusuario,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':desde',
            $desde,
            PDO::PARAM_STR
        );

        $stmt->bindValue(
            ':hasta',
            $hasta,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {

        trigger_error(
            $e->getMessage(),
            E_USER_ERROR
        );
    }
}
?>