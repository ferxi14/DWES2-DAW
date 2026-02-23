<?php
	session_start();
	include 'funciones/vfunciones.php';

	if (!isset($_SESSION['usuario'])) {
		header("Location: vlogout.php");
		exit();
	}

	$conn = conexionBBDD();

	$vuelos = obtenerVuelos($conn);

	if (!isset($_SESSION['carrito'])) {
    	$_SESSION['carrito'] = [];
	}

	if (isset($POST['agregar'])) {
		$numAsientos = (int)$_POST['asientos'];
		$vuelosVal = explode("|", $_POST['vuelos']);

		agregarVuelo($numAsientos, $vuelosVal);
	}

	// Calcular precio
	$totalPrice = 0;
    foreach ($_SESSION['carrito'] as $vuelo) {
        $totalPrice += $vuelo['precio_asiento'] * $vuelo['asientos'];
    }

	// Vaciar carrito
	if (isset($_POST['vaciar'])) {
		$_SESSION['carrito'] = [];
		$totalPrice = 0;
	}

	
	if (isset($_POST['compra']) && !empty($_SESSION['carrito'])) {
		procesarCompra($conn);
	}

?>

<html>
   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>RESERVAS VUELOS</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
 </head>
   
 <body>
   

    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">Reservar Vuelos</div>
		<div class="card-body">
	  	  

	<!-- INICIO DEL FORMULARIO -->
	<form action="" method="post">
	
		<B>Email Cliente:</B> <?php echo $_SESSION['usuario']['email']; ?>   <BR>
		<B>Nombre Cliente:</B>  <?php echo $_SESSION['usuario']['nombre']; ?>  <BR>
		<B>Fecha:</B> <?php $fecha = getdate(); echo "$fecha[weekday], $fecha[mday], $fecha[month], $fecha[year]"; ?>  <BR><BR>
		
		<B>Vuelos</B><select name="vuelos" class="form-control">
			<?php
                foreach ($vuelos as $vuelo) {
                    $vueloValue = $vuelo["id_vuelo"] . "|" 
					. $vuelo["origen"]. "|" 
					. $vuelo["destino"]. "|"
					. $vuelo["fechahorasalida"]. "|"
					. $vuelo["fechahorallegada"]. "|"
					. $vuelo["precio_asiento"]. "|"
					. $vuelo["asientos_disponibles"];

                    echo "<option value='" . htmlspecialchars($vueloValue) . "'>" 
                    . htmlspecialchars($vuelo["id_vuelo"]) . " | "  
					. htmlspecialchars($vuelo["origen"]) . " -> " 
                     . htmlspecialchars($vuelo['destino']) . " | IDA "
					 . htmlspecialchars($vuelo["fechahorasalida"]) . " -> VUELTA " 
					 . htmlspecialchars($vuelo["fechahorallegada"]) . " | precio: "
					 . htmlspecialchars($vuelo["precio_asiento"]) . "€ | asientos disponibles: "
					 . htmlspecialchars($vuelo["asientos_disponibles"]) ."</option>";
                }
            ?>
			</select>	
		<BR> 
		<B>Número Asientos</B><input type="number" name="asientos" size="3" min="1" max="100" value="1" class="form-control">
		<BR><BR><BR>
		<h3>Carrito</h3>
		<?php 
			if (!empty($_SESSION['carrito'])) {
				echo '<ul>';
				foreach ($_SESSION['carrito'] as $vuelo) {
					echo '<li> ' 
					. htmlspecialchars($vuelo['id_vuelo']) . " | " 
					. htmlspecialchars($vuelo['origen']) . " -> " 
					. htmlspecialchars($vuelo['destino']) . " | Asientos: " 
					. htmlspecialchars($vuelo['asientos']) . '</li>';
				}
				echo '</ul>';
			}
		?>
		<BR><BR>
		<b>Precio total: <?php echo number_format($totalPrice, 2); ?>€</b>
		<br>
		<div>
			<input type="submit" value="Agregar a Cesta" name="agregar" class="btn btn-warning disabled">
			<input type="submit" value="Comprar" name="comprar" class="btn btn-warning disabled">
			<input type="submit" value="Vaciar Cesta" name="vaciar" class="btn btn-warning disabled">
			<a href="vinicio.php">Volver a inicio</a>
		</div>		
	</form>
	
	<!-- FIN DEL FORMULARIO -->
    <a href = "vlogout.php">Cerrar Sesion</a>
  </body>
   
</html>

