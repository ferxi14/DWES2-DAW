<html>
   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page - PORTAL RESERVAS</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
 </head>
      
<body>
    

    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">Acceso Reserva Vuelos</div>
		<div class="card-body">
		
		<form id="" name="" action="index.php" method="POST" class="card-body">
		
		<div class="form-group">
			Usuario <input type="text" name="usuario" placeholder="usuario" class="form-control">
        </div>
		<div class="form-group">
			Password <input type="password" name="password" placeholder="password" class="form-control">
        </div>				
        
		<input type="submit" name="submit" value="Login" class="btn btn-warning disabled">
        </form>

		<?php
            include 'funciones/vfunciones.php';

            if (isset($_SESSION['usuario'])) {
                header("Location: index.php");
                exit();
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $usuario = limpiar_campo($_POST['usuario']);
                $clave = limpiar_campo($_POST['password']);

                $conn = conexionBBDD();

                $cliente = obtenerCliente($conn, $usuario);

                if (!empty($cliente)) {
                    if($clave != substr($cliente['dni'], 0, 4)) {
                        echo "Clave incorrecta";
                    } else {         
                        session_start();
                        $_SESSION['usuario'] = $cliente;
                        header("Location: vinicio.php");
                        exit();
                    }
                } else {
                    echo "El usuario no existe";
                }
            }
        ?>
	    </div>
    </div>
    </div>
    </div>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>