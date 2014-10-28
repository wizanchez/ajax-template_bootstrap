<?php session_start(); 

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
include ("../includes/head.php");
$lang=new language();
?>
<form name="form1" method="post" action="">
  <? if($actionID == '') { ?>
  <div align="center">
    <select name="paymethodid" id="paymethodid" onChange="ajaxpage_2('paymethoddetailaddupd.php?actionID=showdetail&id='+document.getElementById('paymethodid').value+'','showdetail','showdetail');">
      <option value="0">Elige...</option>
      <?
	$rc_paymethod=mysql_query('select id, name from pos_pay_method where cancel = 0',$conn_2);
	while($row=mysql_fetch_assoc($rc_paymethod)) { ?>
      <option value="<?=$row['id']?>">
      <?=$row['name']?>
      </option>
      <?	 }
	?>
    </select>
  </div>
  <div id="showdetail"></div>
  <? } ?>
  

</form>
<? if($actionID=='showdetail') { echo '<br><br>';?>
<table align="center" class="KT_tngtable">
   <tr>
     <th colspan="8">
       <div align="center">
         <?=$lang->mediosp?>     
       </div></th>
     </tr>
   <tr>
     <th><?=$lang->rowID?></th>
     <th><?=$lang->medp?></th>
     <th><?=$lang->acepch?></th>
     <th><?=$lang->actinac?></th>
     <th><?=$lang->actinact?></th>
     <th><?=$lang->update?></th> 
   </tr>
     <?  $rc_paym=mysql_query('select id, name, cancel from pos_pay_methoddetail where paymethodid = '.$id.'',$conn_2);
	while($rowp=mysql_fetch_assoc($rc_paym)) { ?>
      <tr>
     <td align="center"><?=$rowp['id']?></td>
     <td><?=$rowp['name']?></td>
     <td align="center"><? if($rowp['change'] == 0) echo 'si'; else echo 'no';?></td>
     <td align="center"><? if($rowp['cancel'] == 0) { echo 'si'; $actinac = 'Inactivar'; $canc = 1; } else { echo 'no'; $actinac = 'Activar'; $canc = 0; }?></td>
      <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=actinact&ban_2=1&ban=2&id=<?=$rowp['id']?>&canc=<?=$canc?>','divpaymethod','divpaymethod'); ><?=$actinac?></a></td>
      <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmedios&ban=2&id=<?=$rowp['id']?>','addmedio','addmedio'); ><?=$lang->update?></a></td>
   </tr>
   <? } ?>
 <tr><td colspan="8"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmedios&ban=1&msgins=""','addmedio','addmedio'); ><?=$lang->addmedio?></a></td></tr>
 </table>
<? }?>