<?php
    function obtenerPedidosCliente($conn, $dni) {
        try {
            $sql = "SELECT num_pedido, fecha_venta, importe_total
                    FROM pedidos
                    WHERE dni = :dni
                    ORDER BY fecha_venta DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':dni', $dni, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener pedidos: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function obtenerLineasPedido($conn, $numPedido) {
        try {
            $sql = "SELECT lp.num_bastidor, v.matricula, v.marca, v.modelo,
                           v.kms, lp.precio_vehiculo, v.descuento, p.fecha_venta
                    FROM lineaspedido lp
                    JOIN vehiculos v ON lp.num_bastidor = v.num_bastidor
                    JOIN pedidos p   ON lp.num_pedido   = p.num_pedido
                    WHERE lp.num_pedido = :numpedido";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':numpedido', $numPedido, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            trigger_error("Error al obtener líneas: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>