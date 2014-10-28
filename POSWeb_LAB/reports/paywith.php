<?php session_start(); 

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
$lang=new language();
?>
<script type="text/javascript" src="../js/ajax.js"></script>
<script src="../ajax/ajaxjs.js"></script>
<script>
function showdet(saleid)
        {
          ajaxpage_2('paywith.php?actionID=quest2&IDLoc2='+saleid+'','preg2','preg2');
		}
</script>

<form name="form1" method="post" action="">
<? if(!$actionID){?>
  <table align="center">
    <tr>
      <td>Medio de pago</td>
      <td>
      
        <select name="paywith"  id="paywith" onChange="ajaxpage_2('paywith.php?actionID=quest&tabl=cab&IDLoc='+document.getElementById('paywith').value,'preg','preg');">
          <option value="0">Elija...</option>
          <?
           $rc_tax=mysql_query('SELECT *   FROM pos_pay_method',$conn_2);
		  while($row4=mysql_fetch_assoc($rc_tax)) {
		  ?>
          <option value="<? echo $row4["id"]; ?>"><? echo $row4["name"]; ?></option>
          <? } ?>
        </select>      </td>
    </tr>
    <tr>
      <td colspan="2" ></td>
      
    </tr>
    <tr>    </tr>
  </table>
  <div id="preg"></div>
  <? } // if(!$actionID){}
  if($actionID=='quest')
   {  ?>
       <table align="center">
    <tr>
      <td>Detalle Medio de pago</td>
      <td><select name="paywithdetail" id="paywithdetail" onChange="ajaxpage_2('paywith.php?actionID=quest&tabl=det&IDLoc='+document.getElementById('paywith').value+'&IDLoc2='+document.getElementById('paywithdetail').value,'preg','preg');">
      <option value="0">Elija...</option>
	  <?
           
		   $rc_paywithdetail=mysql_query('SELECT *  FROM pos_pay_methoddetail where paymethodid = '.$IDLoc.'',$conn_2);
		 while($row2=mysql_fetch_assoc($rc_paywithdetail)) {
		  ?>
           <option value="<? echo $row2["id"]; ?>"><? echo $row2["name"]; ?></option>
          <? } ?>
      </select>
  </td>
  </tr>
  </table>
  <table align="center">
  <tr>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">ID Fila</font></strong></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">Fecha</font></strong></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">Cliente</font></strong></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">Articulos comprados</font></strong></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">Vendido Por</font></strong></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">Subtotal de Venta</font></strong></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">Total de la Venta</font></strong></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF">Detalles de la venta</font></strong></td>
    </tr>
  <?
          if($tabl=='cab') $field = 'paymethod_id';
		   if($tabl=='det') $field = 'paymethoddetail_id';
		  if($IDLoc2 != '') $IDLoc = $IDLoc2;
		  
		   $rc_printinf=mysql_query('SELECT
pos_sales.date,
pos_customers.first_name as fcust,
pos_customers.last_name as lcust,
Sum(pos_sales_items.quantity_purchased) as sumqty,
pos_users.first_name as fvend,
pos_users.last_name lvend,
pos_sales.sale_sub_total,
pos_sales.sale_total_cost,
pos_sales_paywith.id
FROM
pos_sales_paywith ,
pos_sales ,
pos_customers ,
pos_sales_items ,
pos_users
WHERE
pos_sales_paywith.'.$field.' =  '.$IDLoc.' AND
pos_sales_paywith.sale_id =  pos_sales.id AND
pos_sales.customer_id =  pos_customers.id AND
pos_sales.id =  pos_sales_items.sale_id AND
pos_sales.sold_by =  pos_users.id
GROUP BY
pos_sales.id',$conn_2);
		  while($row5=mysql_fetch_assoc($rc_printinf)) {
		  ?>
  <tr>
    <td bgcolor="#CCCCCC" align="center"><?=$row5['id']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row5['date']?></td>
    <td bgcolor="#CCCCCC"><?=$row5['fcust'].$row5['lcust']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row5['sumqty']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row5['fvend'].$row5['lvend']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row5['sale_sub_total']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row5['sale_total_cost']?></td>
    <td bgcolor="#CCCCCC" align="center"><span style="color:#FF0000"><a href="javascript:void(0)" onClick="showdet(<? echo $row5["id"]; ?>);">Detalle de la venta
          <input type="hidden" name="saleid" id="saleid" value="<?=$row5['id']?>">
    </a></span></td>
    <td>&nbsp;</td>
  </tr>
  <?  } ?>
</table>


  
<? }
  
  ?>
  <div id="preg2"></div>  
    <?
if($actionID=='quest2')
  { ?>
  
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table align="center">
  <tr>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">ID Fila</font></strong></div></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">Nombre del Articulo</font></strong></div></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">Marca</font></strong></div></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">Categoria</font></strong></div></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">Proveedor</font></strong></div></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">Cantidad Comprada</font></strong></div></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">Precio Por Unidad</font></strong></div></td>
    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF">Total de costo del articulo</font></strong></div></td>
    </tr>
  <?
    $rc_printinf=mysql_query('SELECT
pos_sales_items.id,
pos_items.item_name,
pos_brands.brand,
pos_categories.category,
pos_sales_items.quantity_purchased,
pos_sales_items.item_unit_price,
pos_sales_items.item_total_cost,
pos_suppliers.supplier
FROM
pos_sales_items ,
pos_items ,
pos_brands ,
pos_categories ,
pos_suppliers
WHERE
pos_sales_items.sale_id =  '.$IDLoc2.' AND
pos_sales_items.id =  pos_items.id AND
pos_items.brand_id =  pos_brands.id AND
pos_items.category_id =  pos_categories.id AND
pos_suppliers.id =  pos_items.supplier_id',$conn_2);
		  while($row6=mysql_fetch_assoc($rc_printinf)) {
  ?>
   <tr>
    <td bgcolor="#CCCCCC" align="center"><?=$row6['id']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row6['item_name']?></td>
    <td bgcolor="#CCCCCC"><?=$row5['fcust'].$row6['brand']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row6['category']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row6['supplier']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row6['quantity_purchased']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row6['item_unit_price']?></td>
    <td bgcolor="#CCCCCC" align="center"><?=$row6['item_total_cost']?></td>
     </tr>
  <? } ?>
</table>

  
  <? }
?>
</form>