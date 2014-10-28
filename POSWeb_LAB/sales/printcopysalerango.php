<?php session_start(); ?>
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
$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,
	$cfg_theme,$lang);
$sec = new security_functions($dbf,'Sales Clerk',$lang);
$display = new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
		header ("location: ../login.php");
		exit();
}

$tablename = $cfg_tableprefix.'users';
$userLoginName = $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$userLoginLastName = $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);
$NameUser = $userLoginName.' '.$userLoginLastName;


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


$tipoVta = $_REQUEST['selected_tipovta'];
$rangoFechas = $_REQUEST['date_range'];
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];
switch($tipoVta) {
	case 1:
		$SQL = "select  id from pos_sales where pos_sales.tipo_vta = 1 AND pos_sales.status = 1";
		break;
	case 2:
		$SQL = "select DISTINCT pos_sales.id  AS id FROM pos_sales INNER JOIN pos_sales_items ON pos_sales.id = pos_sales_items.sale_id AND pos_sales.status = 1 WHERE pos_sales.tipo_vta = 2 AND pos_sales_items.tipo = 2";
		break;
	case 3:
		$SQL = "select DISTINCT pos_sales.id AS id FROM pos_sales INNER JOIN pos_sales_items ON pos_sales.id = pos_sales_items.sale_id AND pos_sales.status = 1 WHERE pos_sales.tipo_vta = 2 AND pos_sales_items.tipo = 3";
		break;
}
$a_fechas = explode(':',$rangoFechas);
$str_fechas = " AND date between '".$desde."' AND  '".$hasta."'";
$n_sql = $SQL.$str_fechas;
$resultado = mysql_query($n_sql,$conn_2);
while($row_vtas = mysql_fetch_assoc($resultado)) {
	$sale_id = $row_vtas['id'];
    $num_factura = $dbf->idToField($sales_table,'invoicenumber',$sale_id);
	$tipoReci = mysql_query("SELECT tipo_vta,customer_id,date FROM pos_sales WHERE id = $sale_id",$dbf->conn);
	$tipo_f = mysql_fetch_assoc($tipoReci);
	$cliente = $tipo_f['customer_id'];
	if($tipo_f['tipo_vta'] == '1') {
		$tipoFor = 1;
	} else {
		$tipoFp = 2;
		$tipoVtaItems = mysql_query("SELECT id FROM pos_sales_items WHERE sale_id = $sale_id and (tipo = 1 AND qtyrecetada = 0) limit 1",$dbf->conn);
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
					//$dbf->insert($field_paywith,$field_datapay,$paywith_table,false);
				}
			}
		} ?>

<table  width="10px" border="0">
    <tr>
        <td nowrap  align="center" style="font-size: 8px;line-height: 12px; font-family: Arial, serif; text-align: center" colspan="6">
        <span><strong><?= strtoupper($cfg_company) ?></span><br />
        <span><?= strtoupper($lang->nit) ?>:</strong> <?= strtoupper($cfg_company_nit) ?></span>
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
        <strong><?= strtoupper($lang->ticketnum) ?>: </strong><?= $cfg_pref_fac ?> - <?= str_pad($num_factura,6,"0",STR_PAD_LEFT); ?> TICKET COPIA <?= date('Y-m-d h:m:s') ?>
        </span><br />
        <span><strong><?= strtoupper($lang->cashier) ?>: </strong><?= strtoupper($NameUser) ?></span><br />
        <span ><strong><?= strtoupper($lang->orderBy) ?>: </strong><?= $customer_codigo ?> <?= $customer_name ?></span><br />
        <span ><strong><?= strtoupper($lang->date) ?>: </strong><?= $tipo_f['date'] ?></span><span style="float: right;"><strong><?= strtoupper($lang->hoursec) ?>_RE: </strong><?= date('h:m:s') ?></span><br />
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
            $TotalCant = 0;
			$TotalPrice = 0;
			$TotalDcto = 0;
			$Totalimpto = 0;        
		while($row = mysql_fetch_assoc($result)) {
			//ACTUALIZACION DE INVENTARIO
			//		$sql = "UPDATE pos_items SET quantity = (quantity - ".$row['quantity_purchased'].
			//			") WHERE id = '".$row['item_id']."'";
			//		mysql_query($sql);
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
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemnumber ?></td>
        <td width="3px" nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemdesc ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemprice + $itemdcto,'0','','.') ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqty,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itempdcto,'0','','.') ?>%</td>        
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemtotal,'0','','.') ?></td>
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
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoI) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
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
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($TotalDcto,'0','','.') ?>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
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
<table  width="10px" border="0">
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
        <strong><?= strtoupper($lang->ticketnum) ?>: </strong><?= $cfg_pref_fac ?> - <?= str_pad($num_factura,6,"0",STR_PAD_LEFT); ?> TICKET COPIA <?= date('Y-m-d h:m:s') ?>
        </span><br />
        <span><strong><?= strtoupper($lang->cashier) ?>: </strong><?= strtoupper($NameUser) ?></span><br />
        <span ><strong><?= strtoupper($lang->Paciente) ?>: </strong><?= $customer_codigo ?> <?= $customer_name ?></span><br />
        <span ><strong><?= strtoupper($lang->convenio) ?>: </strong><?= $dbf->idToField('pos_convenios','convenom',$convenioid) ?></span><span style="float: right;"><strong><?= strtoupper($lang->convenum) ?>: </strong><?= $dbf->idToField('pos_convenios','convenum',$convenioid) ?></span><br />
        <span ><strong><?= strtoupper($lang->date) ?>: </strong><?= $tipo_f['date'] ?></span><span style="float: right;"><strong><?= strtoupper($lang->hoursec) ?>: </strong><?= date('h:m:s') ?></span><br />
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
				//			$sql = "UPDATE pos_items SET quantity = (quantity - ".$row['quantity_purchased'].
				//				") WHERE id = '".$row['item_id']."'";
				//			mysql_query($sql);
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
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemnumber ?></td>
        <td width="3px" nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemdesc ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemprice + $itemdcto,'0','','.') ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqtyreceta,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqty,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itempdcto,'0','','.') ?>%</td>        
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemtotal,'0','','.') ?></td>
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
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoI) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoF) ?></strong>        </td>
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
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($TotalDcto,'0','','.') ?>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($descuent,'0','','.') ?>   </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;" colspan="3">
        <?= number_format(($TotalPrice - $TotalDcto - $descuent + $Totalimpto),'0','','.') ?>        
        </td>  
    </tr>
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
        <strong><?= strtoupper($lang->ticketnum) ?>: </strong><?= $cfg_pref_fac ?> - <?= str_pad($num_factura,6,"0",STR_PAD_LEFT); ?> TICKET COPIA <?= date('Y-m-d h:m:s') ?>
        </span><br />
        <span><strong><?= strtoupper($lang->cashier) ?>: </strong><?= strtoupper($NameUser) ?></span><br />
        <span ><strong><?= strtoupper($lang->Paciente) ?>: </strong><?= $customer_codigo ?> <?= $customer_name ?></span><br />
        <span ><strong><?= strtoupper($lang->convenio) ?>: </strong><?= $dbf->idToField('pos_convenios','convenom',$convenioid) ?></span><span style="float: right;"><strong><?= strtoupper($lang->convenum) ?>: </strong><?= $dbf->idToField('pos_convenios','convenum',$convenioid) ?></span><br />
        <span ><strong><?= strtoupper($lang->date) ?>: </strong><?= $tipo_f['date'] ?></span><span style="float: right;"><strong><?= strtoupper($lang->hoursec) ?>: </strong><?= date('h:m:s') ?></span><br />
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
				//			$sql = "UPDATE pos_items SET quantity = (quantity - ".$row['quantity_purchased'].
				//				") WHERE id = '".$row['item_id']."'";
				//			mysql_query($sql);
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
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemnumber ?></td>
        <td width="3px" nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: left;"><?= $itemdesc ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemprice + $itemdcto,'0','','.') ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqtyreceta,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemqty,'0','','.') ?> <?= $itemCF ?></td>
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itempdcto,'0','','.') ?>%</td>        
        <td nowrap nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;"><?= number_format($itemtotal,'0','','.') ?></td>
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
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <strong><?= strtoupper($lang->dstoI) ?></strong>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
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
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($TotalDcto,'0','','.') ?>
        </td>
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: center;" nowrap>
        <?= number_format($descuent,'0','','.') ?></td>   
        <td nowrap style="font-size: 8px;line-height: 10px; font-family: Arial, serif; text-align: right;" colspan="3">
        <?= number_format(($TotalPrice - $TotalDcto - $descuent + $Totalimpto),'0','','.') ?>        
        </td>  
    </tr>
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
<? }
$dbf->closeDBlink(); ?>

<script Language="Javascript">
$(document).ready(function () {
    printit();
});    
/*
This script is written by Eric (Webcrawl@usa.net)
For full source code, installation instructions,
100's more DHTML scripts, and Terms Of
Use, visit dynamicdrive.com
*/

function printit(){  
if (window.print) {
    window.print() ;
    //window.open('sale_ui.php?reloadFrame=1','MainFrame'); 
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