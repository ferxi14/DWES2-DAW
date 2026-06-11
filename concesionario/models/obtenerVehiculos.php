<?php
    function obtenerVehiculos($conn) {
        try {
            $sql = "SELECT num_bastidor, matricula, marca, modelo, kms, precio_vehiculo, descuento
                    FROM vehiculos
                    WHERE fecha_venta IS NULL
                    ORDER BY marca, modelo";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            trigger_error("Error al obtener vehiculos: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?> 