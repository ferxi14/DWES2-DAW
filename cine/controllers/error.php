<?php
/* Funcion para la gestion de errores */
function error($errno, $errstr, $errfile, $errline) {

    if ($errno == E_ERROR || $errno == E_USER_ERROR) {
		echo "<b>Codigo del error [$errno]:</b> $errstr 
				en la línea <b>$errline</b> 
				en el archivo <b>$errfile</b>.<br>";
        die();
    } else {
		echo $errstr;
	}
	
}
set_error_handler("error");

?>