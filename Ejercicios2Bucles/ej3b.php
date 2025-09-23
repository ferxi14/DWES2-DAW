<HTML>
<HEAD><TITLE> EJ3B – Conversor Decimal a base 16</TITLE></HEAD>
<BODY>
<?php
$num="111";
$base="16";
$numero_base_n = "";
$digitos = "0123456789ABCDEF";
while ($num > 0) {
    $digito = $num % $base;
    $numero_base_n = $digitos[$digito] . $numero_base_n;
    $num = intdiv($num, $base);
}
printf("El numero en base %d es %s",$base,$numero_base_n);
?>
</BODY>
</HTML>