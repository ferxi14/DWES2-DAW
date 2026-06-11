<?php
    function insertarPedido($conn, $dni, $importeTotal) {
        try {
            $sql = "INSERT INTO pedidos (dni, fecha_venta, importe_total)
                    VALUES (:dni, NOW(), :importe)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':dni',    $dni,         PDO::PARAM_STR);
            $stmt->bindValue(':importe',$importeTotal, PDO::PARAM_STR);
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            trigger_error("Error al insertar pedido: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function insertarLineaPedido($conn, $numPedido, $numBastidor, $precioFinal) {
    try {
        // Contar cuántas líneas tiene ya este pedido para calcular el siguiente num_linea
        $sqlCount = "SELECT COUNT(*) FROM lineaspedido WHERE num_pedido = :numpedido";
        $stmtCount = $conn->prepare($sqlCount);
        $stmtCount->bindValue(':numpedido', $numPedido, PDO::PARAM_INT);
        $stmtCount->execute();
        $numLinea = (int)$stmtCount->fetchColumn() + 1;

        $sql = "INSERT INTO lineaspedido (num_pedido, num_linea, num_bastidor, precio_vehiculo)
                VALUES (:numpedido, :numlinea, :numbastidor, :precio)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':numpedido',   $numPedido,   PDO::PARAM_INT);
        $stmt->bindValue(':numlinea',    $numLinea,    PDO::PARAM_INT);
        $stmt->bindValue(':numbastidor', $numBastidor, PDO::PARAM_STR);
        $stmt->bindValue(':precio',      $precioFinal, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        trigger_error("Error al insertar línea: " . $e->getMessage(), E_USER_ERROR);
    }
}

    function marcarVehiculoVendido($conn, $numBastidor) {
        try {
            $sql = "UPDATE vehiculos SET fecha_venta = NOW() 
                    WHERE num_bastidor = :numbastidor";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':numbastidor', $numBastidor, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            trigger_error("Error al marcar vehículo como vendido: " . $e->getMessage(), E_USER_ERROR);
        }
    }
?>