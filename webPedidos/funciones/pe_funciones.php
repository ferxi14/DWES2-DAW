<?php
    function limpiar_campo($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);  

        return $input;
    }

    function conexionBBDD() {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=pedidos", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Error en la conexión: " . $e -> getMessage();
            return null;
        }
    }

    function ejecutarConsulta($sql, $parametros = [], $fetchMode = PDO::FETCH_ASSOC, $singleValue=false) {
        $conn = conexionBBDD();

        try {
            $stmt = $conn->prepare($sql);
            foreach ($parametros as $clave => $valor) {
                $stmt->bindValue($clave, $valor);
            }
            $stmt->execute();
            if ($singleValue) {
                return $stmt->fetch($fetchMode)[0]; // Obtiene el primer valor de la fila
            }
            return $stmt->fetchAll($fetchMode);
        } catch (Exception $e) {
            die("Error en la consulta: " . $e -> getMessage());
        }
    }

    function ejecutarConsultaValor($sql, $parametros = []) {
        $conn = conexionBBDD();

        try {
            $stmt = $conn->prepare($sql);
            foreach ($parametros as $clave => $valor) {
                $stmt->bindValue($clave, $valor);
            }
            $stmt->execute();

            return $stmt->fetchColumn(); // Devuelve el primer valor de la primera columna
        } catch (Exception $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    function agregarProd($productCode, $quantity){
        $existe = false;

        // Verificar si el producto ya existe en el carrito, si existe sumamos la cantidad
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['productCode'] === $productCode) {
                $item['quantity'] += $quantity;
                $existe = true;
                break;
            }
        }

        // Si no existe lo añadimos al carrito
        if (!$existe) {
            $_SESSION['carrito'][] = array(
                'productCode' => $productCode,
                'quantity' => $quantity
            );
        }

        //var_dump($_SESSION['carrito']);
    }

    function eliminarProductoDelCarrito($botonEliminar){
        foreach ($_SESSION['carrito'] as $index => $item) {
            if ($item['productCode'] == $botonEliminar) {
                unset($_SESSION['carrito'][$index]);
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
        //var_dump($_SESSION['carrito']);
    }

    function mostrarCarrito() {
        foreach ($_SESSION['carrito'] as $item) {
            $sql = "SELECT productName FROM products WHERE productCode = :productCode";
            $parametros = array('productCode' => $item['productCode']);
            $productName = ejecutarConsultaValor($sql, $parametros);
            
            echo "<tr>";
            echo "<td>" . $productName . "</td>";
            echo "<td>" . $item['quantity'] . "</td>";
            echo "<td>
                    <form method='POST' action=''>
                        <input type='hidden' name='productCodeToRemove' value='" . $item['productCode'] . "'>
                        <input type='submit' name='eliminar' value='Eliminar'>
                    </form>
                </td>";
            echo "</tr>";
        }
    }

    function imprimirDatosOrder($orderNumber, $orderDate, $requiredDate) {
        echo "<br>";
        echo "<b>orders</b><br>";
        echo "OrderNumber: $orderNumber <br>";
        echo "OrderDate: $orderDate <br>";
        echo "RequiredDate: $requiredDate <br>";
        echo "shippedDate: null<br>";
        echo "status: Pending<br>";
        echo "CustomerNumber:". $_SESSION['customerNumber'] . "<br>";
        echo "<br>";
    }

    function imprimirDatosOrderDetails($orderNumber, $productCode, $quantity , $buyPrice, $orderLineNumber) {
        echo "<br>";
        echo "<b>orderDetails</b><br>";
        echo "OrderNumber: $orderNumber <br>";
        echo "productCode: ". $productCode . "<br>";
        echo "quantityOrdered: ". $quantity . "<br>";
        echo "buyPrice: $buyPrice <br>";
        echo "orderLineNumber: $orderLineNumber";
        echo "<br>";
        }

    // Función para imprimir los datos de la tabla "payments"
    function imprimirDatosPayment($customerNumber, $checkNumber, $orderDate, $totalAmount) {
        echo "<br>";
        echo "<b>payments</b><br>";
        echo "CustomerNumber: $customerNumber <br>";
        echo "checkNumber: $checkNumber <br>";
        echo "paymentDate: $orderDate <br>";
        echo "amount: $totalAmount <br>";
        echo "<br>";
    }

    // Función para actualizar el stock de un producto
    function actualizarStockProducto($conn, $productCode, $quantity) {
        $sql = "UPDATE products SET quantityInStock = quantityInStock - :quantity WHERE productCode = :productCode";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->bindValue(':productCode', $productCode);
        $stmt->execute();
    }

    // Función para insertar datos en una tabla
    function insertarDatos($tabla, $camposValores) {
        try {
            $conn = conexionBBDD();

            $columnas = implode(', ', array_keys($camposValores));
            $placeholders = ':' . implode(', :', array_keys($camposValores));

            $sql = "INSERT INTO $tabla ($columnas) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);

            foreach($camposValores as $campo => $valor) {
                $stmt -> bindValue(':' . $campo, $valor);
            }

            $stmt->execute();
            echo "Datos insertados correctamente";
        } catch (PDOException $e) {
            echo "Error al insertar datos: " . $e -> getMessage();
        }
    }

    // Función para imprimir opciones en un select
    function imprimirOpciones($sql, $valor, $texto) {
        $conn = conexionBBDD();

        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row[$valor] . "'>" . $row[$texto] . "</option>";
        }
    }

    // Función para realizar un pedido
    function realizarPedido($conn){
        try {
            $conn->beginTransaction();

            $sql = 'SELECT MAX(orderNumber) FROM orders';
            $orderNumber = ejecutarConsultaValor($sql);
            $orderNumber = (int)$orderNumber + 1;

            $orderDate = date('Y-m-d');
            $requiredDate = $_POST['requiredDate'];

            // Insertar datos del pedido
            $insertOrderData = [
                'orderNumber' => $orderNumber,
                'orderDate' => $orderDate,
                'requiredDate' => $requiredDate,
                'shippedDate' => null,
                'status' => 'Pending',
                'customerNumber' => $_SESSION['customerNumber']
            ];
            insertarDatos('orders', $insertOrderData);
            imprimirDatosOrder($orderNumber, $orderDate, $requiredDate);

            $totalAmount = 0;
            $orderLineNumber = 1;
            // Insertar los detalles del pedido y actualizar el stock
            foreach ($_SESSION['carrito'] as $item) {
                // Obtener el precio de compra del producto
                $sql = "SELECT buyPrice FROM products WHERE productCode = :productCode";
                $parametros = array('productCode' => $item['productCode']);
                $buyPrice = ejecutarConsultaValor($sql, $parametros);
                
                // Insertar detalle del pedido
                $insertOrderDetails = [
                    'orderNumber' => $orderNumber,
                    'productCode' => $item['productCode'],
                    'quantityOrdered' => $item['quantity'],
                    'priceEach' => $buyPrice,
                    'orderLineNumber' => $orderLineNumber
                ];
                insertarDatos('orderdetails', $insertOrderDetails);
                imprimirDatosOrderDetails($orderNumber,  $item['productCode'], $item['quantity'], $buyPrice, $orderLineNumber);

                // Actualizar el stock del producto
                actualizarStockProducto($conn, $item['productCode'], $item['quantity']);

                // Calcular el total
                $totalAmount += $buyPrice * $item['quantity'];
                $orderLineNumber++;
            }

            // Registrar el pago
            $checkNumber = $_POST['checkNumber'];
            $insertPaymentData = [
                'customerNumber' => $_SESSION['customerNumber'],
                'checkNumber' => $checkNumber,
                'paymentDate' => $orderDate,
                'amount' => $totalAmount
            ];
            insertarDatos('payments', $insertPaymentData);
            imprimirDatosPayment($_SESSION['customerNumber'], $checkNumber, $orderDate, $totalAmount);

            // Vaciar el carrito
            $_SESSION['carrito'] = array();

            $conn->commit();

            echo "Pedido realizado con éxito. Total: $" . number_format($totalAmount, 2);
        }
        catch (PDOException $e) {
            $conn->rollBack();
            echo "Error al realizar el pedido: " . $e->getMessage();
        }
    }

    // Función para obtener los pedidos de un cliente
    function obtenerPedidosCliente($customerNumber) {
        $conn = conexionBBDD();

        $sql = "SELECT o.orderNumber, o.orderDate, o.status,
                    od.orderLineNumber, p.productName,
                    od.quantityOrdered, od.priceEach
                FROM orders o
                JOIN orderdetails od ON o.orderNumber = od.orderNumber
                JOIN products p ON od.productCode = p.productCode
                WHERE o.customerNumber = :customerNumber
                ORDER BY od.orderLineNumber";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':customerNumber', $customerNumber);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Función para mostrar la tabla de pedidos
    function mostrarTablaPedidos(array $pedidos, $customerNumber) {
        if (empty($pedidos)) {
            echo "No se encontraron pedidos para este cliente.";
            return;
        }

        echo "<h3>Pedidos de Cliente: " . htmlspecialchars($customerNumber) . "</h3>";
        echo "<table border='1'>
                <tr>
                    <th>Número Pedido</th>
                    <th>Fecha Pedido</th>
                    <th>Estado</th>
                    <th>Número de Línea</th>
                    <th>Nombre Producto</th>
                    <th>Cantidad Pedida</th>
                    <th>Precio Unidad</th>
                </tr>";

        foreach ($pedidos as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['orderNumber']) . "</td>
                    <td>" . htmlspecialchars($row['orderDate']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td>" . htmlspecialchars($row['orderLineNumber']) . "</td>
                    <td>" . htmlspecialchars($row['productName']) . "</td>
                    <td>" . htmlspecialchars($row['quantityOrdered']) . "</td>
                    <td>" . number_format($row['priceEach'], 2) . "</td>
                </tr>";
        }

        echo "</table>";
    }
?>