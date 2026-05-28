<?php
    function conexionBBDD() {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=gymnet", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("SET NAMES 'utf8'");
            return $conn;
        } catch (PDOException $e) {
            echo "Error en la conexión con la BBDD: " . $e->getMessage();
            return null;
        }
    }
?>
