<?php
	session_start();

	if (!isset($_SESSION['usuario'])) {
		header("Location: vlogout.php");
		exit();
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
		<div class="card-header">Menú Usuario </div>
		<div class="card-body">

		<B>Email Cliente:</B> <?php echo $_SESSION['usuario']['email']; ?>   <BR>
		<B>Nombre Cliente:</B>  <?php echo $_SESSION['usuario']['nombre']; ?>  <BR>
		<B>Fecha:</B> <?php $fecha = getdate(); echo "$fecha[weekday], $fecha[mday], $fecha[month], $fecha[year]"; ?>  <BR><BR>
	  
		<!--Formulario con enlaces -->
		<div>
			<input type="submit" value="Reservar Vuelos" name="reservar" onclick="window.location.href='vreservas.php'" class="btn btn-warning disabled">
			<input type="submit" value="Consultar Reserva" name="consultar" onclick="window.location.href='vconsultas.php'" class="btn btn-warning disabled">
			<input type="submit" value="Salir" name="salir" onclick="window.location.href='vlogout.php'" class="btn btn-warning disabled">
		</div>	
		
       
		
		  
	</div>  
	  
	  
     
   </body>
   
</html>


