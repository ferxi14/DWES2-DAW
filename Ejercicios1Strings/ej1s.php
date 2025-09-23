<HTML>
<HEAD><TITLE> EJ1-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php
$ip="192.18.16.204";
$partes = explode(".",$ip);
$ip_binaria="";

for ($i = 0; $i < 4; $i++) {
    $partes[$i] = sprintf("%08b", $partes[$i]);
}

$ip_binaria = implode(".", $partes);

printf("IP %s en binario es %s",$ip,$ip_binaria);
?>
</BODY>
</HTML>