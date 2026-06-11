<?php include_once "../controllers/gestionSesiones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CineNet - Alquiler Películas</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>

<h1>CineNet</h1>

<div class="container">
<div class="card border-success mb-3" style="max-width:45rem;">

    <div class="card-header">
        CineNet - Alquiler de Películas
    </div>

    <div class="card-body">

        <b>Nombre Usuario:</b>
        <?php echo htmlspecialchars($_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellidos']); ?>
        <br>

        <b>Email:</b>
        <?php echo htmlspecialchars($_SESSION['usuario']['email']); ?>
        <br>

        <b>ID Usuario:</b>
        <?php echo htmlspecialchars($_SESSION['usuario']['idusuario']); ?>
        <br><br>

        <?php if (!empty($_SESSION['ultimo_alquiler'])): ?>

            <p class="text-success">
                <b>Alquiler realizado correctamente.</b>
            </p>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Fecha Alquiler</th>
                        <th>Nº Películas</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td><?php echo $_SESSION['ultimo_alquiler']['idusuario']; ?></td>
                        <td><?php echo $_SESSION['ultimo_alquiler']['fecha_alquiler']; ?></td>
                        <td><?php echo $_SESSION['ultimo_alquiler']['cantidad']; ?></td>
                    </tr>
                </tbody>

            </table>

            <form method="post">
                <input type="submit"
                       name="volver"
                       value="Volver"
                       class="btn btn-secondary">
            </form>

        <?php else: ?>

            <form action="" method="post">

                <label>
                    <b>Película (Título - Director - Género):</b>
                </label>

                <select name="pelicula" class="form-control">

                    <?php if (empty($peliculas)): ?>

                        <option value="">
                            No hay películas disponibles
                        </option>

                    <?php else: ?>

                        <?php foreach ($peliculas as $p): ?>

                            <?php
                                $valor =
                                    $p['idpelicula'] . "|" .
                                    $p['titulo'] . "|" .
                                    $p['director'] . "|" .
                                    $p['genero'];
                            ?>

                            <option value="<?php echo htmlspecialchars($valor); ?>">

                                <?php
                                echo htmlspecialchars(
                                    $p['titulo']
                                    . ' - '
                                    . $p['director']
                                    . ' - '
                                    . $p['genero']
                                );
                                ?>

                            </option>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </select>

                <br>

                <?php if (!empty($_SESSION['cesta'])): ?>

                    <b>Cesta:</b>

                    <ul>

                        <?php foreach ($_SESSION['cesta'] as $item): ?>

                            <li>
                                <?php
                                echo htmlspecialchars(
                                    $item['titulo']
                                    . ' - '
                                    . $item['director']
                                    . ' - '
                                    . $item['genero']
                                );
                                ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                <?php else: ?>

                    <p>
                        <i>La cesta está vacía.</i>
                    </p>

                <?php endif; ?>

                <input type="submit"
                       name="agregar"
                       value="Agregar a Cesta"
                       class="btn btn-warning">

                <input type="submit"
                       name="confirmar"
                       value="Confirmar Alquiler"
                       class="btn btn-success">

                <input type="submit"
                       name="vaciar"
                       value="Vaciar Cesta"
                       class="btn btn-danger">

            </form>

        <?php endif; ?>

        <br>

        <a href="../controllers/inicio.php">Volver</a>
        |
        <a href="../controllers/logout.php">Cerrar Sesión</a>

    </div>

</div>
</div>

</body>
</html>