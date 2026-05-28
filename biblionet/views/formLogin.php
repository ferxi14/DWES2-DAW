<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BiblioNet</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <h1>BIBLIONET</h1>
    <div class="container">
        <div class="card border-primary mb-3" style="max-width: 30rem;">
            <div class="card-header">Login Usuario</div>
            <div class="card-body">
                <form action="" method="post" class="card-body">
                    <div class="form-group">
                        Email
                        <input type="text" name="email" placeholder="email" class="form-control"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        Clave (id socio)
                        <input type="password" name="password" placeholder="password" class="form-control">
                    </div>
                    <br>
                    <input type="submit" name="submit" value="LOGIN" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
