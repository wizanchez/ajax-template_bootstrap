<?php session_start(); 

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
$lang=new language();
?><head>
<script type="text/javascript" src="../js/ajax.js"></script>
<link rel="stylesheet" type="text/css" href="../css/pos.css">
<script language="JavaScript">
function Validar()
       {
        if (document.getElementById("namepay").value == '')  { alert('Digite el nombre del metodo de pago'); return false; }
		if (document.getElementById("change").value == 99)  { alert('Elija si/no acepta cambio'); return false; }
		else ajaxpage_2('paymethodaddupd.php?actionID_2=addpaymethodaddupd&ban_2=1&paymethod='+document.getElementById('namepay').value+'&ban='+document.getElementById('ban').value+'&change='+document.getElementById('change').value+'&id='+document.getElementById('id').value,'divpaymethod','divpaymethod');
       }
function Validar_1()
       {
        if (document.getElementById("namepaydetail").value == '')  { alert('Digite el nombre del detalle del metodo de pago'); return false; }
		
		else ajaxpage_2('paymethodaddupd.php?actionID_2=addmediosdetailaddupd&namepaydetail='+document.getElementById('namepaydetail').value+'&bandetail='+document.getElementById('bandetail').value,'divpaymethod','divpaymethod');
       }
	   	   
</script>	      
</head>
 <?
if($actionID_2=='addpaymethodaddupd')
   { 
     $userid= $_SESSION['session_user_id'];
     if($ban==1)
	 {    
	 if (mysql_query("INSERT INTO pos_pay_method (name, `change`, cancel, entrydate, entryuserid) VALUES ('".$paymethod."','".$change."',0,NOW(),'".$userid."')",$conn_2) === false)  $msgins ='Error Adicionando Medio de Pago';  else $msgins ='Medio de Pago Adicionado Satisfactoriamente'; 
	 }
	 if($ban==2)
	   {
	      if (mysql_query("update  pos_pay_method set name = '".$paymethod."' , `change` = '".$change."', lastchangeuserid = '".$userid."' where id = ".$id."",$conn_2) === false)  $msgins ='Error Actualizando Medio de Pago';  else $msgins ='Medio de Pago Actualizado Satisfactoriamente'; 
	   } 
     $actionID_2 = '';
   }
if($actionID_2=='actinact')
  {
         if (mysql_query("update  pos_pay_method set cancel = ".$canc.", lastchangeuserid = '".$userid."', canceldate = NOW() where id = ".$id."",$conn_2) === false)  
		 $msgins ='Error Actualizando Medio de Pago';  else $msgins ='Medio de Pago Actualizado Satisfactoriamente'; 
	
   $actionID_2 = '';
  } 
 if($actionID_2=='addmediosdetailaddupd') {   
   if($bandetail == 1)
     {
	   echo 'insert';
	 }
  if($bandetail == 2)
     {
	   echo 'update';
	 }
   
 } ?>
<form action="" method="get" onSubmit="">

 <? 
 if($ban == 0)
	  { echo $msgins;
 ?>
 <div id="divpaymethod"><table align="center" class="KT_tngtable">
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
     <th><?=$lang->detail?></th> 
   </tr>
     <?  $rc_paym=mysql_query('select id, name, `change`, cancel from pos_pay_method order by id asc',$conn_2);
	while($rowp=mysql_fetch_assoc($rc_paym)) { ?>
      <tr>
     <td align="center"><?=$rowp['id']?></td>
     <td><?=$rowp['name']?></td>
     <td align="center"><? if($rowp['change'] == 0) echo 'si'; else echo 'no';?></td>
     <td align="center"><? if($rowp['cancel'] == 0) { echo 'si'; $actinac = 'Inactivar'; $canc = 1; } else { echo 'no'; $actinac = 'Activar'; $canc = 0; }?></td>
      <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=actinact&ban_2=1&ban=2&id=<?=$rowp['id']?>&canc=<?=$canc?>','divpaymethod','divpaymethod'); ><?=$actinac?></a></td>
      <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmedios&ban=2&id=<?=$rowp['id']?>','addmedio','addmedio'); ><?=$lang->update?></a></td>
     <td align="center"><a href=javascript:void(0)  onclick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=showdetail&ban=2&id=<?=$rowp['id']?>','addmedio','addmedio'); >
       <?=$lang->detail?>
     </a></td>
      </tr>
   <? } ?>
 <tr><td colspan="8"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmedios&ban=1&msgins=""','addmedio','addmedio'); ><?=$lang->addmedio?></a></td></tr>
 </table>
  </div>
  <? echo '<br><br>';?>
 <div id="addmedio"></div><? } ?>
 <? if($actionID_2 == 'addmedios') { ?>
 <table align="center" class="KT_tngtable">
  <tr>
    <td colspan="2" align="center"><?
    if($ban==2)
	  {
	    $rc_payupd=mysql_query('select name, `change` from pos_pay_method where id = '.$id.'',$conn_2);
	    $rowupd=mysql_fetch_assoc($rc_payupd);
		$name = $rowupd['name'];
		$change = $rowupd['change'];
	  }
	?></td>
    </tr>
  <tr>
    <td><?=$lang->medp?>:</td>
    <td><input type="text" name="namepay" id="namepay" value="<?=$name?>"></td>
  </tr>
  <tr>
    <td><?=$lang->acepch?>:</td>
    <td><select name="change" id="change">
      <option value="99">Elija...</option>
      <?
	   echo '<option value="0" ';if(!(strcmp("0",$change))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
	   echo '<option value="1" ';if(!(strcmp("1",$change))){echo $selected = "selected=\"selected\"";}echo '>No</option>';	   
	  ?>
      </select>
      <input type="hidden" name="ban" id="ban" value="<?=$ban?>">
      <input type="hidden" name="id" id="id" value="<?=$id?>"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" name="button" id="button" onClick="return Validar(this);" value="Adicionar Metodo de Pago"></td>
    </tr>
    </table>
<? }
 ?>
</form>
 <? 
 if($ban_2 == 1)
	  {  ?>
 <div id="divpaymethod"><table align="center" class="KT_tngtable">
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
     <th><?=$lang->detail?></th>  
   </tr>
     <?  $rc_paym=mysql_query('select id, name, `change`, cancel from pos_pay_method order by id asc',$conn_2);
	while($rowp=mysql_fetch_assoc($rc_paym)) { ?>
      <tr>
     <td align="center"><?=$rowp['id']?></td>
     <td><?=$rowp['name']?></td>
     <td align="center"><? if($rowp['change'] == 0) echo 'si'; else echo 'no';?></td>
     <td align="center"><? if($rowp['cancel'] == 0) { echo 'si'; $actinac = 'Inactivar'; $canc = 1; } else { echo 'no'; $actinac = 'Activar'; $canc = 0; }?></td>
           <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=actinact&ban_2=1&ban=2&id=<?=$rowp['id']?>&canc=<?=$canc?>','divpaymethod','divpaymethod'); ><?=$actinac?></a></td>
      <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmedios&ban=2&id=<?=$rowp['id']?>','addmedio','addmedio'); ><?=$lang->update?></a></td>
       <td align="center"><a href=javascript:void(0)  onclick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=showdetail&ban=2&id=<?=$rowp['id']?>','addmedio','addmedio'); >
       <?=$lang->detail?>
     </a></td>
   </tr>
   <? } ?>
 <tr><td colspan="8"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmedios&ban=1&msgins=1','addmedio','addmedio'); ><?=$lang->addmedio?></a></td></tr>
 </table>  <? echo '<br><br>';?>
  <table align="center" class="KT_tngtable">
    <tr>
    <td colspan="2" align="center"><?=$msgins?></td>
    </tr>
</table>
<? } if($actionID_2=='showdetail') { ?>
<table align="center" class="KT_tngtable">
   <tr>
     <th colspan="8">
       <div align="center">
         <?  $rc_paym=mysql_query('select name from pos_pay_method where id = '.$id.'',$conn_2);
	        $rowp=mysql_fetch_assoc($rc_paym); ?>
         <? echo $lang->mediospdetail.' : '.$rowp['name']; ?>     
       </div></th>
  </tr>
   <tr>
     <th><?=$lang->rowID?></th>
     <th><?=$lang->medp?></th>
     <th><?=$lang->actinac?></th>
     <th><?=$lang->actinact?></th>
     <th><?=$lang->update?></th> 
   </tr>
     <?  $rc_paym=mysql_query('select id, name, cancel from pos_pay_methoddetail where paymethodid = '.$id.'',$conn_2);
	  $n=mysql_num_rows($rc_paym);
	if($n != NULL)
	   {
	while($rowp=mysql_fetch_assoc($rc_paym)) { ?>
      <tr>
     <td align="center"><?=$rowp['id']?></td>
     <td><?=$rowp['name']?></td>
     <td align="center"><? if($rowp['cancel'] == 0) { echo 'si'; $actinac = 'Inactivar'; $canc = 1; } else { echo 'no'; $actinac = 'Activar'; $canc = 0; }?></td>
      <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=actinact&ban_2=1&ban=2&id=<?=$rowp['id']?>&canc=<?=$canc?>','divpaymethod','divpaymethod'); ><?=$actinac?></a></td>
      <td align="center"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmedios&ban=2&id=<?=$rowp['id']?>','addmedio','addmedio'); ><?=$lang->update?></a></td>
   </tr>
   <? } ?>
 <? } else { ?>
 <tr><td colspan="5" align="center">Este medio de pago no tiene detalles</td></tr>
 <? } ?>
  <tr><td colspan="8"><a href=javascript:void(0)  onClick=javascript:ajaxpage_2('paymethodaddupd.php?actionID_2=addmediosdetail&ban=1&msgins=""&idd=<?=$id?>','addmedio','addmedio'); ><?=$lang->adddetailmed?></a></td></tr>
</table>
 <? } if($actionID_2=='addmediosdetail') { ?>
 <table align="center" class="KT_tngtable">
  <tr>
    <th colspan="2"><div align="center">
      <?=$lang->mediospdetail?>
    </div></th>
    </tr>
  <tr>
    <td><?=$lang->medp?> :</td>
    <td><?   $rc_paym=mysql_query('select id, name, cancel from pos_pay_method where id = '.$idd.'',$conn_2);
	 $rowp=mysql_fetch_assoc($rc_paym);
	echo $rowp['name'];	?></td>
  </tr>
  <tr>
    <td><?=$lang->namedetail?> :</td>
    <td><input type="text" name="namepaydetail" id="namepaydetail" value="<?=$name?>">
    <input type="hidden" name="bandetail" id="bandetail" value="<?=$ban?>" />
    <input type="hidden" name="detailid" id="detailid" value="<?=$detailid?>" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" name="button" id="button" onClick="return Validar_1(this);" value="Adicionar Detalle"></td>
    </tr>
    </table>
 <? } ?>