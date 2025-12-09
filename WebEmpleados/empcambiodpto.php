<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>empcambiodpto</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="dni">DNI:</label>
        <select name="dni" id="dni">
            <option value="">Seleccione un DNI</option>
            <?php
                include "funciones.php";
                $conn = conexionBBDD();

                $sql = "SELECT dni, nombre FROM empleado";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $arrayEmple = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($arrayEmple as $emple) {
                    // CORREGIDO: el value debe ser el DNI, no el nombre
                    echo "<option value='" . htmlspecialchars($emple['dni']) . "'>" . htmlspecialchars($emple['dni']) . " - " . htmlspecialchars($emple['nombre']) . "</option>";
                }
            ?>
        </select>
        <br>

        <label for="cod_dpto">Departamento:</label>
        <select name="cod_dpto" id="cod_dpto" required>
            <option value="">Seleccione un nuevo departamento</option>
            <?php
                $sql = "SELECT cod_dpto, nombre_dpto FROM departamento";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $arrayDpto = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($arrayDpto as $dpto) {
                    echo "<option value='" . htmlspecialchars($dpto['cod_dpto']) . "'>" . htmlspecialchars($dpto['nombre_dpto']) . "</option>";
                }
            ?>
        </select>

        <br>
        <input type="submit" value="Asignar Departamento">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!empty($_POST['dni']) && !empty($_POST['cod_dpto'])){

                $dni = $_POST['dni'];
                $cod_dpto = $_POST['cod_dpto'];

                try {

                    $conn->beginTransaction();

                    cambiarDepartamentoEmpleado($conn, $dni, $cod_dpto);

                    $conn->commit();

                    echo "<p style='color:green;'>El departamento se asignó correctamente al empleado <b>$dni</b>.</p>";

                } catch (Exception $e) {

                    $conn->rollBack();
                    
                    echo "<p style='color:red;'><b>Error:</b> No se pudo cambiar el departamento.</p>";
                    echo "<small>Detalles internos: " . $e->getMessage() . "</small>";
                }

            } else {
                echo "<p style='color:red;'>Por favor, seleccione un empleado y un departamento.</p>";
            }
        }
    ?>
</body>
</html>
