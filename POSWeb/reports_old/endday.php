<?php session_start(); 

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
$lang=new language();
?><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../css/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../js/dhtmlgoodies_calendar.js?random=20060118"></script>
<link rel="stylesheet" type="text/css" href="../css/pos.css">
<link rel="stylesheet" type="text/css" href="../css/print.css" media="print">
<script type="text/javascript" src="../js/ajax.js"></script>
<script src="../ajax/ajaxjs.js"></script>
<script>
function showdet(saleid)
        {
          ajaxpage_2('paywith.php?actionID=quest2&IDLoc2='+saleid+'','preg2','preg2');
		}
function Validar ()
        {
		if(document.getElementById('salesman').value == 0)
		  {
		   alert('Elija una opcion'); return false;
		  }
		  else 
		      { 
		 ajaxpage_2('endday.php?actionID=quest&tabl=cab&IDLoc='+document.getElementById('salesman').value+'&duedate='+document.getElementById('duedate').value,'preg','preg');
		      }
		}
</script>
</head>


<form name="form1" method="post" action="">
<? if(!$actionID){?>
  <table align="center">
    <tr>
      <td><?=$lang->cashier?>:</td>
      <td>
      
        <select name="salesman"  id="salesman">
          <option value="0">Elija...</option>
          <option value="99">Todos</option>
		  <?
           $rc_cash=mysql_query('SELECT pos_users.id, pos_users.first_name, pos_users.last_name  FROM pos_users, pos_sales where pos_users.id = pos_sales.sold_by  group by pos_users.id',$conn_2);
		  while($row4=mysql_fetch_assoc($rc_cash)) {
		  ?>
          <option value="<? echo $row4["id"]; ?>"><? echo $row4["first_name"].' '.$row4["last_name"]; ?></option>
          <? } ?>
        </select>      </td>
    </tr>
    <tr>
      <td><?=$lang->date?>:</td>
      <td><input  style="text-align:center" type="text" name="duedate"   id="duedate" class="" readonly="readonly"  value="<? echo date('Y-m-d');?>" />
        <input type="button" value="." onclick="displayCalendar(document.forms[0].duedate,'yyyy-mm-dd',this)" class="b_calendar" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="button" name="consultar" id="consultar" value="Consultar"  onClick="return Validar(this);" /></td>
    </tr>
    <tr>
      <td colspan="2" ></td>
    </tr>
  </table>
  <div id="preg"></div>
  <? } // if(!$actionID){}
  if($actionID=='quest')
   {   $hoy = $duedate; ?>
      <table align="center" class="KT_tngtable">
    <tr>
      <td align="center" class="KT_tngtable_2"><b><?=$cfg_company?></b></td>
                </tr>
    <tr>
      <td align="center"><b><?=$cfg_company_nit?></b></td>
                 </tr>
    <tr>
      <td align="center"><? echo $lang->streetAddress.' : '.$cfg_address?></td>
                 </tr>
    <tr>
      <td align="center"><? echo $lang->phoneNumber.' : '.$cfg_phone.' , '.$lang->fax.' : '.$cfg_fax?></td>
                 </tr>
    <tr>
      <td align="center"><? echo $lang->email.' : '.$cfg_email?></td>
                 </tr>
    <tr>
      <td align="center"><? echo $lang->website.' : '.$cfg_website?></td>
                 </tr>
    <tr>
      <td align="center"><? echo $lang->res_fact.' : '.$cfg_res_fact?></td>
                 </tr>
    <tr>
      <td align="center"><? echo $lang->desdeno.' '.$cfg_fact_desde.' '.$lang->hastano.' '.$cfg_fac_hasta?></td>
                 </tr> 
                 <tr>
                <td align="center"><? echo $lang->desdefact.' '.$row9["minid"].' '.$lang->hastano.' '.$row9["maxid"].' --- '.$hoy?></td>
                 </tr>   
               <? if($IDLoc == 99) {?>
               <tr>
                <td align="center"><div align="right"><b><?
				$rc_nodate=mysql_query('select date from pos_sales where date <= "'.$hoy.'" and  pos_sales.status = 1  group by date',$conn_2);	
				$k=0;
				while($row_1=mysql_fetch_assoc($rc_nodate))
		    		 {
						 $k++;
					 }
				 echo "Z No. ".$k;	?></b></div></td>
                 </tr> 
                 <? } ?>
  	<?  

  
  ?>
  
                </table >
	  <?
	  if($IDLoc != 99) { ?>
      <br />
                          <table align="center" class="KT_tngtable">
                          <tr>
                            <td colspan="4" align="center"><b><? echo $lang->cashreport.' ---- '.$lang->totalsShow.' '.$hoy;?></b></td>
                            </tr>
                          <tr>
                            <td bgcolor="#000000" colspan="3" bordercolor="#0A6184"></td>
                            </tr>
                          <tr>
                             <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF"><?=$lang->itemsosld?></font></strong></td>
                             <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF"><?=$lang->moneySoldBeforeTax?></font></strong></td>
                            <td bgcolor="#000000" bordercolor="#0A6184"><strong><font color="#FFFFFF"><?=$lang->moneySoldAfterTax?></font></strong></td>
                            </tr>
                          <?
                                 
                                   $rc_sales=mysql_query('select sum(items_purchased) as items_purchased, sum(sale_sub_total) as sale_sub_total, sum(sale_total_cost) as sale_total_cost from pos_sales where date = "'.$hoy.'" and  pos_sales.status = 1   and pos_sales.sold_by = '.$IDLoc.'   group by pos_sales.sold_by',$conn_2);
								
								   
								   
						
						
						
						
                                   while($row5=mysql_fetch_assoc($rc_sales)) {
                          ?>
                             <? $totalitems+=$row5['items_purchased'];
                             $totalsalesexc+=$row5['sale_sub_total'];
                             $totalslaes+=$row5['sale_total_cost'];

 							  } // while($row5=mysql_fetch_assoc($rc_sales))  ?>
   
                           <tr>
                            <td bgcolor="#CCCCCC" align="center"><?=$totalitems?></td>
                            <td bgcolor="#CCCCCC" align="center"><?=$cfg_currency_symbol.number_format($totalsalesexc,0)?></td>
                            <td bgcolor="#CCCCCC" align="center"><?=$cfg_currency_symbol.number_format($totalslaes,0)?></td>
                           
                            </tr>
                        </table>


  
				<?  } //   if($IDLoc != 99) 
	if($IDLoc == 99)  {
		  $rc_salesdat=mysql_query('select min(id) as minid ,max(id) as maxid from pos_sales where date =  "'.$hoy.'" and  pos_sales.status = 1 ',$conn_2);
				   $row9=mysql_fetch_assoc($rc_salesdat);
		   ?>
				<div id="preg2"></div>  
                    <br />
                   <table align="center" class="KT_tngtable">
                  <tr>
                    <td colspan="4" align="center"><b><? echo $lang->dailyreport;?></b></td>
                            </tr>
                          <tr>
                  <tr>
                    <td bgcolor="#000000" colspan="3" bordercolor="#0A6184"><div align="center"></div></td>
                    <td colspan="2" align="center" bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF"><?=$lang->sl?></font></strong></div></td>
                    </tr>
                  <tr>
                    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF"><?=$lang->nameemp?></font></strong></div></td>
                     <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF"><?=$lang->itemsosld?></font></strong></div></td>
                     <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF"><?=$lang->exctax?></font></strong></div></td>
                    <td bgcolor="#000000" bordercolor="#0A6184"><div align="center"><strong><font color="#FFFFFF"><?=$lang->inctax?></font></strong></div></td>
                    </tr>
 			 <?
         	   	   
			    $rc_salesall=mysql_query('SELECT  pos_users.first_name, pos_users.last_name, pos_sales.sold_by  FROM  pos_sales, pos_users WHERE pos_sales.sold_by =  pos_users.id AND pos_sales.date  = "'.$hoy.'" and  pos_sales.status = 1  group by pos_sales.sold_by',$conn_2);
				 
				 
				
				 
				while($row_2=mysql_fetch_assoc($rc_salesall)) {
				
				
				 $rc_salesall_1=mysql_query('select sum(pos_sales.sale_sub_total) as sale_sub_total, sum(pos_sales.sale_total_cost) as sale_total_cost, sum(pos_sales.items_purchased) as items_purchased 
from pos_sales, pos_sales_paywith
 where pos_sales.date = "'.$hoy.'" and pos_sales.sold_by = '.$row_2['sold_by'].' and  pos_sales.status = 1 and pos_sales_paywith.sale_id = pos_sales.id  
group by  pos_sales.sold_by',$conn_2);

				 $saletodayuser=mysql_fetch_assoc($rc_salesall_1)
				 
				
		    ?>
              <tr>
                <td bgcolor="#CCCCCC" align="center"><?=$row_2['first_name'].' '.$row_2['last_name']?></td>
                <td bgcolor="#CCCCCC" align="center"><?=$saletodayuser['items_purchased']?></td>
                <td bgcolor="#CCCCCC" align="center"><?=$cfg_currency_symbol.number_format($saletodayuser['sale_sub_total'],0)?></td>
                <td bgcolor="#CCCCCC" align="center"><?=$cfg_currency_symbol.number_format($saletodayuser['sale_total_cost'],0)?></td>
                </tr>
		  <? $totalitems+=$saletodayuser['items_purchased'];
             $totalsalesexc+=$saletodayuser['sale_sub_total'];
             $totalslaes+=$saletodayuser['sale_total_cost'];
			 } ?>
   
           <tr>
            <td bgcolor="#CCCCCC" align="center"><b><?=$lang->tot?></b></td>
            <td bgcolor="#CCCCCC" align="center"><b><?=$totalitems?></b></td>
            <td bgcolor="#CCCCCC" align="center"><b><?=$cfg_currency_symbol.$totalsalesexc?></b></td>
            <td bgcolor="#CCCCCC" align="center"><b><?=$cfg_currency_symbol.number_format($totalslaes)?></b></td>
            </tr>
        </table><br />
                
<? }  // if($actionID=='quest')
   ?>
   <table align="center" class="KT_tngtable">
  <tr>
    <td colspan="4" align="center"><b><?=$lang->paidwithsale?></b></td>
   
    </tr> <?
    $rc_paidwith=mysql_query('SELECT id,name from pos_pay_method',$conn_2);
		  $monto = 0;
		  while($row_4=mysql_fetch_assoc($rc_paidwith))
		       { 
			     $rc_saaass=mysql_query('SELECT sum(pos_sales.sale_sub_total) as monto FROM pos_sales_paywith, pos_sales WHERE pos_sales_paywith.entrydate = "'.$hoy.'" and pos_sales_paywith.sale_id = pos_sales.id 
and pos_sales_paywith.paymethod_id = '.$row_4['id'].'   and pos_sales.status  = 1',$conn_2);
				 
				 
				 
		         $row_5=mysql_fetch_assoc($rc_saaass);
				  $monto+=$row_5['monto'];
						   
	?>
     <tr>
    <td bgcolor="#000000" colspan="3" bordercolor="#0A6184" class="report"><font color="#FFFFFF"><?=$row_4['name']?></font></td>
    <td align="right" bgcolor="#CCCCCC" ><? if($row_5['monto'] == '') echo $cfg_currency_symbol.'0'; else echo $cfg_currency_symbol.number_format($row_5['monto'],0);?></td>
  
  <? 
   } ?>
   <tr><td bgcolor="#000000" colspan="3" bordercolor="#0A6184" align="center"><font color="#FFFFFF"><b><?=$lang->tot?></b></font></td><td bgcolor="#CCCCCC"><b><?=number_format($totalslaes)?></b></td></tr>
</table>
<? } // if($IDLoc == 99)   ?>
</form>