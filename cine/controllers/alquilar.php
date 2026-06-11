<?php

include_once "gestionSesiones.php";

include_once "../db/conexionBBDD.php";
$conn = conexionBBDD();

include_once "../models/obtenerPeliculas.php";

$peliculas = obtenerPeliculas($conn);

if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = [];
}

/* ==========================
   AGREGAR A CESTA
   ========================== */

if (isset($_POST['agregar'])) {

    if (!empty($_POST['pelicula'])) {

        list(
            $idpelicula,
            $titulo,
            $director,
            $genero
        ) = explode("|", $_POST['pelicula']);

        $existe = false;

        foreach ($_SESSION['cesta'] as $item) {

            if ($item['idpelicula'] == $idpelicula) {
                $existe = true;
                break;
            }
        }

        if (!$existe) {

            if (count($_SESSION['cesta']) < 4) {

                $_SESSION['cesta'][] = [
                    'idpelicula' => $idpelicula,
                    'titulo'     => $titulo,
                    'director'   => $director,
                    'genero'     => $genero
                ];

            } else {

                trigger_error(
                    "Máximo 4 películas en la cesta",
                    E_USER_WARNING
                );
            }

        } else {

            trigger_error(
                "La película ya está en la cesta",
                E_USER_WARNING
            );
        }
    }
}

/* ==========================
   VACIAR CESTA
   ========================== */

if (isset($_POST['vaciar'])) {

    $_SESSION['cesta'] = [];
}

/* ==========================
   CONFIRMAR ALQUILER
   ========================== */

if (isset($_POST['confirmar'])) {

    if (!empty($_SESSION['cesta'])) {

        $idusuario = $_SESSION['usuario']['idusuario'];

        $activos = $_SESSION['usuario']['alquileres_activos'];

        if (($activos + count($_SESSION['cesta'])) <= 4) {

            include_once "../models/insertarAlquiler.php";

            insertarAlquiler(
                $conn,
                $idusuario,
                $_SESSION['cesta']
            );

            $_SESSION['ultimo_alquiler'] = [
                'idusuario' => $idusuario,
                'fecha_alquiler' => date('Y-m-d'),
                'cantidad' => count($_SESSION['cesta'])
            ];

            $_SESSION['cesta'] = [];

        } else {

            trigger_error(
                "No puede tener más de 4 alquileres activos",
                E_USER_WARNING
            );
        }

    } else {

        trigger_error(
            "La cesta está vacía",
            E_USER_WARNING
        );
    }
}

/* ==========================
   VOLVER
   ========================== */

if (isset($_POST['volver'])) {

    unset($_SESSION['ultimo_alquiler']);

    header("Location: inicio.php");
    exit();
}

include_once "../views/formAlquilar.php";

$conn = null;