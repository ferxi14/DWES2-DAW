<?php
function limpiar_campo($campo){
    $campo = trim($campo);
    $campo = stripslashes($campo);
    $campo = htmlspecialchars($campo);
    return $campo;
}

function conexionBBDD(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "empleados";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;

    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}

?>