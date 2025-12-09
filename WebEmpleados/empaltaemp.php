<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados - Alta Empleados</title>
</head>
<body>
    <form action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni"><br>
    
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre"><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos"><br>

        <label for="salario">Salario:</label>
        <input type="text" name="salario" id="salario"><br>

        <label for="fecha_nac">Fecha de nacimiento:</label>
        <input type="date" name="fecha_nac" id="fecha_nac"><br>

        <label for="departamento">Departamento:</label>
        <select name="departamento" id="departamento" required>
            <option value="">Seleccione un departamento</option>
            <?php
                include "funciones.php";

                $conn = ConexionBBDD();
                if ($conn) {
                    // Cargar lista de departamentos
                    $departamentos = arrayAssocDpto($conn);
                    foreach ($departamentos as $dpto) {
                        echo "<option value='" . htmlspecialchars($dpto['cod_dpto']) . "'>" . htmlspecialchars($dpto['nombre_dpto']) . "</option>";
                    }
                } else {
                    echo "<option disabled>Error al cargar departamentos</option>";
                }
            ?>
        </select><br>

        <input type="submit" value="Enviar">
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $dni = limpiar_campo($_POST['dni']);
                $nombre = limpiar_campo($_POST['nombre']);
                $apellidos = limpiar_campo($_POST['apellidos']);
                $salario = limpiar_campo($_POST['salario']);
                $fecha_nac = limpiar_campo($_POST['fecha_nac']);
                $departamento = limpiar_campo($_POST['departamento']);

                $conn->beginTransaction();
                try{
                    insertar_emple_BBDD($conn, $dni, $nombre, $apellidos, $salario, $fecha_nac);
                    insertar_emple_dpto_BBDD($conn, $dni, $departamento);
                    $conn->commit();
                    echo "Empleado y asignación al departamento realizados con éxito.";
                }catch(PDOException $e){
                    $conn->rollBack();
                    echo "Error: " . $e->getMessage();

                    echo "Código de error: " . $e->getCode() . "<br>";
                    $errorInfo = $e->errorInfo;
                    if ($errorInfo) {
                        echo "SQLSTATE: " . $errorInfo[0] . "<br>";
                        echo "Código específico de la base de datos: " . $errorInfo[1]
                            . "<br>Mensaje específico de la base de datos: " . $errorInfo[2] . "<br>";

                        if ($errorInfo[1] == 1062)
                            echo "<p>El empleado ya existe.</p>";
                    }
                }
                $conn = null;
            }
        ?>
    </form>
</body>
</html>