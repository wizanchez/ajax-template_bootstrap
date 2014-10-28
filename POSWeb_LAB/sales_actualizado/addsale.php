<?php session_start();
														define(RECARGAR_PANTALLA,'FALSE');
														define(FOLDER_RAIZ,'../');
			#########################################################################################################################################################
			###ENTRA A LA CONECCION
				$url_class 	= FOLDER_RAIZ.'ws_sincronizar_all.wsc.php';
					if (!file_exists($url_class)) {	echo 'No Existe Fichero { ' . $url_class . ' }<br>';} else {include ($url_class);}
			#########################################################################################################################################################
														
//include ("Formulas.class.php");
$sale_id 						= $_POST['sale_id'];
$jh 								= $_POST['jh'];
$totvta 							= $_POST[''];
$tots 							= $_POST['totvta'];
$customerid 					= $_POST['customerid'];
$devolucionid 				= $_POST['devolucionid'];
$global_sale_discount 		= $_POST['global_sale_discount'];
$sale_discount 				= $_POST['sale_discount'];
$subtotalvta 					= $_POST['subtotalvta'];
$sub_tot 						= $_POST['sub_tot'];
$taxtot 							= $_POST['taxtot'];
$imp_tot 						= $_POST['imp_tot'];
$descuentshow 				= $_POST['descuentshow'];
$descuent 						= $_POST['descuent'];
$descuentporc 				= $_POST['descuentporc'];
$saleTotalCost 				= $_POST['saleTotalCost'];
$amountpay 					= $_POST['amountpay'];
$changep 						= $_POST['changep'];
$j 									= $_POST['j'];
$cliente 							= $_POST['cliente'];
$totalvta 						= $_POST['totalvta'];
$totalItemsPurchased 		= $_POST['totalItemsPurchased'];
$totalTax 						= $_POST['totalTax'];
$finalTotal 						= $_POST['finalTotal'];
$paymethodid 				= $_POST['paymethodid'];
$change 						= $_POST['change'];
$paymethodname 			= $_POST['paymethodname'];
$amount 						= $_POST['amount'];
$doc_num						= $_POST['doc_num'];
$auth_num 					= $_POST['auth_num'];
$nummp 						= $_POST['nummp'];
$comment 						= $_POST['comment'];
$claveok 						= $_POST['claveok'];
define('DISTRI_VTA',0); ?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/print.css" media="print">
<script src="../jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
</head>
<? /* $numberit=count($_SESSION['items_in_sale']);
for($g=0;$g<$numberit;$g++)
{ 
echo $item_info_1=explode(' ',$_SESSION['items_in_sale'][$g]); echo '<br>';
$rc_cronic=mysql_query('select id, cronico, item_name from pos_items where item_number = '.$item_info_1[0].'',$conn_2);
$rowcronic=mysql_fetch_assoc($rc_cronic);
echo $rowcronic["item_name"].'  victor '.$rowcronic["cronico"]; echo '<br>';
}
$kk = 0;
if($kk == 2)
$func = 'pedircust()';
else $func = '';*/ ?>
<body >
<?php include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");
include ("../Connections/conexion.php");
$lang = new language();
$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec = new security_functions($dbf,'Sales Clerk',$lang);
$display = new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$tablename = $cfg_tableprefix.'users';
$userLoginName = $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$userLoginLastName = $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);
$NameUser = $userLoginName.' '.$userLoginLastName;
if(!$sec->isLoggedIn()) {
	header("location: ../login.php");
	exit();
}
$table_bg = $display->sale_bg;
$num_items = count($_SESSION['items_in_sale']);
$num_pay = count($_SESSION['sales_paywith']);
$customers_table = $cfg_tableprefix.'customers';
$items_table = $cfg_tableprefix.'items';
$sales_items_table = $cfg_tableprefix.'sales_items';
$sales_table = $cfg_tableprefix.'sales';
$paywith_table = $cfg_tableprefix.'sales_paywith';
//general sale info
$paid_with = isset($_POST['paid_with'])?$_POST['paid_with']:'';
$comment = isset($_POST['comment'])?$_POST['comment']:'';
$num_factura = $dbf->idToField($sales_table,'invoicenumber',$sale_id);
$tipoReci = mysql_query("SELECT tipo_vta FROM pos_sales WHERE id = $sale_id",$dbf->conn);
$tipo_f = mysql_fetch_assoc($tipoReci);
if($tipo_f['tipo_vta'] == '1') {
	$tipoFor = 1;
} else {
	$tipoFp = 2;
	$tipoVtaItems = mysql_query("SELECT id FROM pos_sales_items WHERE sale_id = $sale_id and (tipo = 1 AND qtyrecetada = 0) OR (tipo in (2,3) AND qtyrecetada = 0) limit 1",$dbf->conn);
	if(mysql_num_rows($tipoVtaItems) > 0 && DISTRI_VTA) {
		$result = mysql_query("select id from $customers_table where account_number = ".$dbf->idToField('pos_pacientes','account_number',$cliente)."",$dbf->conn);
		if(mysql_numrows($result) == 0) {
			$field_paywith = array('first_name','last_name','account_number','phone_number','email','street_address');
			$field_datapay = array($dbf->idToField('pos_pacientes','first_name',$cliente),$dbf->idToField('pos_pacientes','last_name',$cliente),$dbf->idToField('pos_pacientes','account_number',$cliente),$dbf->idToField('pos_pacientes','phone_number',$cliente),$dbf->idToField('pos_pacientes','email',$cliente),$dbf->idToField('pos_pacientes','street_address',$cliente));
			$dbf->insert($field_paywith,$field_datapay,$customers_table,false);
		}
		$tipoFor = 1;
	}
}
if($tipoFor == '1') {
	if($tipoFp == '2') {
		$reId = mysql_query("SELECT id FROM $customers_table WHERE account_number = ".$dbf->idToField('pos_pacientes','account_number',$cliente)."",$dbf->conn);
		$idcustom = mysql_fetch_assoc($reId);
		$clienteB = $idcustom['id'];
	} else {
		$clienteB = $cliente;
	}
	$customer_name = $dbf->idToField($customers_table,'first_name',$clienteB).' '.$dbf->idToField($customers_table,'last_name',$clienteB);
	$customer_codigo = $dbf->idToField($customers_table,'account_number',$clienteB);
	//INSERT A LA TABLA DE MEDIOS DE PAGO
	for($m = 0; $m < count($amount); $m++) {
		if($amount[$m] > 0) {
			if($_REQUEST['entity'.$m]) {
				$banco = $_REQUEST['entity'.$m];
			} else {
				$banco = 0;
			}
			$result = mysql_query("select id from $paywith_table where sale_id = ".$sale_id." AND paymethod_id = ".$paymethodid[$m]." AND entity = ".$banco."",$dbf->conn);
			if(mysql_numrows($result) == 0) {
				$field_paywith = array('sale_id','paymethod_id','amount','doc_number','entity','authorized_num','cancel','entrydate','entryuserid','paymethoddetail_id');
				$field_datapay = array($sale_id,$paymethodid[$m],$amount[$m],$doc_num[$m],$banco,$auth_num[$m],0,date("Y-m-d"),$_SESSION['session_user_id'],$entity[$m]);
				$dbf->insert($field_paywith,$field_datapay,$paywith_table,false);
			}
		}
	} ?>

<table  width="10px" border="0">
    <tr>
        <td nowrap  align="center" style="font-size: 8px;line-height: 12px; font-family: Arial, serif; text-align: center" colspan="6">
        <span>
        	<strong><?= strtoupper($cfg_company) ?></strong></span><br />
        <span><?= strtoupper($lang->nit) ?>: <?= strtoupper($cfg_company_nit) ?></span>
        </td>
    </tr>
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; " align="left" colspan="6">
        <span ><strong><?= strtoupper($lang->city) ?>: </strong><?= $cfg_ciudad ?> <?= nl2br($cfg_address) ?></span><br />
        
        <?php if($cfg_phone != '' or $cfg_fax != '') { ?>
    <span><strong><?= strtoupper($lang->phoneNumber) ?>: </strong><?= $cfg_phone ?> <strong><?= strtoupper($lang->fax) ?>:</strong> <?= $cfg_fax ?></span><br />
<?php } ?>
<?php if($cfg_email != '') { ?>   
    <span><strong><?= strtoupper($lang->email) ?>: </strong><?= $cfg_email ?> <strong><br /> 
<?php } ?>
<?php if($cfg_website != '') { ?>   
    <span><strong><?= strtoupper($lang->website) ?>: </strong><a href="<?= $cfg_website ?>"><?= $cfg_website ?></a><br /> 
<?php } ?>       
        <span>
        <strong><?= strtoupper($lang->ticketnum) ?>: </strong><?= $cfg_pref_fac ?> - <?= str_pad($num_factura,6,"0",STR_PAD_LEFT); ?>
        </span><br />
        <span><strong><?= strtoupper($lang->cashier) ?>: </strong><?= strtoupper($NameUser) ?></span><br />
        <span ><strong><?= strtoupper($lang->orderBy) ?>: </strong><?= $customer_codigo ?> <?= $customer_name ?></span><br />
        <span ><strong><?= strtoupper($lang->date) ?>: </strong><?= date("Y-m-d") ?></span><span style="float: right;"><strong><?= strtoupper($lang->hoursec) ?>: </strong><?= date('h:m:s') ?></span><br />
        <span ><strong>TICKET POR VENTA </strong><br />
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>             
        </td>
    </tr>
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->itemID) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->sentencelong) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->priceuni) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->qty_tit) ?></strong>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->dsto) ?></strong>        
        </td>         
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->tot) ?></strong>        
        </td>        
    </tr>
<?php //ME TRAIGO TODOS LOS PRODUCTOS DE LA FACTURA CABECERA QUE SEAN DE TIPO VTA
	$result = mysql_query("SELECT * FROM $sales_items_table  where (sale_id = $sale_id AND  tipo = 1 AND qtyrecetada = 0 AND quantity_purchased > 0) OR (sale_id = $sale_id AND  tipo = 2 AND qtyrecetada = 0 AND quantity_purchased > 0) ",$dbf->conn);
	while($row = mysql_fetch_assoc($result)) {
		//ACTUALIZACION DE INVENTARIO
		$sql = "UPDATE pos_items SET quantity = (quantity - ".$row['quantity_purchased'].") WHERE id = '".$row['item_id']."'";
		mysql_query($sql);
		$itemnumber = $dbf->idToField($items_table,'item_number',$row['item_id']);
		$itemdesc = $dbf->idToField($items_table,'shortdescription',$row['item_id']);
		$itemprice = $row['item_unit_price'];
		$itemqty = $row['quantity_purchased'];
		$itemdcto = $row['value_dcto'];
		$itempdcto = $row['porcen_dcto'];
		$itemtotal = ($itemprice * $itemqty) * (1 + ($row['item_tax_percent'] / 100));
		if($row["unit_sale"] == 1)
			$itemCF = 'C(s)';
		else
			$itemCF = 'F(s)'; ?>
    <tr>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemnumber ?></td>
        <td style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemdesc ?></td>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemprice + $itemdcto,'0','','.') ?></td>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqty,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itempdcto,'0','','.') ?>%</td>        
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemtotal,'0','','.') ?></td>
    </tr>
<?php $TotalCant += $itemqty;
		$TotalPrice += (($itemprice + $itemdcto) * $itemqty);
		$TotalDcto += ($itemdcto * $itemqty);
		$Totalimpto += ($itemprice * ($row['item_tax_percent'] / 100)) * ($itemqty);
	} ?>
    <tr>
        <td nowrap colspan="6" style="line-height: 10px;" height="10px">
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>
        </td>
    </tr>
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->tqty_tit) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->extendedPrice) ?></strong>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoI) ?></strong>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoF) ?></strong>        
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" colspan="2">
        <strong><?= strtoupper($lang->tot) ?></strong>        
        </td>  
    </tr> 
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <?= number_format($TotalCant,'0','','.') ?>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <?= number_format($TotalPrice,'0','','.') ?>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($TotalDcto,'0','','.') ?>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($descuent,'0','','.') ?>   
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;" colspan="2">
        <?= number_format(($TotalPrice - $TotalDcto - $descuent + $Totalimpto),'0','','.') ?>        
        </td>  
    </tr>
    <tr>
        <td nowrap colspan="6" style="line-height: 10px;" height="10px">
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>        
        </td>
    </tr>
    <tr>
        <td colspan="6" style="font-size: 9px;line-height: 10px; font-family: Arial, serif; " align="center" nowrap><strong><?= str_pad($lang->dettax,50,"-",STR_PAD_BOTH); ?></strong>
        </td>
    <tr>
        <td nowrap colspan="6">        
        <table width="100%">
        <tr>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->tar) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->sale) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->base_imp) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->vlriva) ?></strong></td>
        </tr>
        <? //ME TRAIGO LOS IMPUESTOS
	$result = mysql_query("SELECT item_tax_percent FROM $sales_items_table  where (sale_id = $sale_id AND  tipo = 1 AND qtyrecetada = 0) OR (sale_id = $sale_id AND  tipo = 2 AND qtyrecetada = 0) AND quantity_purchased > 0  GROUP BY item_tax_percent ",$dbf->conn);
	while($row = mysql_fetch_assoc($result)) {
		$resultB = mysql_query("SELECT sum((item_unit_price * (item_tax_percent/100)) * (quantity_purchased)) as iva, sum(item_unit_price * quantity_purchased) as base FROM $sales_items_table  where (sale_id = $sale_id AND item_tax_percent = ".trim($row['item_tax_percent'])." and tipo = 1 AND qtyrecetada = 0) OR (sale_id = $sale_id AND item_tax_percent = ".trim($row['item_tax_percent'])." and tipo = 2 AND qtyrecetada = 0)",$dbf->conn);
		while($rowb = mysql_fetch_assoc($resultB)) { ?>
        <tr>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;">
            <?= trim($row['item_tax_percent']) ?> %      
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($row['item_tax_percent']) ?>        
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($rowb['base']) ?>        
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($rowb['iva']) ?>        
            </td> 
        </tr>
        <? }
	} ?>
        </table>
        </td>
    </tr>      
    <tr>
        <td  colspan="6" style="font-size: 9px;line-height: 10px; font-family: Arial, serif; " align="center" nowrap><strong><?= str_pad(strtoupper($lang->paidWithdet),50,"-",STR_PAD_BOTH); ?></strong>
        </td>
    <tr>
    <tr>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->type) ?></strong></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->entity) ?></strong></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->extendedPrice) ?></strong></td>
    </tr>
<?php $result = mysql_query("SELECT * FROM $paywith_table WHERE sale_id = '$sale_id'",$dbf->conn);
	while($row = mysql_fetch_assoc($result)) {
		$rtype = mysql_query("SELECT name FROM pos_pay_method WHERE id = '".$row['paymethod_id']."'",$dbf->conn);
		$rowt = mysql_fetch_assoc($rtype);
		$rentity = mysql_query("SELECT pos_pay_methoddetail.name FROM pos_pay_method, pos_pay_methoddetail WHERE pos_pay_method.id = pos_pay_methoddetail.paymethodid AND pos_pay_methoddetail.id = '".$row['entity']."'",$dbf->conn);
		$rowe = mysql_fetch_assoc($rentity); ?>    
    <tr>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $rowt['name'] ?></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $rowe['name'] ?></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= $row['amount'] ?></td>        
    </tr>   

<?php $TotalFact += $row['amount'];
	} ?>
    <tr>
        <td nowrap colspan="5" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->amtChange) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
        <?= ($TotalFact - ($TotalPrice - $TotalDcto - $descuent + $Totalimpto)) ?>
        </td>
    </tr>    
</table>
<table width="300px"  border="0">
<tr>
<td>
<tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; " align="center">
        <?php if($cfg_res_fact != '') { ?>
    <span><strong><?= strtoupper($lang->res_fact) ?> </strong></span><br /><span><strong><?= strtoupper($cfg_res_fact) ?></strong></span><br />
    <span><strong><?= strtoupper($lang->desdeno) ?>: </strong><strong><?= $cfg_pref_fac ?> - <?= str_pad($cfg_fact_desde,6,"0",STR_PAD_LEFT) ?> </strong><strong><?= strtoupper($lang->hastano) ?>:</strong> <strong><?= $cfg_pref_fac ?> - <?= str_pad($cfg_fac_hasta,6,"0",STR_PAD_LEFT) ?></strong></span><br />
<?php } ?>        
        <span>
        </td>
</tr>
</table>

<strong><br />
        <hr style="border-top:2px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/> 
        <br />
<?php }
if($tipoFp == '2') {
	$result = mysql_query("SELECT id FROM $sales_items_table  where sale_id = $sale_id AND tipo = 2 AND qtyrecetada > 0 AND quantity_purchased > 0 ",$dbf->conn);
	if(mysql_num_rows($result) > 0) {
		$customer_name = $dbf->idToField('pos_pacientes','first_name',$cliente).' '.$dbf->idToField('pos_pacientes','last_name',$cliente);
		$customer_codigo = $dbf->idToField('pos_pacientes','account_number',$cliente);
		$convenioid = $dbf->idToField('pos_pacientes','convenioid',$cliente); ?>
<table  width="10px">
    <tr>
        <td nowrap align="center" style="font-size: 9px;line-height: 12px; font-family: Arial, serif; text-align: center" colspan="7">
        <span><strong> <?= strtoupper($cfg_company) ?></strong>  </span><br />
        <span><?= strtoupper($lang->nit) ?>:<?= strtoupper($cfg_company_nit) ?></span>
        </td>
    </tr>
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; " align="left" colspan="7">
        <span ><strong><?= strtoupper($lang->city) ?>: </strong><?= $cfg_ciudad ?> <?= nl2br($cfg_address) ?></span><br />
        
        <?php if($cfg_phone != '' or $cfg_fax != '') { ?>
    <span><strong><?= strtoupper($lang->phoneNumber) ?>: </strong><?= $cfg_phone ?> <strong><?= strtoupper($lang->fax) ?>:</strong> <?= $cfg_fax ?></span><br />
<?php } ?>
<?php if($cfg_email != '') { ?>   
    <span><strong><?= strtoupper($lang->email) ?>: </strong><?= $cfg_email ?> <strong><br /> 
<?php } ?>
<?php if($cfg_website != '') { ?>   
    <span><strong><?= strtoupper($lang->website) ?>: </strong><a href="<?= $cfg_website ?>"><?= $cfg_website ?></a><br /> 
<?php } ?>       
        <span>
        <strong><?= strtoupper($lang->ticketnum) ?>: </strong><?= $cfg_pref_fac ?> - <?= str_pad($num_factura,6,"0",STR_PAD_LEFT); ?>
        </span><br />
        <span><strong><?= strtoupper($lang->cashier) ?>: </strong><?= strtoupper($NameUser) ?></span><br />
        <span ><strong><?= strtoupper($lang->Paciente) ?>: </strong><?= $customer_codigo ?> <?= $customer_name ?></span><br />
        <span ><strong><?= strtoupper($lang->convenio) ?>: </strong><?= $dbf->idToField('pos_convenios','convenom',$convenioid) ?></span><span style="float: right;"><strong><?= strtoupper($lang->convenum) ?>: </strong><?= $dbf->idToField('pos_convenios','convenum',$convenioid) ?></span><br />
        <span ><strong><?= strtoupper($lang->date) ?>: </strong><?= date("Y-m-d") ?></span><span style="float: right;"><strong><?= strtoupper($lang->hoursec) ?>: </strong><?= date('h:m:s') ?></span><br />
        <span ><strong>TICKET POR DISPENSACION </strong><br />
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>             
        </td>
    </tr>
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->itemID) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->sentencelong) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->priceuni) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->qty_for) ?></strong>
                <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->qty_des) ?></strong>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->dsto) ?></strong>        
        </td>         
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->tot) ?></strong>        
        </td>        
    </tr>
<?php //ME TRAIGO TODOS LOS PRODUCTOS DE LA FACTURA CABECERA QUE SEAN DE TIPO VTA
		$result = mysql_query("SELECT * FROM $sales_items_table  where sale_id = $sale_id AND tipo = 2 AND qtyrecetada > 0 AND quantity_purchased > 0 ",$dbf->conn);
		$TotalCant = 0;
		$TotalPrice = 0;
		$TotalDcto = 0;
		$Totalimpto = 0;
		while($row = mysql_fetch_assoc($result)) {
			//ACTUALIZACION DE INVENTARIO
			$sql = "UPDATE pos_items SET quantity = (quantity - ".$row['quantity_purchased'].") WHERE id = '".$row['item_id']."'";
			mysql_query($sql);
			$itemnumber = $dbf->idToField($items_table,'item_number',$row['item_id']);
			$itemdesc = $dbf->idToField($items_table,'shortdescription',$row['item_id']);
			$itemprice = $row['item_unit_price'];
			$itemqty = $row['quantity_purchased'];
			$itemqtyreceta = $row['qtyrecetada'];
			$itemdcto = $row['value_dcto'];
			$itempdcto = $row['porcen_dcto'];
			$itemtotal = ($itemprice * $itemqty) * (1 + ($row['item_tax_percent'] / 100));
			if($row["unit_sale"] == 1)
				$itemCF = 'C(s)';
			else
				$itemCF = 'F(s)'; ?>
    <tr>
        <td  nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemnumber ?></td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemdesc ?></td>
        <td  nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemprice + $itemdcto,'0','','.') ?></td>
        <td  nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqtyreceta,'0','','.') ?> <?= $itemCF ?></td>
        <td  nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqty,'0','','.') ?> <?= $itemCF ?></td>
        <td  nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itempdcto,'0','','.') ?>%</td>        
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemtotal,'0','','.') ?></td>
    </tr>
<?php $TotalCant += $itemqty;
			$TotalPrice += (($itemprice + $itemdcto) * $itemqty);
			$TotalDcto += ($itemdcto * $itemqty);
			$Totalimpto += ($itemprice * ($row['item_tax_percent'] / 100)) * ($itemqty);
		} ?>
    <tr>
        <td nowrap colspan="7" style="line-height: 10px;" height="10px">
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>        
        </td>
    </tr>

    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->tqty_tit) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->extendedPrice) ?></strong>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoI) ?></strong>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoF) ?></strong></td>        
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" colspan="3">
        <strong><?= strtoupper($lang->tot) ?></strong>        
        </td>  
    </tr> 
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <?= number_format($TotalCant,'0','','.') ?>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <?= number_format($TotalPrice,'0','','.') ?>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($TotalDcto,'0','','.') ?>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($descuent,'0','','.') ?>   </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;" colspan="3">
        <?= number_format(($TotalPrice - $TotalDcto - $descuent + $Totalimpto),'0','','.') ?>        
        </td>  
    </tr>
    <?php
        $subtotalvta = $TotalPrice;
        $saleTotalCost = $TotalPrice - $TotalDcto - $descuent + $Totalimpto;
        $descuent = $TotalDcto;
        $descuentporc= $descuent;
    ?>    
<!--    <tr>
        <td nowrap colspan="6" style="font-size: 9px;line-height: 10px; font-family: Arial, serif; " align="center" nowrap><strong><?= str_pad($lang->dettax,50,"-",STR_PAD_BOTH); ?></strong>
        </td>
    <tr>
        <td nowrap colspan="6">        
        <table width="100%">
        <tr>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->tar) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->sale) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->base_imp) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->vlriva) ?></strong></td>
        </tr>
        <? //ME TRAIGO LOS IMPUESTOS
		$result = mysql_query("SELECT item_tax_percent FROM $sales_items_table  where sale_id = $sale_id GROUP BY item_tax_percent ",$dbf->conn);
		while($row = mysql_fetch_assoc($result)) {
			$resultB = mysql_query("SELECT sum(item_total_tax * quantity_purchased) as iva, sum(item_unit_price * quantity_purchased) as base FROM $sales_items_table  where sale_id = $sale_id AND item_tax_percent = ".trim($row['item_tax_percent'])."",$dbf->conn);
			while($rowb = mysql_fetch_assoc($resultB)) { ?>
        <tr>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;">
            <?= trim($row['item_tax_percent']) ?> %      
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($row['item_tax_percent']) ?>        
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($rowb['base']) ?>        
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($rowb['iva']) ?>        
            </td> 
        </tr>
        <? }
		} ?>
        </table>
        </td>
    </tr>      
    <tr>
        <td nowrap colspan="6" style="font-size: 9px;line-height: 10px; font-family: Arial, serif; " align="center" nowrap><strong><?= str_pad(strtoupper($lang->paidWithdet),50,"-",STR_PAD_BOTH); ?></strong>
        </td>
    <tr>
    <tr>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->type) ?></strong></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->entity) ?></strong></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->extendedPrice) ?></strong></td>
    </tr>
<?php $result = mysql_query("SELECT * FROM $paywith_table WHERE sale_id = '$sale_id'",$dbf->conn);
		while($row = mysql_fetch_assoc($result)) {
			$rtype = mysql_query("SELECT name FROM pos_pay_method WHERE id = '".$row['paymethod_id']."'",$dbf->conn);
			$rowt = mysql_fetch_assoc($rtype);
			$rentity = mysql_query("SELECT pos_pay_methoddetail.name FROM pos_pay_method, pos_pay_methoddetail WHERE pos_pay_method.id = pos_pay_methoddetail.paymethodid AND pos_pay_methoddetail.id = '".$row['entity']."'",$dbf->conn);
			$rowe = mysql_fetch_assoc($rentity); ?>    
    <tr>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $rowt['name'] ?></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $rowe['name'] ?></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= $row['amount'] ?></td>        
    </tr>   

<?php $TotalFact += $row['amount'];
		} ?>
    <tr>
        <td nowrap colspan="5" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->amtChange) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
        <?= ($TotalFact) ?>
        </td>
    </tr>    
</table>
</td>
</tr>
-->
<tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; " align="center" colspan="7">
        <?php if($cfg_res_fact != '') { ?>
    <span><strong><?= strtoupper($lang->res_fact) ?> </strong></span><br /><span><strong><?= strtoupper($cfg_res_fact) ?></strong></span><br />
    <span><strong><?= strtoupper($lang->desdeno) ?>: </strong><strong><?= $cfg_pref_fac ?> - <?= str_pad($cfg_fact_desde,6,"0",STR_PAD_LEFT) ?> </strong><strong><?= strtoupper($lang->hastano) ?>:</strong> <strong><?= $cfg_pref_fac ?> - <?= str_pad($cfg_fac_hasta,6,"0",STR_PAD_LEFT) ?></strong></span><br />
<?php } ?>        
        <span>
        </td>
</tr>
</table>
<?php }
	//IMPRESION TICKET EVENTOS
	$result = mysql_query("SELECT id FROM $sales_items_table  where sale_id = $sale_id AND tipo = 3 AND qtyrecetada > 0 AND quantity_purchased > 0 ",$dbf->conn);
	if(mysql_num_rows($result) > 0) {
		$customer_name = $dbf->idToField('pos_pacientes','first_name',$cliente).' '.$dbf->idToField('pos_pacientes','last_name',$cliente);
		$customer_codigo = $dbf->idToField('pos_pacientes','account_number',$cliente);
		$convenioid = $dbf->idToField('pos_pacientes','convenioid',$cliente); ?>

<strong><br />
        <hr style="border-top:2px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/> 
        <br />
<table  width="10px">
    <tr>
        <td nowrap align="center" style="font-size: 9px;line-height: 12px; font-family: Arial, serif; text-align: center" colspan="7">
        <span><strong><?= strtoupper($cfg_company) ?></span><br />
        <span><?= strtoupper($lang->nit) ?>:</strong> <?= strtoupper($cfg_company_nit) ?></span>
        </td>
    </tr>
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; " align="left" colspan="7">
        <span ><strong><?= strtoupper($lang->city) ?>: </strong><?= $cfg_ciudad ?> <?= nl2br($cfg_address) ?></span><br />
        
        <?php if($cfg_phone != '' or $cfg_fax != '') { ?>
    <span><strong><?= strtoupper($lang->phoneNumber) ?>: </strong><?= $cfg_phone ?> <strong><?= strtoupper($lang->fax) ?>:</strong> <?= $cfg_fax ?></span><br />
<?php } ?>
<?php if($cfg_email != '') { ?>   
    <span><strong><?= strtoupper($lang->email) ?>: </strong><?= $cfg_email ?> <strong><br /> 
<?php } ?>
<?php if($cfg_website != '') { ?>   
    <span><strong><?= strtoupper($lang->website) ?>: </strong><a href="<?= $cfg_website ?>"><?= $cfg_website ?></a><br /> 
<?php } ?>       
        <span>
        <strong><?= strtoupper($lang->ticketnum) ?>: </strong><?= $cfg_pref_fac ?> - <?= str_pad($num_factura,6,"0",STR_PAD_LEFT); ?>
        </span><br />
        <span><strong><?= strtoupper($lang->cashier) ?>: </strong><?= strtoupper($NameUser) ?></span><br />
        <span ><strong><?= strtoupper($lang->Paciente) ?>: </strong><?= $customer_codigo ?> <?= $customer_name ?></span><br />
        <span ><strong><?= strtoupper($lang->convenio) ?>: </strong><?= $dbf->idToField('pos_convenios','convenom',$convenioid) ?></span><span style="float: right;"><strong><?= strtoupper($lang->convenum) ?>: </strong><?= $dbf->idToField('pos_convenios','convenum',$convenioid) ?></span><br />
        <span ><strong><?= strtoupper($lang->date) ?>: </strong><?= date("Y-m-d") ?></span><span style="float: right;"><strong><?= strtoupper($lang->hoursec) ?>: </strong><?= date('h:m:s') ?></span><br />
        <span ><strong>TICKET POR EVENTO </strong><br />
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>             
        </td>
    </tr>
    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->itemID) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->sentencelong) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->priceuni) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->qty_for) ?></strong>
                <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->qty_des) ?></strong>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->dsto) ?></strong>        
        </td>         
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->tot) ?></strong>        
        </td>        
    </tr>
<?php //ME TRAIGO TODOS LOS PRODUCTOS DE LA FACTURA CABECERA QUE SEAN DE TIPO VTA
		$result = mysql_query("SELECT * FROM $sales_items_table  where sale_id = $sale_id AND tipo = 3 AND qtyrecetada > 0 AND quantity_purchased > 0 ",$dbf->conn);
		$TotalCant = 0;
		$TotalPrice = 0;
		$TotalDcto = 0;
		$Totalimpto = 0;
		while($row = mysql_fetch_assoc($result)) {
			//ACTUALIZACION DE INVENTARIO
			$sql = "UPDATE pos_items SET quantity = (quantity - ".$row['quantity_purchased'].") WHERE id = '".$row['item_id']."'";
			mysql_query($sql);
			$itemnumber = $dbf->idToField($items_table,'item_number',$row['item_id']);
			$itemdesc = $dbf->idToField($items_table,'shortdescription',$row['item_id']);
			$itemprice = $row['item_unit_price'];
			$itemqty = $row['quantity_purchased'];
			$itemqtyreceta = $row['qtyrecetada'];
			$itemdcto = $row['value_dcto'];
			$itempdcto = $row['porcen_dcto'];
			$itemtotal = ($itemprice * $itemqty) * (1 + ($row['item_tax_percent'] / 100));
			if($row["unit_sale"] == 1)
				$itemCF = 'C(s)';
			else
				$itemCF = 'F(s)'; ?>
    <tr>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemnumber ?></td>
        <td style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemdesc ?></td>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemprice + $itemdcto,'0','','.') ?></td>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqtyreceta,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqty,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itempdcto,'0','','.') ?>%</td>        
        <td nowrap  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemtotal,'0','','.') ?></td>
    </tr>
<?php $TotalCant += $itemqty;
			$TotalPrice += (($itemprice + $itemdcto) * $itemqty);
			$TotalDcto += ($itemdcto * $itemqty);
			$Totalimpto += ($itemprice * ($row['item_tax_percent'] / 100)) * ($itemqty);
		} ?>
    <tr>
        <td nowrap colspan="7" style="line-height: 10px;" height="10px">
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>
        <hr style="border-top:1px black dashed; border-bottom-style: none; border-left: none; border-right-style: none;"/>        
        </td>
    </tr>

    <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->tqty_tit) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <strong><?= strtoupper($lang->extendedPrice) ?></strong>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoI) ?></strong>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoF) ?></strong></td>        
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" colspan="3">
        <strong><?= strtoupper($lang->tot) ?></strong>        
        </td>  
    </tr> 
   <tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <?= number_format($TotalCant,'0','','.') ?>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;">
        <?= number_format($TotalPrice,'0','','.') ?>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($TotalDcto,'0','','.') ?>
        </td>
        <td  style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($descuent,'0','','.') ?>   </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;" colspan="3">
        <?= number_format(($TotalPrice - $TotalDcto - $descuent + $Totalimpto),'0','','.') ?>        
        </td>  
    </tr>
    <?php
        $subtotalvta = $TotalPrice;
        $saleTotalCost = $TotalPrice - $TotalDcto - $descuent + $Totalimpto;
        $descuent = $TotalDcto;
        $descuentporc= $descuent;
    ?>
 <!--    <tr>
        <td nowrap colspan="6" style="font-size: 9px;line-height: 10px; font-family: Arial, serif; " align="center" nowrap><strong><?= str_pad($lang->dettax,50,"-",STR_PAD_BOTH); ?></strong>
        </td>
    <tr>
        <td nowrap colspan="6">        
        <table width="100%">
        <tr>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->tar) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->sale) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->base_imp) ?></strong></td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->vlriva) ?></strong></td>
        </tr>
        <? //ME TRAIGO LOS IMPUESTOS
		$result = mysql_query("SELECT item_tax_percent FROM $sales_items_table  where sale_id = $sale_id GROUP BY item_tax_percent ",$dbf->conn);
		while($row = mysql_fetch_assoc($result)) {
			$resultB = mysql_query("SELECT sum(item_total_tax * quantity_purchased) as iva, sum(item_unit_price * quantity_purchased) as base FROM $sales_items_table  where sale_id = $sale_id AND item_tax_percent = ".trim($row['item_tax_percent'])."",$dbf->conn);
			while($rowb = mysql_fetch_assoc($resultB)) { ?>
        <tr>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;">
            <?= trim($row['item_tax_percent']) ?> %      
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($row['item_tax_percent']) ?>        
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($rowb['base']) ?>        
            </td>
            <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
            <?= trim($rowb['iva']) ?>        
            </td> 
        </tr>
        <? }
		} ?>
        </table>
        </td>
    </tr>      
    <tr>
        <td nowrap colspan="6" style="font-size: 9px;line-height: 10px; font-family: Arial, serif; " align="center" nowrap><strong><?= str_pad(strtoupper($lang->paidWithdet),50,"-",STR_PAD_BOTH); ?></strong>
        </td>
    <tr>
    <tr>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->type) ?></strong></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->entity) ?></strong></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->extendedPrice) ?></strong></td>
    </tr>
<?php $result = mysql_query("SELECT * FROM $paywith_table WHERE sale_id = '$sale_id'",$dbf->conn);
		while($row = mysql_fetch_assoc($result)) {
			$rtype = mysql_query("SELECT name FROM pos_pay_method WHERE id = '".$row['paymethod_id']."'",$dbf->conn);
			$rowt = mysql_fetch_assoc($rtype);
			$rentity = mysql_query("SELECT pos_pay_methoddetail.name FROM pos_pay_method, pos_pay_methoddetail WHERE pos_pay_method.id = pos_pay_methoddetail.paymethodid AND pos_pay_methoddetail.id = '".$row['entity']."'",$dbf->conn);
			$rowe = mysql_fetch_assoc($rentity); ?>    
    <tr>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $rowt['name'] ?></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $rowe['name'] ?></td>
        <td nowrap colspan="2" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= $row['amount'] ?></td>        
    </tr>   

<?php $TotalFact += $row['amount'];
		} ?>
    <tr>
        <td nowrap colspan="5" style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;"><strong><?= strtoupper($lang->amtChange) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;">
        <?= ($TotalFact) ?>
        </td>
    </tr>    
</table>
</td>
</tr>

-->
<tr>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; " align="center" colspan="7">
        <?php if($cfg_res_fact != '') { ?>
    <span><strong><?= strtoupper($lang->res_fact) ?> </strong></span><br /><span><strong><?= strtoupper($cfg_res_fact) ?></strong></span><br />
    <span><strong><?= strtoupper($lang->desdeno) ?>: </strong><strong><?= $cfg_pref_fac ?> - <?= str_pad($cfg_fact_desde,6,"0",STR_PAD_LEFT) ?> </strong><strong><?= strtoupper($lang->hastano) ?>:</strong> <strong><?= $cfg_pref_fac ?> - <?= str_pad($cfg_fac_hasta,6,"0",STR_PAD_LEFT) ?></strong></span><br />
<?php } ?>        
        <span>
        </td>
</tr>
</table>
<?php }
} ?>
<? $queryupd = 'update pos_sales set sale_sub_total = "'.$subtotalvta.'", sale_total_cost = "'.$saleTotalCost.'", changee = "'.$changep.'", status = 1, customer_id = '.$cliente.', descuentporc = '.$descuentporc.', value_discount = '.$descuent.' where id = '.$sale_id.'';
//echo $queryupd.'*************';
// echo 'update pos_sales_items set quantity_purchased = 98 where sale_id = '.$sale_id.' and item_id = '.$saleitemid.'';
$result_queryupd = mysql_query($queryupd);
//RECORRO LA VENTA PARA ENVIAR VIA WEBSERVICE EL DATO A GUARDAR.
//Formulas::conexion_erp();
$SQL = "SELECT * FROM pos_sales WHERE id = '$sale_id'";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);
$SQL = "SELECT * FROM pos_sales_items WHERE sale_id = '$sale_id'";
$result = mysql_query($SQL);
$k = 0;
while($row_detail = mysql_fetch_array($result)) {
	$SQLi = "SELECT item_number FROM pos_items WHERE id = '".$row_detail['item_id']."'";
	$resulti = mysql_query($SQLi);
	$rowi = mysql_fetch_array($resulti);
	/*$campos2['campos'][$k][0] = 'value_dcto';
	$campos2['condicion'][$k][0] = $row_detail['value_dcto'];
	$campos2['campos'][$k][1] = 'item_id';
	$campos2['condicion'][$k][1] = $row_detail['item_id'];
	$campos2['campos'][$k][2] = 'quantity_purchased';
	$campos2['condicion'][$k][2] = $row_detail['quantity_purchased'];
	$campos2['campos'][$k][3] = 'item_unit_price';
	$campos2['condicion'][$k][3] = $row_detail['item_unit_price'];
	$campos2['campos'][$k][4] = 'item_buy_price';
	$campos2['condicion'][$k][4] = $row_detail['item_buy_price'];
	$campos2['campos'][$k][5] = 'item_tax_percent';
	$campos2['condicion'][$k][5] = $row_detail['item_total_tax'];
	$campos2['campos'][$k][6] = 'item_total_tax';
	$campos2['condicion'][$k][6] = $row_detail['item_total_tax'];
	$campos2['campos'][$k][7] = 'item_total_cost';
	$campos2['condicion'][$k][7] = $row_detail['item_total_cost'];
	$campos2['campos'][$k][8] = 'unit_sale';
	$campos2['condicion'][$k][8] = $row_detail['unit_sale'];
	$campos2['campos'][$k][9] = 'sale_frac';
	$campos2['condicion'][$k][9] = $row_detail['sale_frac'];
	$campos2['campos'][$k][10] = 'tomadosis';
	$campos2['condicion'][$k][10] = $row_detail['tomadosis'];
	$campos2['campos'][$k][11] = 'presenttoma';
	$campos2['condicion'][$k][11] = $row_detail['presenttoma'];
	$campos2['campos'][$k][12] = 'frecuenciadosis';
	$campos2['condicion'][$k][12] = $row_detail['frecuenciadosis'];
	$campos2['campos'][$k][13] = 'tiempofcia';
	$campos2['condicion'][$k][13] = $row_detail['tiempofcia'];
	$campos2['campos'][$k][14] = 'duraciondosis';
	$campos2['condicion'][$k][14] = $row_detail['duraciondosis'];
	$campos2['campos'][$k][15] = 'tiempoduracion';
	$campos2['condicion'][$k][15] = $row_detail['tiempoduracion'];
	$campos2['campos'][$k][16] = 'qtyrecetada';
	$campos2['condicion'][$k][16] = $row_detail['qtyrecetada'];
	$campos2['campos'][$k][17] = 'tipo';
	$campos2['condicion'][$k][17] = $row_detail['tipo'];
	$campos2['campos'][$k][18] = 'porcen_dcto';
	$campos2['condicion'][$k][18] = $row_detail['porcen_dcto'];
	$campos2['campos'][$k][19] = 'plu_item';
	$campos2['condicion'][$k][19] = $rowi['item_number'];*/
	
	
	#########################################################################################################################
	## ACA CREO UN VECTOR PARA ENVIAR VIA WEB SERVICE HABLANDO DEL DETALLE
	$campos2[$k]['value_dcto']	 					= $row_detail['value_dcto'];
	$campos2[$k]['item_id']							= $row_detail['item_id'];
	$campos2[$k]['quantity_purchased'] 				= $row_detail['quantity_purchased'];
	$campos2[$k]['item_unit_price']					= $row_detail['item_unit_price'];
	$campos2[$k]['item_buy_price']					= $row_detail['item_buy_price'];
	$campos2[$k]['item_tax_percent']				= $row_detail['item_tax_percent'];
	$campos2[$k]['item_total_tax']					= $row_detail['item_total_tax'];
	$campos2[$k]['item_total_cost']					= $row_detail['item_total_cost'];
	$campos2[$k]['unit_sale']						= $row_detail['unit_sale'];
	$campos2[$k]['sale_frac']						= $row_detail['sale_frac'];
	$campos2[$k]['tomadosis']						= $row_detail['tomadosis'];
	$campos2[$k]['presenttoma']						= $row_detail['presenttoma'];
	$campos2[$k]['frecuenciadosis']					= $row_detail['frecuenciadosis'];
	$campos2[$k]['tiempofcia']						= $row_detail['tiempofcia'];
	$campos2[$k]['duraciondosis']					= $row_detail['duraciondosis'];
	$campos2[$k]['tiempoduracion']					= $row_detail['tiempoduracion'];
	$campos2[$k]['qtyrecetada']						= $row_detail['qtyrecetada'];
	$campos2[$k]['tipo']							= $row_detail['tipo'];
	$campos2[$k]['porcen_dcto']						= $row_detail['porcen_dcto'];
	$campos2[$k]['plu_item']						= $rowi['item_number'];
	#########################################################################################################################
	
	
	
	
	$k++;
}
$sec->closeSale();
$dbf->closeDBlink();

/*
$campos1['campos'][0] 		= 'id_vta';
$campos1['condicion'][0] 	= $row['id'];
$campos1['campos'][1] 		= 'date';
$campos1['condicion'][1] 	= $row['date'];
$campos1['campos'][2] 		= 'sale_total_cost';
$campos1['condicion'][2] 	= $row['sale_total_cost'];
$campos1['campos'][3] 		= 'sale_sub_total';
$campos1['condicion'][3] 	= $row['sale_sub_total'];
$campos1['campos'][5] 		= 'paid_with';
$campos1['condicion'][5] 	= $row['paid_with'];
$campos1['campos'][4] 		= 'sold_by';
$campos1['condicion'][4] 	= $row['sold_by'];
$campos1['campos'][6] 		= 'items_purchased';
$campos1['condicion'][6] 	= $row['items_purchased'];
$campos1['campos'][7] 		= 'comment';
$campos1['condicion'][7] 	= $row['comment'];
$campos1['campos'][8] 		= 'changee';
$campos1['condicion'][8] 	= $row['changee'];
$campos1['campos'][9] 		= 'invoicenumber';
$campos1['condicion'][9] 	= $row['invoicenumber'];
$campos1['campos'][10] 		= 'status';
$campos1['condicion'][10] 	= $row['status'];
$campos1['campos'][11] 		= 'descuentporc';
$campos1['condicion'][11] 	= $row['descuentporc'];
$campos1['campos'][12] 		= 'value_discount';
$campos1['condicion'][12] 	= $row['value_discount'];
$campos1['campos'][13] 		= 'tipo_vta';
$campos1['condicion'][13] 	= $row['tipo_vta'];
$campos1['campos'][14] 		= 'bodega_id';
$campos1['condicion'][14] 	= $row['bodega_id'];*/

	#########################################################################################################################
	## ACA CREO UN VECTOR PARA ENVIAR VIA WEB SERVICE HABLANDO DE LA CABECERA

			$campos1['id_vta']		 			= $row['id'];
			$campos1['date']	 				= $row['date'];
			$campos1['sale_total_cost'] 		= $row['sale_total_cost'];
			$campos1['sale_sub_total']	 	= $row['sale_sub_total'];
			$campos1['paid_with']	 			= $row['paid_with'];
			$campos1['sold_by']				= $row['sold_by'];
			$campos1['items_purchased'] 	= $row['items_purchased'];
			$campos1['comment'] 			= $row['comment'];
			$campos1['changee'] 				= $row['changee'];
			$campos1['invoicenumber']	 	= $row['invoicenumber'];
			$campos1['status']	 				= $row['status'];
			$campos1['descuentporc']		= $row['descuentporc'];
			$campos1['value_discount']	 	= $row['value_discount'];
			$campos1['tipo_vta']	 			= $row['tipo_vta'];
			$campos1['bodega_id']	 		= $row['bodega_id'];
	#########################################################################################################################
	
//Formulas::InsertarFormulla($customer_codigo,$row['formula'],$campos1,$campos2); 

	#########################################################################################################################
	## ENVIO LA INFORMACION NECESARIA PARA EL WEB SERVICE
	
					$campos1= json_encode($campos1);
					$campos2= json_encode($campos2);
			ws_sinronizar_all::enviar_ticket_venta(
																	$sale_id,
																	$cedula=$customer_codigo,
																	$formula_numero=$row['formula'],
																	$campos1,
																	$campos2
																	);
	#########################################################################################################################
	
?>

<script Language="Javascript">
$(document).ready(function () {
    printit();
<?php if(RECARGAR_PANTALLA=='TRUE'){?>	  
    setTimeout('reloadpage()',10000); 
<?php }?>	  
	
});    
/*
This script is written by Eric (Webcrawl@usa.net)
For full source code, installation instructions,
100's more DHTML scripts, and Terms Of
Use, visit dynamicdrive.com
*/
function reloadpage(){
    
	parent.location = '../index.php?reloadVta=1'

}
function printit(){  
if (window.print) {
    window.print() ;
} else {
    var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
    WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = "";  
}
}
</script>

<SCRIPT Language="Javascript">  
var NS = (navigator.appName == "Netscape");
var VERSION = parseInt(navigator.appVersion);
if (VERSION > 3) {
    document.write('<form><input type=button value="Print" name="Print" onClick="printit()"></form>');        
}
</script>
<script type="text/javascript" language="javascript">
<!--
function pedircust ()
       {
	    ventanaSecundaria(this);
	   }
function ventanaSecundaria (URL){
window.open("sale_ui.php?actionID=addcustomer&titulo=2&saleID=<?= $sale_id ?>","ventana1","width=600, height=270, scrollbars=yes, menubar=no, location=no, resizable=yes")
}
</script>
</body>
</html>