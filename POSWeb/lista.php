<?php session_start(); 

include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
$lang=new language();
?>
<?
//recibo variable
$valor = $_POST['value'];

//elimino espacios en blanco al principio y final

$cadena = trim($valor);

//conectamos con mysql y con la base de datos





//consultamos los registros coincidentes

$select = mysql_query("select * from pos_user where iten_name like ‘$cadena%'");

echo '<ul>';
//si no hay registros mostramos mensaje

if(mysql_num_rows($select) == 0)

{

echo '<li>No hay resultados</li>';

}

else

{

//montamos bucle para presentar la lista

for($a=0;$a<(mysql_num_rows($select));$a++)
{
//extraemos registro actual
$reg = mysql_fetch_array($select);
//listamos
echo '<li>'.$reg['nombre'].'</li>';
}

}

//cerramos lista

echo '</ul>';

?>