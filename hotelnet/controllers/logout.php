<?php

include_once "gestionSesiones.php";

session_destroy();
header("Location: ../index.php");
exit();

?>