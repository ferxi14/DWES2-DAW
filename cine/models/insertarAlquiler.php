<?php

function insertarAlquiler($conn, $idusuario, $cesta)
{
    try {

        $conn->beginTransaction();

        foreach ($cesta as $pelicula) {

            $fechaAlquiler = date('Y-m-d');

            $fechaLimite = date(
                'Y-m-d',
                strtotime('+7 days')
            );

            $sql = "INSERT INTO ralquileres
                    (
                        idusuario,
                        idpelicula,
                        fecha_alquiler,
                        fecha_limite,
                        renovado
                    )
                    VALUES
                    (
                        :idusuario,
                        :idpelicula,
                        :fecha_alquiler,
                        :fecha_limite,
                        'N'
                    )";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(
                ':idusuario',
                $idusuario,
                PDO::PARAM_INT
            );

            $stmt->bindValue(
                ':idpelicula',
                $pelicula['idpelicula'],
                PDO::PARAM_INT
            );

            $stmt->bindValue(
                ':fecha_alquiler',
                $fechaAlquiler,
                PDO::PARAM_STR
            );

            $stmt->bindValue(
                ':fecha_limite',
                $fechaLimite,
                PDO::PARAM_STR
            );

            $stmt->execute();

            $sql = "UPDATE rpeliculas
                    SET disponible = 'N'
                    WHERE idpelicula = :idpelicula";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(
                ':idpelicula',
                $pelicula['idpelicula'],
                PDO::PARAM_INT
            );

            $stmt->execute();
        }

        $sql = "UPDATE rusuarios
                SET alquileres_activos =
                    alquileres_activos + :cantidad
                WHERE idusuario = :idusuario";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(
            ':cantidad',
            count($cesta),
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':idusuario',
            $idusuario,
            PDO::PARAM_INT
        );

        $stmt->execute();

        $conn->commit();

    } catch (PDOException $e) {

        $conn->rollBack();

        trigger_error(
            $e->getMessage(),
            E_USER_ERROR
        );
    }
}
?>