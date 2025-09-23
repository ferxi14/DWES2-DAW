<HTML>
<HEAD><TITLE> EJ1A – Arrays 20 primeros números impares</TITLE></HEAD>
<BODY>
<?php
$numImpares = array();
$indice = 0;
$suma = "";
print("<table border='1'>");
print(" <tr>
        <th>Indice</th>     <th>Valor</th>      <th>Suma</th>
        </tr>");
for ($i=1; $i < 20; $i += 2) { 
    $numImpares[$indice] = $i;
    print("<tr>");
        print("<th>".$indice."</th>");
        print("<th>".$numImpares[$indice]."</th>");
        print("<th>".(intval($suma) + $numImpares[$indice])."</th>");
    print("</tr>");
    $suma = intval($suma)  + $numImpares[$indice];
    $indice++;
}

print("</table>");
/* 
Indice Valor Suma
0       1     1 
1       3     4
2       5     9
3       7     16 */
?>
</BODY>
</HTML>