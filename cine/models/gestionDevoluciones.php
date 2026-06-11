<?php

function obtenerAlquileresActivos($conn, $idusuario)
{
    try {

        $sql = "SELECT
                    a.idpelicula,
                    p.titulo,
                    a.fecha_alquiler,
                    a.fecha_limite,
                    a.renovado
                FROM ralquileres a
                INNER JOIN rpeliculas p
                    ON a.idpelicula = p.idpelicula
                WHERE a.idusuario = :idusuario
                AND a.fecha_devolucion IS NULL";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(
            ':idusuario',
            $idusuario,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {

        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

function devolverAlquiler($conn, $idusuario, $idpelicula)
{
    $sql = "UPDATE ralquileres
            SET fecha_devolucion = CURDATE()
            WHERE idusuario = :idusuario
            AND idpelicula = :idpelicula
            AND fecha_devolucion IS NULL";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':idusuario' => $idusuario,
        ':idpelicula' => $idpelicula
    ]);
}

function marcarPeliculaDisponible($conn, $idpelicula)
{
    $sql = "UPDATE rpeliculas
            SET disponible='S'
            WHERE idpelicula=:idpelicula";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':idpelicula' => $idpelicula
    ]);
}

function restarAlquilerActivo($conn, $idusuario)
{
    $sql = "UPDATE rusuarios
            SET alquileres_activos =
                alquileres_activos - 1
            WHERE idusuario=:idusuario";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':idusuario' => $idusuario
    ]);
}

function renovarAlquiler($conn, $idusuario, $idpelicula)
{
    $sql = "UPDATE ralquileres
            SET fecha_limite =
                DATE_ADD(fecha_limite, INTERVAL 3 DAY),
                renovado='S'
            WHERE idusuario=:idusuario
            AND idpelicula=:idpelicula
            AND fecha_devolucion IS NULL";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':idusuario' => $idusuario,
        ':idpelicula' => $idpelicula
    ]);
}
?>