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

for ($i = 0; $i < 4; $i++) {
    $partes_ip[$i] = sprintf("%08b", $partes_ip[$i]);
}
$ip_binaria = implode("", $partes_ip);
$ip_binaria = substr($ip_binaria, 0, $mascara) . str_repeat("0", 32 - $mascara);
$ip_red_dec = [];
for ($i = 0; $i < 4; $i++) {
    $octeto = substr($ip_binaria, $i * 8, 8);
    $ip_red_dec[] = bindec($octeto);
}
$ip_red_final = implode(".", $ip_red_dec);
$ip_binaria = substr($ip_binaria, 0, $mascara) . str_repeat("1", 32 - $mascara);
$ip_broadcast_dec = [];
for ($i = 0; $i < 4; $i++) {
    $octeto = substr($ip_binaria, $i * 8, 8
    );
    $ip_broadcast_dec[] = bindec($octeto);
}
$ip_broadcast_final = implode(".", $ip_broadcast_dec);
$rango_inicio = $ip_red_dec;
$rango_inicio[3] += 1;
$rango_fin = $ip_broadcast_dec;
$rango_fin[3] -= 1;
$rango_inicio_final = implode(".", $rango_inicio);
$rango_fin_final = implode(".", $rango_fin);
printf("IP %s<br>Mascara %d<br>Direccion Red: %s<br>Direccion Broadcast: %s<br>Rango: %s a %s<br>",
    $ip,
    $mascara,
    $ip_red_final,
    $ip_broadcast_final,
    $rango_inicio_final,
    $rango_fin_final
);

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