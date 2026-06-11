<?php

function conexionBBDD() {
    try {
        $host = 'localhost';
        $bd = 'hotelnet';
        $usuario = 'root';
        $clave = '';
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $conn = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $clave, $opciones);
        return $conn;
    } catch (PDOException $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
}

?>