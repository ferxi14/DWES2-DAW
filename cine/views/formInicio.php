<html>
   
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>CineNet - Clientes </title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
 </head>
   
 <body>
   
    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">Menú Clientes </div>
		<div class="card-body">

		<B>Nombre Cliente:</B> <?php echo htmlspecialchars($_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellidos']); ?><BR>
		<B>Email:</B> <?php echo htmlspecialchars($_SESSION['usuario']['email']); ?><BR>
		<BR><BR>
		
		<!--Formulario con enlaces -->
		<ul>
            <li><a href="../controllers/alquilar.php">Alquilar Peliculas</a></li>
            <li><a href="../controllers/devolver.php">Devolver Peliculas</a></li>
            <li><a href="../controllers/consultar.php">Consultar Pedidos</a></li>
        </ul>
		
       <a href="../controllers/logout.php">Cerrar Sesión</a>
		
		  
	</div>  
	  
	  
     
   </body>
   
</html>