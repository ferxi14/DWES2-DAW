<?php include_once "../controllers/gestionSesiones.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Devolver / Renovar</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>

<div class="container">

<div class="card border-success">

<div class="card-header">
    Devolver / Renovar Películas
</div>

<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
    <th>Título</th>
    <th>Fecha Alquiler</th>
    <th>Fecha Límite</th>
    <th>Renovado</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>

<?php foreach($alquileres as $a){ ?>

<tr>

<td><?= htmlspecialchars($a['titulo']) ?></td>

<td><?= $a['fecha_alquiler'] ?></td>

<td><?= $a['fecha_limite'] ?></td>

<td><?= $a['renovado'] ?></td>

<td>

<form method="post">

    <input
        type="hidden"
        name="idpelicula"
        value="<?= $a['idpelicula'] ?>">

    <input
        type="hidden"
        name="renovado"
        value="<?= $a['renovado'] ?>">

    <input
        type="hidden"
        name="fecha_limite"
        value="<?= $a['fecha_limite'] ?>">

    <input
        type="submit"
        name="devolver"
        value="Devolver"
        class="btn btn-danger">

    <input
        type="submit"
        name="renovar"
        value="Renovar"
        class="btn btn-warning">

</form>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<a href="../controllers/inicio.php">
    Volver
</a>

</div>

</div>

</div>

</body>
</html>