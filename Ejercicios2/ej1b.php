<HTML>
<HEAD><TITLE> EJ1B – Conversor decimal a binario</TITLE></HEAD>
<BODY>
<?php
$num="168";
$binario = "";
for ($i = 7; $i >= 0; $i--) {
    $bit = ($num & (1 << $i)) ? "1" : "0";
    $binario .= $bit;
}
printf("El numero %d en binario es %s",$num,$binario);
?>
</BODY>
</HTML>