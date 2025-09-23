<HTML>
<HEAD><TITLE> EJ5B – Tabla multiplicar con TD</TITLE></HEAD>
<BODY>
<?php
$num="8";

printf("<table border='1'>");
for ($i=1;$i<=10;$i++) {
    $resultado=$num*$i;
    printf("<tr><td>%dx%d</td><td>%d</td></tr>",$num,$i,$resultado);
}
printf("</table>");
?>
</BODY>
</HTML>