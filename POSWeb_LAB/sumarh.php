<html>
<head>

<script language="JavaScript">
function mueveReloj(){
    momentoActual = new Date()
    hora = momentoActual.getHours()
    minuto = momentoActual.getMinutes()
    segundo = momentoActual.getSeconds()
    if(minuto < 10) minuto = '0'+minuto;
    horaImprimible = hora + " : " + minuto + " : " + segundo

    document.form_reloj.reloj.value = horaImprimible

    setTimeout("mueveReloj()",1000)
}
</script>
</head>

<body onLoad="mueveReloj()">

Vemos aquí el reloj funcionando...

<form name="form_reloj">
  <p>
  <input type="text" name="reloj" size="10">
  <br>
  <br>
  </p>
Limitar caracteres<br>
<?

$var = "una cadena comun y corriente";
//aplicamos la funcion, mostramos varios resultados
echo $var.'<br>';
echo substr($var,0,20),"<BR>";

?>
</form>

</body>
</html>


<?
 $hora=date ( "h:i:s"); //hora entrada por el usuario
    echo $hora."\n";
    list($hora1, $minut, $seg) = split('[:]', $hora);
    $hora=date("H:i:s", mktime($hora1+8, $minut, $seg));
    echo $hora."<br>";
	?>
<? echo 'victor ';  ?>

