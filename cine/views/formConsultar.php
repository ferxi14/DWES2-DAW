<?php include_once "../controllers/gestionSesiones.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consultar Alquileres</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body>

<div class="container">

<div class="card border-success mb-3">

<div class="card-header">
    Consulta de Alquileres
</div>

<div class="card-body">

    <b>Usuario:</b>

    <?php
    echo htmlspecialchars(
        $_SESSION['usuario']['nombre']
        . ' '
        . $_SESSION['usuario']['apellidos']
    );
    ?>

    <br><br>

    <form method="post">

        Fecha Desde:

        <input
            type="date"
            name="desde"
            class="form-control"
            required>

        <br>

        Fecha Hasta:

        <input
            type="date"
            name="hasta"
            class="form-control"
            required>

        <br>

        <input
            type="submit"
            name="consultar"
            value="Consultar"
            class="btn btn-primary">

    </form>

    <br>

    <?php if(!empty($alquileres)){ ?>

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>ID Película</th>
                    <th>Título</th>
                    <th>Director</th>
                    <th>Fecha Alquiler</th>
                    <th>Fecha Límite</th>
                    <th>Fecha Devolución</th>
                    <th>Renovado</th>
                </tr>

            </thead>

            <tbody>

            <?php foreach($alquileres as $a){ ?>

                <tr>

                    <td><?= $a['idpelicula'] ?></td>

                    <td><?= htmlspecialchars($a['titulo']) ?></td>

                    <td><?= htmlspecialchars($a['director']) ?></td>

                    <td><?= $a['fecha_alquiler'] ?></td>

                    <td><?= $a['fecha_limite'] ?></td>

                    <td><?= $a['fecha_devolucion'] ?></td>

                    <td><?= $a['renovado'] ?></td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    <?php } ?>

    <a href="../controllers/inicio.php">
        Volver
    </a>

</div>

</div>

</div>

</body>
</html>