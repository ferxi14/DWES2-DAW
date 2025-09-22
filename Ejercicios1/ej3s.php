<HTML>
<HEAD><TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ip="192.168.16.100/16";
$partes = explode("/",$ip);
$ip_red = $partes[0];
$mascara = $partes[1];
$partes_ip = explode(".",$ip_red);
$ip_binaria="";



/* Ejemplos salida:
IP 192.168.16.100/16
Mascara 16
Direccion Red: 192.168.0.0
Direccion Broadcast: 192.168.255.255
Rango: 192.168.0.1 a 192.168.255.254
IP 192.168.16.100/21
Mascara 21
Direccion Red: 192.168.16.0
Direccion Broadcast: 192.168.23.255
Rango: 192.168.16.1 a 192.168.23.254
IP 10.33.15.100/8
Mascara 8
Direccion Red: 10.0.0.0
Direccion Broadcast: 10.255.255.255
Rango: 10.0.0.1 a 10.255.255.254
*/
?>
</BODY>
</HTML>