<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$num="5";
$factorial=1;
$desglose="";
for ($i=$num;$i>1;$i--) {
    $factorial*=$i;
    $desglose.=$i."x";
}
$desglose.="1";
printf("%d!=%s=%d",$num,$desglose,$factorial);
/*
Ejemplos salida:
5!=5x4x3x2x1=120
4!=4x3x2x1=24
*/
?>
</BODY>
</HTML>