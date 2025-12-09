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

function arrayAssocDpto($conn) {
    try {
        $sql = "SELECT cod_dpto, nombre_dpto FROM departamento";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al obtener los departamentos: " . $e->getMessage();
        return [];
    }
}

function obtenerNuevoCodigoDepartamento($conn) {
    $sql = "SELECT cod_dpto FROM departamento ORDER BY cod_dpto DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $ultimo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ultimo) {
        $num = intval(substr($ultimo['cod_dpto'], 1)) + 1;
    } else {
        $num = 1;
    }

    return "D" . str_pad($num, 3, "0", STR_PAD_LEFT);
}

function insertarDepartamento($conn, $nombre_dpto) {
    $nuevoCodigo = obtenerNuevoCodigoDepartamento($conn);

    $sql = "INSERT INTO departamento (cod_dpto, nombre_dpto) 
            VALUES (:cod_dpto, :nombre_dpto)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':cod_dpto', $nuevoCodigo);
    $stmt->bindParam(':nombre_dpto', $nombre_dpto);

    echo "El departamento $nombre_dpto [$nuevoCodigo] se ha insertado con exito";
    return $stmt->execute();
}


function insertar_emple_BBDD($conn, $dni, $nombre, $apellidos, $salario, $fecha_nac) {
    if (empty($dni) || empty($nombre) || empty($apellidos) || empty($salario) || empty($fecha_nac)) {
        echo "Debes rellenar todos los campos";
        return;
    } else {
        $sql = "INSERT INTO empleado (dni, nombre, apellidos, salario, fecha_nac) VALUES (:dni, :nombre, :apellidos, :salario, :fecha_nac)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':salario', $salario);
        $stmt->bindParam(':fecha_nac', $fecha_nac);
        $stmt->execute();

        //echo "Empleado [$nombre] registrado con exito";
    }
}

function insertar_emple_dpto_BBDD($conn, $dni, $departamento) {
    if(!empty($departamento)) {
        $fecha_ini = date("Y-m-d");

        $sql = "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini) VALUES (:dni, :cod_dpto, :fecha_ini)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':cod_dpto', $departamento);
        $stmt->bindParam(':fecha_ini', $fecha_ini);
        
        $stmt->execute();

        //echo "Empleado con dni($dni) asignado al departamento[$departamento] con éxito.";
    } else {
        echo "Selecciona un departamento.";
    }
}

function cambiarDepartamentoEmpleado($conn, $dni, $cod_dpto) {
    $sql = "UPDATE emple_depart 
            SET cod_dpto = :cod_dpto 
            WHERE dni = :dni";

    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':cod_dpto', $cod_dpto);
    $stmt->bindParam(':dni', $dni);

    if (!$stmt->execute()) {
        $error = $stmt->errorInfo();
        throw new Exception("No se pudo asignar el departamento: " . $error[2]);
    }

    return true;
}

?>