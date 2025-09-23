<HTML>
<HEAD><TITLE> EJ2B – Conversor Decimal a base n </TITLE></HEAD>
<BODY>
<?php
$num="48";
$base="16";
$numero_base_n = "";
while ($num > 0) {
    $digito = $num % $base;
    $numero_base_n = $digito . $numero_base_n;
    $num = intdiv($num, $base);
}
printf("El numero en base %d es %s",$base,$numero_base_n);
?>
</BODY>
</HTML>