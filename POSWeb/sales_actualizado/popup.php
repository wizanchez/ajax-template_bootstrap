<?php session_start(); 

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
$lang=new language();
?>
<script>
function Validar()
        {
         alert("fracsale");
		}
</script>
<?
 $rc_item=mysql_query('SELECT * FROM pos_items where id = '.$id.'',$conn_2);
 $row4=mysql_fetch_assoc($rc_item);
?>
<form action="" method="get" onSubmit="return Validar(this);">
  <table align="center">
  <tr>
    <td colspan="2" align="center">Venta por Fraccion</td>
  </tr>
  <tr>
    <td><? echo ' Articulo: '.$row4["item_name"]; ?></td>
    <td><? echo ' Pack:'.$row4["pack"];?></td>
  </tr>
  <tr>
    <td>Fracciones a vender:</td>
    <td><input name="fracsale" id="fracsale" type="text">
      <input type="hidden" name="pack" id="pack" value="<?=$row4["pack"]?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><label>
      <input type="submit" name="Aplicar" id="Aplicar" value="Aplicar">
    </label></td>
  </tr>
</table>

</form>