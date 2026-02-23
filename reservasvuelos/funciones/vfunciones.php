<?php
    function limpiar_campo($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);  

        return $input;
    }

    function conexionBBDD() {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=reservas", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo "Error en la conexión: " . $e -> getMessage();
            return null;
        }
    }

    function obtenerCliente($conn, $email) {
        try {
            $sql = "SELECT * FROM clientes WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            trigger_error("Error en la obtencion de los datos del usuario: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function imprimirOpciones($sql, $valor, $texto) {
        $conn = conexionBBDD();

        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row[$valor] . "'>" . $row[$texto] . "</option>";
        }
    }

    function obtenerVuelos($conn) {
        try {
            $sql = 'SELECT * FROM vuelos WHERE asientos_disponibles > 0';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            trigger_error("Error en la obtencion de los vuelos: " . $e->getMessage(), E_USER_ERROR);
        }
    }

    function agregarVuelo($numAsientos, $vuelosVal) {
        if (count($vuelosVal) === 7) {
            $vueloData = [
                'id_vuelo' => $vuelosVal[0],
                'origen' => $vuelosVal[1],
                'destino' => $vuelosVal[2],
                'fechahorasalida' => $vuelosVal[3],
                'fechahorallegada' => $vuelosVal[4],
                'precio_asiento' => $vuelosVal[5],
                'asientos_disponibles' => $vuelosVal[6],
                'asientos' => $numAsientos
            ];

            // Verificar si el vuelo ya está en el carrito
            $exists = false;
            foreach ($_SESSION['carrito'] as &$vuelo) {
                if ($vuelo['id_vuelo'] === $vuelosVal[0]) {
                    if (($vuelo['asientos'] + $numAsientos) > $vuelo['asientos_disponibles']) {
                        trigger_error("Error: No hay suficientes asientos disponibles en este vuelo.", E_USER_WARNING);
                    } else {
                        $_SESSION['carrito']['asientos'] += $numAsientos;
                    }
                    $exists = true;
                    break;
                }
            }

            // Si no existe en el carrito, agregarlo
            if (!$exists) {
                $_SESSION['carrito'][] = $vueloData;
            }

            echo "<pre>";
            print_r($_SESSION['carrito']);
            echo "</pre>";
        } else {
            trigger_error("Error en la procesion del vuelo", E_USER_WARNING);
        }
    }

    // Funcion para obtener de la base de datos el ultimo id para utilizar el siguiente
    function obtenerMaxId($conn) {
        try {
            $sql = "SELECT MAX(id_reserva) FROM reservas";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $id = $stmt->fetchColumn();
            
            return $id;
        } catch(PDOException $e) {
            trigger_error("Error al obtener el nuevo id en la tabla invoice: ".$e->getMessage(), E_ERROR);
        }
    }

    // Funcion para insertar los datos de la reserva
    function insertarReserva($conn, $id_reserva, $id_vuelo, $dni_cliente, $num_asientos, $preciototal){

        $sql = "INSERT INTO reservas(id_reserva, id_vuelo, dni_cliente, fecha_reserva, num_asientos, preciototal) 
                VALUES (:id_reserva, :id_vuelo, :dni_cliente, NOW(), :num_asientos, :preciototal)";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id_reserva', $id_reserva, PDO::PARAM_STR);
        $stmt->bindValue(':id_vuelo', $id_vuelo, PDO::PARAM_INT);
        $stmt->bindValue(':dni_cliente', $dni_cliente, PDO::PARAM_STR);
        $stmt->bindValue(':num_asientos', $num_asientos, PDO::PARAM_INT);
        $stmt->bindValue(':preciototal', $preciototal, PDO::PARAM_STR);
        
        $stmt->execute();
    }

    // Funcion para actualizar el numero de asientos disponibles
    function updateAsientos($conn, $id_vuelo, $asientos) {
        $sql = "UPDATE vuelos SET asientos_disponibles = asientos_disponibles :asientos WHERE id_vuelo = :id_vuelo";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':asientos', $numAsientos);
        $stmt->bindParam(':id_vuelo', $idVuelo);

        $stmt->execute();
    }

    //Funcion de proceso de compra de un vuelo

    function procesarCompra($conn) {
        try {
            $conn->beginTransaction();

            $id_reserva = obtenerMaxId($conn);

            $numero = substr($id_reserva, 1);
            $numero = (int)$numero +1;
            $id_reserva = 'R' . str_pad($numero, 4, '0', STR_PAD_LEFT);

            foreach ($_SESSION['carrito'] as $i => $vuelo) {
                $id_vuelo = $_SESSION['carrito'][$i]['id_vuelo'];
                $asientos = $_SESSION['carrito'][$i]['asientos'];
                $precioReserva = $asientos * $_SESSION['carrito'][$i]['precio_asiento'];

                insertarReserva(
                    $conn,
                    $id_reserva,
                    $id_vuelo,
                    $_SESSION['usuario']['dni'],
                    $asientos,
                    $precioReserva
                );

                updateAsientos($conn, $id_vuelo, $asientos);
                  
                // Actualizamos al nuevo numero de id_reserva
                $numero = substr($id_reserva, 1);
                $numero = (int)$numero + 1;
                $id_reserva = 'R' . str_pad($numero, 4, '0', STR_PAD_LEFT);
            }
                
            echo 'Reserva realizada con éxito';

            $conn -> commit();

            // Reestablecemos el carrito una vez realizada la reserva
            $_SESSION['carrito'] = [];
            $totalPrice = 0;
        } catch (Exception $e) {
            $conn->rollBack();
            trigger_error("Error en la compra: " . $e->getMessage(), E_USER_WARNING);
        }
        }
?>