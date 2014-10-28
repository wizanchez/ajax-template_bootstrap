<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="css/pos.css">
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="js/dhtmlgoodies_calendar.js?random=20060118"></script>
<?
set_time_limit(0);
?>    
  <form id="form1" name="form1" method="post" action="">
  <table align="center" >
  <tr>
    <td width="42">Desde:</td>
    <td width="207"><input  style="text-align:center" type="text" name="desde"   id="desde" class="" readonly="readonly"  value="<? echo date('Y-m-d');?>" />
      <input type="button" value="." onclick="displayCalendar(document.form1[0].desde,'yyyy-mm-dd',this)" class="b_calendar" /></td>
  </tr>
  <tr>
    <td>Hasta:</td>
    <td><input  style="text-align:center" type="text" name="hasta"   id="hasta" class="" readonly="readonly"  value="<? echo date('Y-m-d');?>" />
      <input type="button" value="." onclick="displayCalendar(document.form1[0].hasta,'yyyy-mm-dd',this)" class="b_calendar" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Enviar" /></td>
    </tr>
</table>       
 </form>   
 <?
  	  if($button)
	     {
	           
	         
			 $rc_pos_sales=mysql_query('select * from pos_sales where date  between "2008-12-04" and "2008-12-04"',$conn_2);
			
    $i = 0;
	$aa = 0;
    
	?><table align="center" class="KT_tngtable">
  <tr>
      <td align="center" colspan="10"><FONT color="#FF0000" size="2">VENTA</FONT></td>
      </tr>
    <tr>
    <td align="center"><strong>id</strong></td>
    <td align="center"><strong>FECHA</strong></td>
    <td align="center"><div align="center"><strong>ID CLIENTE</strong></div></td>
    <td align="center"><div align="center"><strong>SUB TOTAL</strong></div></td>
    <td align="center"><div align="center"><strong>TOTAL COSTO</strong></div></td>
    <td align="center"><div align="center"><strong>PAGADO CON</strong></div></td>
    <td align="center"><div align="center"><strong>PROD VENDIDOS</strong></div></td>
    <td align="center"><div align="center"><strong>VENDIDO POR</strong></div></td>
    <td align="center"><strong>COMENTARIO</strong></td>
    <td align="center"><strong>CAMBIO</strong></td>
  </tr>
	<?
	$j = 1;
	while($row=mysql_fetch_assoc($rc_pos_sales))
		{
		  $rc_inspossales=mysql_query('INSERT INTO jvmcompa_posweb.pos_sales (date , customer_id ,sale_sub_total ,sale_total_cost ,paid_with ,items_purchased ,sold_by ,comment ,changee ,invoicenumber ,status)
VALUES ( "'.$row['date'].'","'.$row['customer_id'].'", "'.$row['sale_sub_total'].'","'.$row['sale_total_cost'].'", "'.$row['paid_with'].'", "'.$row['items_purchased'].'", "'.$row['sold_by'].'", "'.$row['comment'].'", "'.$row['changee'].'", "'.$row['invoicenumber'].'", "'.$row['status'].'")',$conn_2);

                 echo $ultimo_id = mysql_insert_id($conn_2); 
				 if($cambi[$j] != $cambi[$j-1])
				   {
				     ?><tr><td colspan="10" align="center"><? echo 'select * from pos_sales_items where sale_id = '.$sale_id[$j-1].''; ?>
                     <table align="center" border="2" class="KT_tngtable">
  <tr>
      <td align="center" colspan="18"><FONT color="#FF0000" size="2">DETALLE DE LA VENTA (PRODUCTOS)</FONT></td>
      </tr>
    <tr>
  <tr>
    <td align="center"><strong>SALE_ID</strong></td>
    <td align="center"><strong>ITEM_ID</strong></td>
    <td align="center"><div align="center"><strong>QUANTITY_PURCHASED</strong></div></td>
    <td align="center"><div align="center"><strong>ITEM_UNIT_PRICE</strong></div></td>
    <td align="center"><div align="center"><strong>ITEM_BUY_PRICE</strong></div></td>
    <td align="center"><div align="center"><strong>ITEM_TAX_PERCENT</strong></div></td>
    <td align="center"><div align="center"><strong>ITEM_TOTAL_TAX</strong></div></td>
    <td align="center"><div align="center"><strong>ITEM_TOTAL_COST</strong></div></td>
    <td align="center"><strong>ID</strong></td>
    <td align="center"><strong>UNIT_SALE</strong></td>
    <td align="center"><strong>SALE_FRAC</strong></td>
        <td align="center"><strong>TOMADOSIS</strong></td>
    <td align="center"><strong>PRESENT TOMA</strong></td>
        <td align="center"><strong>FRECUENCIA DOSIS</strong></td>
    <td align="center"><strong>TIEMPO FCIA</strong></td>
        <td align="center"><strong>DURACION DOSIS</strong></td>
    <td align="center"><strong>TIEMPO DURACION</strong></td>
        <td align="center"><strong>QTY RECETADA</strong></td>
     </tr>
     <?
	  		$rc_pos_sales_items=mysql_query('select * from pos_sales_items where sale_id = '.$sale_id[$j-1].'',$conn_2);
			while($rowitems=mysql_fetch_assoc($rc_pos_sales_items))
			     {	
				   $rc_inspossalesitems=mysql_query('INSERT INTO jvmcompa_posweb.pos_sales_items (
sale_id ,
item_id ,
quantity_purchased ,
item_unit_price ,
item_buy_price ,
item_tax_percent ,
item_total_tax ,
item_total_cost ,
unit_sale ,
sale_frac ,
tomadosis ,
presenttoma ,
frecuenciadosis ,
tiempofcia ,
duraciondosis ,
tiempoduracion ,
qtyrecetada
)
VALUES (
"'.$ultimo_id.'", "'.$rowitems['item_id'].'", "'.$rowitems['quantity_purchased'].'", "'.$rowitems['item_unit_price'].'", "'.$rowitems['item_buy_price'].'", "'.$rowitems['item_tax_percent'].'", "'.$rowitems['item_total_tax'].'", "'.$rowitems['item_total_cost'].'", "'.$rowitems['unit_sale'].'", "'.$rowitems['sale_frac'].'", "'.$rowitems['tomadosis'].'", "'.$rowitems['presenttoma'].'", "'.$rowitems['frecuenciadosis'].'", "'.$rowitems['tiempofcia'].'", "'.$rowitems['duraciondosis'].'", "'.$rowitems['tiempoduracion'].'", "'.$rowitems['qtyrecetada'].'"
);',$conn_2);		 
	 ?>
         <tr>
    <td align="center"><strong><?=$rowitems['sale_id']?></strong></td>
    <td align="center"><strong>
      <?=$rowitems['item_id']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['quantity_purchased']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['item_unit_price']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['item_buy_price']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['item_tax_percent']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['item_total_tax']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['item_total_cost']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['id']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['unit_sale']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowitems['sale_frac']?>
    </strong></td>
        <td align="center"><strong>
          <?=$rowitems['tomadosis']?>
        </strong></td>
    <td align="center"><strong>
      <?=$rowitems['presenttoma']?>
    </strong></td>
        <td align="center"><strong>
          <?=$rowitems['frecuenciadosis']?>
        </strong></td>
    <td align="center"><strong>
      <?=$rowitems['tiempofcia']?>
    </strong></td>
        <td align="center"><strong>
          <?=$rowitems['duraciondosis']?>
        </strong></td>
    <td align="center"><strong>
      <?=$rowitems['tiempoduracion']?>
    </strong></td>
        <td align="center"><strong>
          <?=$rowitems['qtyrecetada']?>
        </strong></td>
     </tr>
     
     <? } ?>
  </table>
  <? //////////////////////////////////////////////////////  MEDIOS DE PAGOS ////////////////////////////////////////////////////////////////// ?>
  
  <? echo 'select * from pos_sales_paywith where sale_id = '.$sale_id[$j-1].''; ?>
                     <table align="center" border="2" class="KT_tngtable">
  <tr>
      <td align="center" colspan="15"><FONT color="#FF0000" size="2">DETALLE DE MEDIOS DE PAGO (PRODUCTOS)</FONT></td>
      </tr>
    <tr>
    <td align="center"><strong>ID</strong></td>
    <td align="center"><strong>SALE_ID</strong></td>
    <td align="center"><div align="center"><strong>PAYMETHOD_ID</strong></div></td>
    <td align="center"><div align="center"><strong>AMOUNT</strong></div></td>
    <td align="center"><div align="center"><strong>DOC_NUMBER</strong></div></td>
    <td align="center"><div align="center"><strong>ENTITY</strong></div></td>
    <td align="center"><div align="center"><strong>AUTHORIZED_NUM</strong></div></td>
    <td align="center"><div align="center"><strong>CANCEL</strong></div></td>
    <td align="center"><strong>CANCELDATE</strong></td>
    <td align="center"><strong>CANCELUSERID</strong></td>
    <td align="center"><strong>ENTRYDATE</strong></td>
        <td align="center"><strong>ENTRYUSERID</strong></td>
    <td align="center"><strong>LASTCHANGEDATE</strong></td>
        <td align="center"><strong>LASTCHANGEUSERID</strong></td>
    <td align="center"><strong>PAYMETHODETAIL_ID</strong></td>
        </tr>
     <?
	  		$rc_pos_sales_paywhit=mysql_query('select * from pos_sales_paywith where sale_id = '.$sale_id[$j-1].'',$conn_2);
			while($rowpayw=mysql_fetch_assoc($rc_pos_sales_paywhit))
			     {	
				  $rc_inspossalespayw=mysql_query('INSERT INTO jvmcompa_posweb.pos_sales_paywith (
sale_id ,
paymethod_id ,
amount ,
doc_number ,
entity ,
authorized_num ,
cancel ,
canceldate ,
canceluserid ,
entrydate ,
entryuserid ,
lastchangedate ,
lastchangeuserid ,
paymethoddetail_id
)
VALUES (
"'.$ultimo_id.'" , "'.$rowpayw['paymethod_id'].'" , "'.$rowpayw['amount'].'" , "'.$rowpayw['doc_number'].'" , "'.$rowpayw['entity'].'" , "'.$rowpayw['authorized_num'].'" , "'.$rowpayw['cancel'].'" , "'.$rowpayw['canceldate'].'" , "'.$rowpayw['canceluserid'].'" , "'.$rowpayw['entrydate'].'" , "'.$rowpayw['entryuserid'].'", "'.$rowpayw['lastchangedate'].'", "'.$rowpayw['lastchangeuserid'].'", "'.$rowpayw['paymethoddetail_id'].'" 
);',$conn_2);			 
	 ?>
         <tr>
    <td align="center"><strong><?=$rowpayw['id']?></strong></td>
    <td align="center"><strong>
      <?=$rowpayw['sale_id']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['paymethod_id']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['amount']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['doc_number']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['entity']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['authorized_num']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['cancel']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['canceldate']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['canceluserid']?>
    </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['entrydate']?>
    </strong></td>
        <td align="center"><strong>
          <?=$rowpayw['entryuserid']?>
        </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['lastchangedate']?>
    </strong></td>
        <td align="center"><strong>
          <?=$rowpayw['lastchangeuserid']?>
        </strong></td>
    <td align="center"><strong>
      <?=$rowpayw['paymethoddetail_id']?>
    </strong></td>
        </tr>
     
     <? } ?>
  </table>
  
  <? ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// ?>
  
</td></tr><?
				//	 $rc_pos_sales=mysql_query('select * from pos_sales_items where sale_id = '.$sale_id[$j-1].'',$conn_2);
					 //$row=mysql_fetch_assoc($rc_pos_sales);  ?>
                   <tr>

      <td align="center" colspan="10"><FONT color="#FF0000" size="2">VENTA</FONT></td>
      </tr>
    <tr>   
                      <tr>
    <td align="center"><strong>id</strong></td>
    <td align="center"><strong>FECHA</strong></td>
    <td align="center"><div align="center"><strong>ID CLIENTE</strong></div></td>
    <td align="center"><div align="center"><strong>SUB TOTAL</strong></div></td>
    <td align="center"><div align="center"><strong>TOTAL COSTO</strong></div></td>
    <td align="center"><div align="center"><strong>PAGADO CON</strong></div></td>
    <td align="center"><div align="center"><strong>PROD VENDIDOS</strong></div></td>
    <td align="center"><div align="center"><strong>VENDIDO POR</strong></div></td>
    <td align="center"><strong>COMENTARIO</strong></td>
    <td align="center"><strong>CAMBIO</strong></td>
  </tr>
				 <?  }	 				 
			     
				 ?>
                  <tr>
                    <td align="center"><?=$row['id']?></td>
                    <td align="center">  <?=$row['date']?></td>
                <td align="center"><div align="center">
                  <?=$row['customer_id']?>
                </div></td>
                <td align="center">
                  <div align="center">
                    <?=$row['sale_sub_total']?>
                  </div></td>
			    <td align="center"><div align="center">
			      <?=$row['sale_total_cost']?>
			    </div></td>
			    <td align="center"><div align="center">
			      <?=$row['paid_with']?>
			    </div></td>
                <td align="center"><div align="center">
                  <?=$row['items_purchased']?>
                </div></td>
                <td align="center"><div align="center">
                  <?=$row['sold_by']?>
                </div></td>
                <td align="center"><?=$row['comment']?></td>
                <td align="center"><?=$row['changee']?></td>
              </tr>
				 <? $cambi[$j]=$row['date'];
				    $sale_id[$j]=$row['id'];
					
					
					
					
					 
				 	  		 $j++;
		}
		 ?></table>
   <? } ?>