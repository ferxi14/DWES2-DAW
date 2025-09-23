<HTML>
<HEAD><TITLE> EJ2-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php
$ip = "192.18.16.204";
$partes = explode(".", $ip);

for ($i = 0; $i < 4; $i++) {
    $num = (int)$partes[$i];
    $bin = "";
    for ($j = 7; $j >= 0; $j--) {
        $bit = ($num & (1 << $j)) ? "1" : "0";
        $bin .= $bit;
    }
    $partes[$i] = $bin;
}

$ip_binaria = implode(".", $partes);

echo "IP " . $ip . " en binario es " . $ip_binaria;
?>
</BODY>
</HTML>