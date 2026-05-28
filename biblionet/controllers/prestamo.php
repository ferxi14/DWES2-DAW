<?php
    include_once "../controllers/gestionSesiones.php";
    include_once "../controllers/error.php";

    include_once "../db/conexionBBDD.php";
    $conn = conexionBBDD();

    include_once "../models/obtenerLibrosDisponibles.php";
    $libros = obtenerLibrosDisponibles($conn);

    // Inicializar cesta en sesión si no existe
    if (!isset($_SESSION['cesta'])) {
        $_SESSION['cesta'] = [];
    }

    // Botón Agregar a Cesta
    if (isset($_POST['agregar'])) {
        $libroData = explode("|", $_POST['libros']);

        if (count($libroData) === 3) {
            $isbn = $libroData[0];
            $titulo = $libroData[1];
            $autor = $libroData[2];

            if (count($_SESSION['cesta']) >= 3) {
                trigger_error("La cesta ya tiene el máximo de 3 libros.", E_USER_WARNING);
            } else {
                $yaEnCesta = false;
                foreach ($_SESSION['cesta'] as $item) {
                    if ($item['isbn'] === $isbn) {
                        $yaEnCesta = true;
                        break;
                    }
                }

                if ($yaEnCesta) {
                    trigger_error("Este libro ya está en la cesta.", E_USER_WARNING);
                } else {
                    $_SESSION['cesta'][] = [
                        'isbn' => $isbn,
                        'titulo' => $titulo,
                        'autor' => $autor
                    ];
                }
            }
        } else {
            trigger_error("Datos del libro no válidos.", E_USER_WARNING);
        }
    }

    // Botón Vaciar Cesta
    if (isset($_POST['vaciar'])) {
        $_SESSION['cesta'] = [];
    }

    // Botón Realizar Préstamo
    if (isset($_POST['confirmar'])) {
        if (empty($_SESSION['cesta'])) {
            trigger_error("La cesta está vacía.", E_USER_WARNING);
        } else {
            $idusuario = $_SESSION['cliente']['idusuario'];
            $activos   = $_SESSION['cliente']['prestamos_activos'];

            if ($activos + count($_SESSION['cesta']) > 3) {
                trigger_error("No puede superar 3 préstamos activos. Actualmente tiene " . $activos . " activo/s.", E_USER_WARNING);
            } else {
                include_once "../models/insertarPrestamo.php";

                try {
                    $conn->beginTransaction();

                    foreach ($_SESSION['cesta'] as $item) {
                        insertarPrestamo($conn, $idusuario, $item['isbn']);
                        marcarLibroNoDisponible($conn, $item['isbn']);
                    }

                    // Actualizar prestamos_activos en la sesión y en la BD
                    actualizarPrestamosActivos($conn, $idusuario, $activos + count($_SESSION['cesta']));
                    $_SESSION['cliente']['prestamos_activos'] = $activos + count($_SESSION['cesta']);

                    $conn->commit();
                    $_SESSION['cesta'] = [];
                    echo "<p style='color:green'><b>Préstamo realizado correctamente.</b></p>";

                } catch (PDOException $e) {
                    $conn->rollBack();
                    trigger_error("Error al realizar el préstamo: " . $e->getMessage(), E_USER_ERROR);
                }

                // Recargar lista de libros disponibles
                $libros = obtenerLibrosDisponibles($conn);
            }
        }
    }

    include_once "../views/formPrestamo.php";

    $conn = null;
?>