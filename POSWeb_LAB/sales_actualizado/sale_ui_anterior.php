<?php session_start();
$userId = $_SESSION['session_user_id'];
if ($_GET['reloadFrame']) {
	header("location: sale_ui.php");
}

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
include ("Formulas.class.php");
$lang = new language();
define('DCTO_ITEM',0);
define('DISTRI_VTA',0);
//OBTENCION DE VARIABLES POR METODO POST - GET
$tipo_vta = $_REQUEST['tipo_vta'];
$itemsearch_2 = $_REQUEST['itemsearch_2'];
$item = $_REQUEST['item'];
$consitem = $_REQUEST['consitem'];
$clearfields = $_REQUEST['clearfields'];
$customer_list = $_REQUEST['customer_list'];
$inputString = $_REQUEST['inputString'];
$sale_id = $_REQUEST['sale_id'];

$can = $_REQUEST['can'];
$sale_id = $_REQUEST['sale_id'];
$pack = $_REQUEST['pack'];
$preciocompra = $_REQUEST['preciocompra'];
$pvpfin = $_REQUEST['pvpfin'];
$qty = $_REQUEST['qty'];
$saitemid = $_REQUEST['saitemid'];
$saleitemid = $_REQUEST['saleitemid'];
$tipopast = $_REQUEST['tipopast'];
$actionID = $_REQUEST['actionID'];
$order_customer_code = $_REQUEST['order_customer_code'];
$act = $_REQUEST['act'];
$saitid = $_REQUEST['saitid'];
$IDLoc = $_REQUEST['IDLoc'];
$numFormula = $_REQUEST['num_formu'];

if (!$tipo_vta) {
	$tipo_vta = 2;
}

if ($actionID == 'loadfi') {
	//
}

//updating row for an item already in sale.
if (isset($_GET['update_item'])) {
	$k = $_GET['update_item'];
	$new_price = $_POST["price$k"];
	$new_tax = $_POST["tax$k"];
	$new_quantity = $_POST["quantity$k"];
	$past = $_POST["past$k"];
	$showitem = $_POST["showitem$k"];

	$item_info = explode(' ',$_SESSION['items_in_sale'][$k]);
	$item_id = $item_info[0];
	$percentOff = $item_info[4];

	$_SESSION['items_in_sale'][$k] = $item_id.' '.$new_price.' '.$new_tax.' '.$new_quantity.
		' '.$percentOff.' '.$past.' '.$showitem;
	echo "<script>window.open('sale_ui.php','_self')</script>";
	//	header("location: sale_ui.php");

}

if (isset($_GET['discount'])) {
	$discount = $_POST['global_sale_discount'];

	if (is_numeric($discount)) {
		for ($k = 0; $k < count($_SESSION['items_in_sale']); $k++) {
			$item_info = explode(' ',$_SESSION['items_in_sale'][$k]);
			$item_id = $item_info[0];
			$new_price = $item_info[1] * (1 - ($discount / 100));
			$tax = $item_info[2];
			$quantity = $item_info[3];
			$percentOff = $item_info[4];
			$past = $item_info[5];
			$showitem = $item_info[6];
			$new_price = number_format($new_price,0);

			$_SESSION['items_in_sale'][$k] = $item_id.' '.$new_price.' '.$tax.' '.$quantity.
				' '.$percentOff.' '.$tax.' '.$past.' '.$showitem;
		}

		//		header("location: sale_ui.php?global_sale_discount=$discount");
		echo "<script>window.open('sale_ui.php?global_sale_discount=".$discount.
			"','_self')</script>";

	}
}

include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");

$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,
	$cfg_theme,$lang);
$sec = new security_functions($dbf,'Public',$lang);
$display = new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if (isset($_POST['customer'])) {
	if ($cfg_numberForBarcode == "Row ID") {
		if ($dbf->isValidCustomer($_POST['customer'])) {
			$_SESSION['current_sale_customer_id'] = $_POST['customer'];
		}
	} else //try account_number

	{
		$id = $dbf->fieldToid($cfg_tableprefix.'customers','account_number',$_POST['customer']);

		if ($dbf->isValidCustomer($id)) {
			$_SESSION['current_sale_customer_id'] = $id;

		} else {
			echo "$lang->customerWithID/$lang->accountNumber ".$_POST['customer'].', '."$lang->isNotValid";
		}
	}
}

$exten = explode(" :: ",$queryString);
//$a=$exten[0];
$a = $queryString;
if (!$actionID) {
?>
<html>
<head>
<title>JVM Point Of Sale</title>

<!--<body onload="pedirVoto()"> -->
    <script src="../jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="../jquery_ui/js/jquery-ui-1.8.7.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <link rel="stylesheet" rev="stylesheet" href="../jquery_ui/css/ui-lightness/jquery-ui-1.8.7.custom.css" media="all" />
   <!--
 <script src="../jquery_ui/js/effects.core.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="../jquery_ui/js/ui.core.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
-->
    <script>
    $(document).ready(function () {
        
		$( "#nameCustomer" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "../buscarjson.php",
                    dataType: "json",
					data: {
						tipoVta: $('#tipo_vta').val(),
						style: 'full',
						maxRows: 10,
                        a: request.term,
                        tipSearch : '2'
					},
                    success: function( data ) {
                        
						response( $.map( data, function( item ) {
							return {
								label: item.label ,
								value: item.name,
                                id: item.id,
                                cc: item.cc_num
							}
						}));
					}
				});
			},
            minLength: 2,
            select: function( event, ui ) { 
                $("#customerDoc_list").val(ui.item.cc);
                searchCustomer(ui.item.cc,4);
			}
		});        
    });    
    </script> 
<script language="JavaScript">

// linea 751


function cambpay()
{
	
	if(document.getElementById("paid_with").value  != 'Efectivo')
	{
		document.getElementById("amt_tendered").value = document.getElementById("finalTotal").value;
		document.getElementById("amt_tendered").disabled = true;
	}
	else
	{
		document.getElementById("amt_tendered").value = '';
		document.getElementById("amt_tendered").disabled = false;
	} 
}

function cambamount()
{
	var j=document.getElementById("nummp").value;
	var monto = 0;
	for( var i=0;i<j ;i++)
	{
		if(document.getElementById("amount["+i+"]").value != "")
		monto =  parseInt(monto) + parseInt(document.getElementById("amount["+i+"]").value);
		
	}
	document.getElementById("amountpay").value = monto;
	document.getElementById("changep").value =   parseInt(document.getElementById("amountpay").value) - parseInt(document.getElementById("saleTotalCost").value) ;
	
	
	
}
function checkvalue() 
{
	var m=3;
	var sumanochange = 0;
	
	if(document.getElementById("amountpay").value == ""  || document.getElementById("amountpay") == 0)
	{
		alert("Digite como minimo 1 cantidad en la seccion de medios de pago");
		return false;
	}   
	
	
	for( var i=1;i<=m ;i++)
	{
		if(document.getElementById("amount["+i+"]").value != "" && document.getElementById("doc_num["+i+"]").value == "" )
		{
			alert("Digite # documento para el metodo de pago ("+document.getElementById("paymethodname["+i+"]").value+")"); return false;
		}		  
		if(document.getElementById("amount["+i+"]").value != "" && document.getElementById("doc_num["+i+"]").value != "" && document.getElementById("entity["+i+"]").value == 0 )
		{
			alert("Elija una entidad  para el metodo de pago ("+document.getElementById("paymethodname["+i+"]").value+")"); return false;
		}		 
		
		if(document.getElementById("amount["+i+"]").value != "" && document.getElementById("doc_num["+i+"]").value != "" && document.getElementById("entity["+i+"]").value != 0  && document.getElementById("auth_num["+i+"]").value == "" )
		{
			alert("Digite un numero de autorizacion para el metodo de pago ("+document.getElementById("paymethodname["+i+"]").value+")"); return false;
		}	
		if(document.getElementById("change["+i+"]").value != 0 && document.getElementById("amount["+i+"]").value != "")	
		{
			sumanochange =  parseInt(sumanochange) + parseInt(document.getElementById("amount["+i+"]").value);
			
		} 	
		
	} 
	
	if(parseInt(sumanochange) != 0 && (parseInt(sumanochange) > parseInt(document.getElementById("saleTotalCost").value)))
	{
		alert("La sumatoria de los medios de pago no puede ser mayor al total de la venta");
		return false;
	}	
	
	
	if(document.getElementById("amountpay").value != "")
	{
		if(parseInt(document.getElementById("changep").value) <  0)
		{
			alert("La suma de los montos es menor al total de la venta");
			return false;
		}
		
		
	}
	
	if(document.getElementById("claveok").value == 0 && document.getElementById("devolucionid").value == 1)
	{
		alert('No puede hacer devoluciones, Este procedimiento requiere autorizacion del administrador!!!!'); document.getElementById("devolucion").checked == false;  return false;
	}  
    
    return true;
}  

function cancelsale()
{
	document.getElementById("item_search2").value = '';
	document.getElementById("item_search2").disabled = true;
	document.getElementById("item").value = '';
	document.getElementById("item").disabled = true;
	document.getElementById("inputString").value = '';
	document.getElementById("inputString").disabled = true;
	document.getElementById("consitem").disabled = true;	
	document.getElementById("addsale").disabled = true;	
    
        document.getElementById("stvta").value = '0';
		document.getElementById("sub_tot").value = '0';
        document.getElementById("str_sub_tot").innerHTML = '0' ;
        document.getElementById("saleTotalCost").value = '0';
        document.getElementById("str_saleTotalCost").innerHTML ='0';  
        document.getElementById('taxtot').value = '0';
        document.getElementById('imp_tot').value = '0';      
	
	ajaxpage_2('sale_ui.php?can=2&sale_id='+document.getElementById("sale_id").value,'itemssales','itemssales');
}

function cancelitemsale(k)
{

$.post("sale_ui.php", { 
    customer_list: document.getElementById('customer_list').value,
    tipo_vta: document.getElementById('tipo_vta').value,
    actionID: "ListItemTable",
    num_formu : document.getElementById('num_formu').value,
    can: "1",
    sale_id: document.getElementById("sale_id").value,
    saleitemid: document.getElementById("item_id["+k+"]").value,
    saitid: document.getElementById("idpossalesitems["+k+"]").value,
    qty: document.getElementById("qty["+k+"]").value 
    }, 
    function(data){
updateitemsale(k);    
    }
);
	
	//ReCalcSubTotal(document.getElementById("sale_id").value,document.getElementById("idpossalesitems["+k+"]").value,3);
    
    
    	
//	ajaxpage_2('sale_ui.php?customer_list='+document.getElementById('customer_list').value+'&tipo_vta='+document.getElementById('tipo_vta').value+'&actionID=ListItemTable&can=1&sale_id='+document.getElementById("sale_id").value+'&saleitemid='+document.getElementById("item_id["+k+"]").value+'&saitid='+document.getElementById("idpossalesitems["+k+"]").value+'&qty='+document.getElementById("qty["+k+"]").value,'itemssales','itemssales');
	
	
	
	
}

function cambioDispe(k,opcion){
    var tipoDisp;
    if(opcion == '1'){
            tipoDisp = 1;
    }
    if(opcion == '2'){
            tipoDisp = 3;
    }
    if(opcion == '3'){
            tipoDisp = 2;
    }

formu = document.getElementById('orden['+k+']').value;
validQty(formu,k);
qtyDespa = document.getElementById('qty['+k+']').value;
$.post("sale_ui.php", { 
    customer_list: document.getElementById('customer_list').value, 
    tipo_vta: document.getElementById('tipo_vta').value ,
    actionID: "modifiItem",
    num_formu : document.getElementById('num_formu').value,
    sale_id: document.getElementById("sale_id").value,
    saleitemid: document.getElementById("item_id["+k+"]").value,
    saitemid: document.getElementById("idpossalesitems["+k+"]").value,
    qtyreceta: formu,
    qtyDespa: qtyDespa,
    tipoDisp: tipoDisp }, 
    function(data){
        $.post("sale_ui.php", { 
            customer_list: document.getElementById('customer_list').value, 
            tipo_vta: document.getElementById('tipo_vta').value ,
            num_formu : document.getElementById('num_formu').value,
            actionID: "ListItemTable"
            }, 
            function(data){
                document.getElementById('itemssales').innerHTML = data;
                updateitemsale(k);
            }
        ); 
    }
);
}

function actuaList(k){
$.post("sale_ui.php", { 
    customer_list: document.getElementById('customer_list').value, 
    tipo_vta: document.getElementById('tipo_vta').value ,
    actionID: "ListItemTable",
    num_formu : document.getElementById('num_formu').value
    }, 
    function(data){ 
        document.getElementById('itemssales').innerHTML = data;
        $('#itemssales').html(data);
        var contl = document.getElementById('totLin').value;
            var stvta = 0;
            var sub_tot = 0;
            var saletotalcost = 0;
            var totalTax = 0;        
        if(contl > 0){
            for(var i=0; i<contl; i++){
                if(parseFloat(document.getElementById('ItemOn'+i).value) == '1' && parseFloat(document.getElementById('orden['+i+']').value) == 0){
                    
                    var pricedcto = document.getElementById('pricedcto'+i).value.replace(',','');
                    var qty = document.getElementById('qty['+i+']').value.replace(',','');
                    var valimp = document.getElementById('valimp'+i).value.replace(',','');
                    stvta += (parseFloat(pricedcto) * parseFloat(qty));
                    sub_tot += (parseFloat(pricedcto) * parseFloat(qty));
                    saletotalcost += ((parseFloat(pricedcto) + parseFloat(valimp)) * parseFloat(qty));
                    totalTax += (parseFloat(valimp) * parseFloat(qty));                  
                }
            }
            
        }
        document.getElementById("stvta").value = stvta;
		document.getElementById("sub_tot").value = sub_tot;
        document.getElementById("str_sub_tot").innerHTML = document.getElementById("sub_tot").value ;
        document.getElementById("saleTotalCost").value = saletotalcost;
        document.getElementById("str_saleTotalCost").innerHTML = document.getElementById("saleTotalCost").value;  
        document.getElementById('taxtot').value = totalTax;
        document.getElementById('imp_tot').value = totalTax; 
             
    });
    
}

function updateitemsale(k)
{
	if(document.getElementById('itipovta'+k).value == '2'){
	   var formu = document.getElementById('orden['+k+']').value;
        var d = 0;
    }else{
        var formu = 0;
        var d = 1;
    }
    

$.post("sale_ui.php", { 
    customer_list: document.getElementById('customer_list').value, 
    tipo_vta: document.getElementById('tipo_vta').value ,
    num_formu : document.getElementById('num_formu').value,
    actionID: "ListItemTable",
    can : "1",
    sale_id: document.getElementById("sale_id").value,
    saleitemid: document.getElementById("item_id["+k+"]").value,
    saitemid: document.getElementById("idpossalesitems["+k+"]").value,
    qty: document.getElementById("qty["+k+"]").value,
    tipopast: document.getElementById("past["+k+"]").value,
    pack: document.getElementById("pack["+k+"]").value,
    pvpfin: document.getElementById("pvpfin["+k+"]").value,
    preciocompra: document.getElementById("preciocompra["+k+"]").value,
    qtyreceta: formu 
    }, 
    function(data){ 
        document.getElementById('itemssales').innerHTML = data;
        $('#itemssales').html(data);
        var contl = document.getElementById('totLin').value;
            var stvta = 0;
            var sub_tot = 0;
            var saletotalcost = 0;
            var totalTax = 0;        
        if(contl > 0){
            for(var i=0; i<contl; i++){
                if(parseFloat(document.getElementById('ItemOn'+i).value) == '1' && parseFloat(document.getElementById('orden['+i+']').value) == 0){
                    
                    var pricedcto = document.getElementById('pricedcto'+i).value.replace(',','');
                    var qty = document.getElementById('qty['+i+']').value.replace(',','');
                    var valimp = document.getElementById('valimp'+i).value.replace(',','');
                    stvta += (parseFloat(pricedcto) * parseFloat(qty));
                    sub_tot += (parseFloat(pricedcto) * parseFloat(qty));
                    saletotalcost += ((parseFloat(pricedcto) + parseFloat(valimp)) * parseFloat(qty));
                    totalTax += (parseFloat(valimp) * parseFloat(qty));                  
                }
            }
            
        }
        document.getElementById("stvta").value = stvta;
		document.getElementById("sub_tot").value = sub_tot;
        document.getElementById("str_sub_tot").innerHTML = document.getElementById("sub_tot").value ;
        document.getElementById("saleTotalCost").value = saletotalcost;
        document.getElementById("str_saleTotalCost").innerHTML = document.getElementById("saleTotalCost").value;  
        document.getElementById('taxtot').value = totalTax;
        document.getElementById('imp_tot').value = totalTax;
        actuaList(k);      
    });

}

function validFormulada(k){
//modifiItem
formu = document.getElementById('orden['+k+']').value;
validQty(formu,k);
qtyDespa = document.getElementById('qty['+k+']').value;
$.post("sale_ui.php", { 
    customer_list: document.getElementById('customer_list').value, 
    tipo_vta: document.getElementById('tipo_vta').value ,
    num_formu : document.getElementById('num_formu').value,
    actionID: "modifiItem",
    sale_id: document.getElementById("sale_id").value,
    saleitemid: document.getElementById("item_id["+k+"]").value,
    saitemid: document.getElementById("idpossalesitems["+k+"]").value,
    qtyreceta: formu,
    qtyDespa: qtyDespa }, 
    function(data){
        $.post("sale_ui.php", { 
            customer_list: document.getElementById('customer_list').value, 
            tipo_vta: document.getElementById('tipo_vta').value ,
            num_formu : document.getElementById('num_formu').value,
            actionID: "ListItemTable"
            }, 
            function(data){
                document.getElementById('itemssales').innerHTML = data;
                updateitemsale(k);
            }
        ); 
    }
);    
}

function pedirclave()
{
	if(document.getElementById("devolucion").checked == true)
	{
		document.getElementById("devolucionid").value=1;
		window.open("sale_ui.php?actionID=pedirclave","ventana1","width=300, height=150, scrollbars=yes, menubar=no, location=no, resizable=yes")
	} 
	else alert('pailas');
}		

function ClearField()
{
	document.getElementById("item_search2").value = '';
	document.getElementById("item").value = '';
	document.getElementById("inputString").value = '';
}

function asig()
{
	document.getElementById("cliente").value =  document.getElementById("customer_list").value;
    var sigue = 0;
    var tipovta = document.getElementById('tipo_vta').value;
    if(tipo_vta == '1'){
            if(checkvalue()){
                add_sale.submit();
            }else{
                return false; 
            }      
    }else{
        var contl = document.getElementById('totLin').value;       
        if(contl > 0){
            for(var i=0; i<contl; i++){
                //alert(document.getElementById('ItemOn'+i).value+' '+document.getElementById('orden['+i+']').value)
                if(parseFloat(document.getElementById('ItemOn'+i).value) == '1' && parseFloat(document.getElementById('orden['+i+']').value) == 0){                    
                    sigue = 1;
                    break;      
                }
            }
            if(!sigue){
                document.getElementById('amount[0]').value = document.getElementById('saleTotalCost').value;
                add_sale.submit();
            }else{

            if(checkvalue()){
                add_sale.submit();
            }else{
                return false; 
            }
            }
        }        
        
    }
    
}

function Validarsuperv_loc(usuario,passw)	
{   
    $.post("sale_ui.php", { actionID: "questpass", usuario: usuario, passw: passw},
        function(data){
           if($.trim(data) == '1'){
                document.getElementById("updqty").disabled = false;
           }else{
		alert('usuario y contraseņa incorrecta');
		document.getElementById("clave").value = '';
		document.getElementById("username").value = '';
		document.getElementById("username").focus();
		return false;            
           }
        });
}			  
function retval()
{
	
	// victor
	document.getElementById("descuentshow").value = document.getElementById("sub_tot").value * (document.getElementById("global_sale_discount").value / 100);
	document.getElementById("descuent").value = document.getElementById("sub_tot").value * (document.getElementById("global_sale_discount").value / 100);
	document.getElementById("showdescporc").innerHTML= '<strong>'+document.getElementById("global_sale_discount").value+' %</strong>';
	
	document.getElementById("descuentporc").value = document.getElementById("global_sale_discount").value;
	
	document.getElementById("saleTotalCost").value = parseInt(document.getElementById("sub_tot").value) + parseInt(document.getElementById("imp_tot").value) - parseInt(document.getElementById("descuent").value); 
     document.getElementById("str_saleTotalCost").innerHTML = document.getElementById("saleTotalCost").value;
	
	document.getElementById("global_sale_discount").value = '';
	document.getElementById("username").value = '';
	document.getElementById("clave").value = '';
	document.getElementById("updqty").disabled = true;
	
	
	document.getElementById("changep").value =  document.getElementById("amountpay").value -  document.getElementById("saleTotalCost").value
	
	
}

function updatesubtotal()
{
	alert('actualiza subtotal');
	
}

function verCustomer(opc){
    if(opc == '1'){
        ajaxpage_2('sale_ui.php?actionID=ListItemTable&can=1&sale_id='+document.getElementById("sale_id").value+'&saleitemid='+document.getElementById("item_id["+k+"]").value+'&saitid='+document.getElementById("idpossalesitems["+k+"]").value+'&qty='+document.getElementById("qty["+k+"]").value,'itemssales','itemssales');    
    }
    if(opc == '2'){
        
    }
}
</script>
<script type="text/javascript" language="javascript">
<!--
function ventanaSecundaria (URL){
	window.open(URL,"ventana1","width=600, height=310, scrollbars=yes, menubar=no, location=no, resizable=yes")
}

function customerFocus()
{
	document.scan_customer.customer.focus();
	updateScanCustomerField();
}

/*function itemFocus()
{
	document.scan_item.item.focus();
	updateScanItemField();
}*/

function updateScanCustomerField()
{
	document.scan_customer.customer.value=document.scan_customer.customer_list.value;
}

function updateScanItemField(valor)
{
	document.scan_item.item.value=document.scan_item.item_list.value;
	
}
/*function updateScanItemFie()
{
	document.scan_item.item.value=document.scan_item.queryString.value;
	
	
}*/
//-->
</script>
	<link rel="stylesheet" rev="stylesheet" href="../css/pos.css" />




<script type="text/javascript">
function lookup(inputString) {
    <?php if ($tipo_vta == '2') {
?>
        if(!document.getElementById('customer_list').value){
            alert('Seleccione un Paciente para Realizar la busqueda');
    document.getElementById('item').value = '';
    document.getElementById('inputString').value = '';
    document.getElementById('item_search2').value = '';
            return;   
        }
    <?php }
?>
    
	if(inputString.length == 0) {
		// Hide the suggestion box.
		$('#suggestions').hide();
	} else {
		$.post("rpc.php", {queryString: ""+inputString+"",tipo_vta: document.getElementById('tipo_vta').value,customer_list : document.getElementById('customer_list').value}, function(data){
			if(data.length >0) {
				$('#suggestions').show();
				$('#autoSuggestionsList').html(data);
			}
		});
	}
} // lookup

function fill(thisValue) {
	$('#inputString').val(thisValue);
	setTimeout("$('#suggestions').hide();", 200);
}

function searchitem(cadena,c){
    <?php if ($tipo_vta == '2') {
?>
        if(!document.getElementById('customer_list').value){
            alert('Seleccione un Paciente para Realizar la busqueda');
    document.getElementById('item').value = '';
    document.getElementById('inputString').value = '';
    document.getElementById('item_search2').value = '';
            return;   
        }
    <?php }
?>   
    tipo_vta = document.getElementById('tipo_vta').value;
    customer_list = document.getElementById('customer_list').value; 
	ajax=nuevoAjax();
	//var a = document.getElementById("inputString").value; 
	ajax.onreadystatechange = procesarinfo2;
	ajax.open("GET","../ajaxcampos1.php?a="+cadena+"&c="+c+'&tipo_vta='+tipo_vta+'&customer_list='+customer_list,true);
	ajax.send(null);
}

function searchCustomer(cadena,c){
    var tipoVta = document.getElementById('tipo_vta').value;
    $.post('../buscarjson.php',{a: cadena, c: c, tipoVta : tipoVta,tipSearch : '1'},function(data){    
        if(data[0].id > 0){
            //$('#customer_list').val(data.account_number);
            $("#customer_list").val(data[0].id);
            $("#nameCustomer").val(data[0].label);
            //select_item.submit();
        }else{
            alert('Documento no existe')
            $('#customerDoc_list').val('');
        }        
    },'json');
    
}

function submitPaciente(){
    if(!$.trim($("#nameCustomer").val()) ){
        alert('Ingrese el Paciente');
        $('#num_formu').val('');
        return false;
    }
    select_item.submit();
}

function formSubmit(){
    document.getElementById('item').value = '';
    document.getElementById('inputString').value = '';
    document.getElementById('item_search2').value = '';
    document.getElementById('customerDoc_list').value = '';
    document.getElementById('customer_list').value = '';
    document.select_item.submit();
}

function customerPos(val){
    document.getElementById('item').value = '';
    document.getElementById('inputString').value = '';
    document.getElementById('item_search2').value = '';    
    document.select_item.submit();
}

function updCustomer(){
    ajaxpage_2('sale_ui.php?tipo_vta='+document.getElementById('tipo_vta').value+'&actionID=selectcustomer&customer_list='+document.getElementById("customer_list").value,'selectcustomer','selectcustomer');
}

function validQty(qty,k){
    if(qty){
    var maxi = document.getElementById('dispo['+k+']').value;
    if(parseFloat(qty) <= parseFloat(maxi) ){
        if(qty == '0') qty = 1;
        document.getElementById('qty['+k+']').value = qty;
    }else{
        document.getElementById('qty['+k+']').value = maxi;
        alert('IMPORTANTE !!! No se Dispone en inventario las cantidades para Despachar lo Formulado');
        //document.getElementById('orden['+k+']').value = '0';
    }
    }
}

function validQtyInv(qty,k,pendi){
  
    if(qty){
    var maxi = document.getElementById('dispo['+k+']').value;
    if(parseFloat(qty) <= parseFloat(maxi) ){
        if(qty == '0' && document.getElementById('itipovta'+k).value != '2'){ 
            qty = 1; 
        }else{
            if(document.getElementById('itipovta'+k).value == '2'){
                if(parseFloat(qty) > parseFloat(document.getElementById('orden['+k+']').value) ){
                    alert('No se puede Despachar un valor mayor a lo Formulado')
                    qty = document.getElementById('orden['+k+']').value;
                }    
                
            }            
        }
        if($.trim(pendi)){
            if(parseFloat(qty) > parseFloat(pendi) ){
                alert('No se puede Despachar un valor mayor a lo Pendiente: '+pendi)
                qty = pendi;
            } 
        }         
        document.getElementById('qty['+k+']').value = qty;
        updateitemsale(k);
    }else{
        document.getElementById('qty['+k+']').value = maxi;
        alert('No se Dispone en inventario las cantidades para Despachar lo Formulado');
        //document.getElementById('orden['+k+']').value = '0';
    }
    }
}
</script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script src="../ajax/ajaxjs1.js"></script>
<script src="../ajax/ajaxjs2.js"></script>
<style type="text/css">

input {
    text-transform: uppercase;
}

h3 {
margin: 0px;
padding: 0px;	
}

.suggestionsBox {
position: absolute;
left: 1	0px;
margin: 10px 0px 0px 0px;
width: 600px;
	background-color: #999999;
	font-size:12px;
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
border: 1px solid #000;	
color: #fff;
z-index: 99999;
}

.suggestionList {
margin: 0px;
padding: 0px;
}

.suggestionList li {
	
margin: 0px 0px 3px 0px;
padding: 1px;
cursor: pointer;

}

.suggestionList li:hover {
	background-color: #659CD8;
}
</style>

</head>

<?php if (isset($_SESSION['current_sale_customer_id'])) {
?>
	<!--<body onLoad="itemFocus();">-->
	<?php } else {

		$strBody = 'onLoad="customerFocus();"';

	}
?>
<body style="margin: 0px;">

<? $table_bg = $display->sale_bg;
	$items_table = "$cfg_tableprefix".'items';

	if (!$sec->isLoggedIn()) {
		echo "<script>window.open('../login.php','_self')</script>";
		//	header ("location: ../login.php");
		exit();
	}
	$valida = 0;
	if (empty($_SESSION['current_sale_customer_id']) && $valida) {
		$customers_table = "$cfg_tableprefix".'customers';

		if (isset($_POST['customer_search']) and $_POST['customer_search'] != '') {
			$search = $_POST['customer_search'];
			$_SESSION['current_customer_search'] = $search;
			$customer_result = mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" or id =\"$search\"  ORDER by last_name",
				$dbf->conn);
		} elseif (isset($_SESSION['current_customer_search'])) {
			$search = $_SESSION['current_customer_search'];
			$customer_result = mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" or id =\"$search\"  ORDER by last_name",
				$dbf->conn);

		} elseif ($dbf->getNumRows($customers_table) > 200) {
			$customer_result = mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table ORDER by last_name LIMIT 0,200",
				$dbf->conn);
		} else {
			$customer_result = mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table",
				$dbf->conn);
		}

		$customer_title = isset($_SESSION['current_customer_search'])?
			"<b><font color='white'>$lang->selectCustomer: </font></b>":
			"<font color='white'>$lang->selectCustomer: </font>";

		echo "<table align='center' cellpadding='2' cellspacing='2' bgcolor='$table_bg' border=0>
	<form name='select_customer' action='sale_ui.php' method='POST'>
	<tr><td align='left'><font color='white'>$lang->findCustomer:</font>
	<input type='text' size='8' name='customer_search'>
	<input type='submit' value='Go'><a href='delete.php?action=customer_search'><font size='-1' color='white'>[$lang->clearSearch]</font></a>
	</form></td>	
	<form name='scan_customer' action='sale_ui.php' method='POST'>
	<td align='left'>$customer_title<select name='customer_list' onChange=\"updateScanCustomerField()\";>";

		while ($row = mysql_fetch_assoc($customer_result)) {
			if ($cfg_numberForBarcode == "Row ID") {
				$id = $row['id'];
			} elseif ($cfg_numberForBarcode == "Account/Item Number") {
				$id = $row['account_number'];
			}
			echo $id;
			$display_name = $row['first_name'].' '.$row['last_name'];
			echo "<option value=$id>$display_name</option></center>";
		}
		echo "</select></td>";
		// echo "<tr><td align='left'><center><small><font color='white'>($lang->scanInCustomer)</font></small></center>";
		echo "<tr><td align='left'>";
		echo "<font color='white'>$lang->customerID / $lang->accountNumber: </font><input type='text' name='customer' size='10'>
	<input type='submit'></td></tr>
	</form>";

	}

	if (isset($customer_list) || !$valida) {
		if ($itemsearch_2 != '' and $item != '') {
			$kl = 1;
			if (isset($_POST['item'])) {
				$item = $_POST['item'];
				$discount = '0%';
				if ($cfg_numberForBarcode == "Account/Item Number") {
					$item = $dbf->fieldToid($items_table,'item_number',$_POST['item']);

				}

				if ($dbf->isValidItem($item)) {
					if ($dbf->isItemOnDiscount($item)) {
						$discount = $dbf->getPercentDiscount($item).'%';
						$itemPrice = $dbf->getDiscountedPrice($item);

					} else {
						$itemPrice = $dbf->idToField($items_table,'unit_price',$item);
						//				$pack=$dbf->idToField($items_table,'pack',$item);

					}
					$itemTax = $dbf->idToField($items_table,'tax_percent',$item);
					$_SESSION['items_in_sale'][] = $item.' '.$itemPrice.' '.$itemTax.' '.'1'.' '.$discount.
						' '.$past.' '.$showitem;
					$_SESSION['sales_paywith'][] = $paymethodid.' '.$amount.' '.$doc_num.' '.$entity.
						' '.$auth_num;

					if ($cfg_fracprod == 1) {
						if ($pack > 1) {
?>
							<script languaje="javascript">
							
							</script>
							
							

							<? }

					}
				} else {
					echo "$lang->itemWithID/$lang->itemNumber ".$_POST['item'].', '."$lang->isNotValid";
				}
			}

		} // if($itemsearch_2 != '' and $item == '')

		if (isset($_SESSION['items_in_sale'])) {
			$num_items = count($_SESSION['items_in_sale']);

		} else {
			$num_items = 0;
		}
		$temp_item_name = '';
		$temp_item_code = '';
		$temp_item_id = '';
		$temp_quantity = '';
		$temp_price = '';
		$temp_sindsto = '';
		$finalSubTotal = 0;
		$finalTax = 0;
		$finalTotal = 0;
		$totalItemsPurchased = 0;

		$item_info = array();

		$customers_table = "$cfg_tableprefix".'customers';
		$order_customer_first_name = $dbf->idToField($customers_table,'first_name',$_SESSION['current_sale_customer_id']);
		$order_customer_last_name = $dbf->idToField($customers_table,'last_name',$_SESSION['current_sale_customer_id']);
		$order_customer_code = $dbf->idToField($customers_table,'account_number',$_SESSION['current_sale_customer_id']);
		$order_customer_name = $order_customer_first_name.' '.$order_customer_last_name;
		$pospaymethod_table = $cfg_tableprefix.'pos_pay_method';

		//echo "<hr><center><a href=delete.php?action=all>[$lang->clearSale]</a></center>";

		$items_table = "$cfg_tableprefix".'items';

		if (isset($_POST['item_search']) and $_POST['item_search'] != '') {
			$search = $_POST['item_search'];
			$_SESSION['current_item_search'] = $search;
			$item_result = mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table WHERE (item_name like \"%$search%\" or item_number= \"$search\" or id =\"$search\" )  and active = 1 ORDER by item_name",
				$dbf->conn);
		} elseif (isset($_SESSION['current_item_search'])) {
			$search = $_SESSION['current_item_search'];
			$item_result = mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table WHERE item_name like \"%$search%\" or item_number= \"$search\" or id =\"$search\" ORDER by item_name",
				$dbf->conn);

		} elseif ($dbf->getNumRows($items_table) > 200) {
			$item_result = mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table ORDER by item_name LIMIT ".
				$cfg_limitrecordview."",$dbf->conn);
		} else {
			$item_result = mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table ORDER by item_name",
				$dbf->conn);
		}

		$item_title = isset($_SESSION['current_item_search'])?"<b><font color='white'>$lang->selectItem: </font></b>":
			"<font color=white>$lang->selectItem: </font>";
		//if (!$can)

?>
		<!-- <hr></hr>-->

		<? if ($can == 2) {
			$rc_1 = mysql_query("update pos_sales set status = -1 where id =  ".$sale_id."",
				$conn_2);
			$rc_2 = mysql_query("select id, quantity_purchased from pos_sales_items where sale_id = ".
				$sale_id."",$conn_2);
			while ($rowcan = mysql_fetch_assoc($rc_2)) {
				if ($rowcan['quantity_purchased'] > 0)
					$sign = '-1';
				else
					$sign = '1';
				$rc_3 = mysql_query("update   pos_sales_items set  quantity_purchased  = (".$sign.
					" * quantity_purchased) where id = ".$rowcan['id']."",$conn_2);
			}
			echo '<div align="center"><font size="5" align="center"><strong>V E N T A&nbsp;&nbsp;&nbsp;&nbsp;A N U L A D A</strong></font></div>';
			//exit;
		}
?>
<table border="0" width="100%">
<tr>
<td colspan="2" >
<? if (!$can) {
?>
            
            <form name='select_item' action='sale_ui.php' method='POST'>
            <table border='0' bgcolor='<?= $table_bg
?>' align='center'  class="KT_tngtable" width="100%">
            
            <tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><strong>Modo</strong></th>
                <td width="5%" nowrap>
                            <select name='tipo_vta' onchange="formSubmit()" id="tipo_vta">
                            <? $Seleccion = '';
			if ($tipo_vta == '1') {
				echo $Seleccion = 'selected';
			}
?>
                            	<option value='1' <?= $Seleccion
?>>Venta</option>
                            <? $Seleccionb = '';
			if ($tipo_vta == '2') {
				echo $Seleccionb = 'selected';
			}
?>
                            	<option value='2' <?= $Seleccionb
?>>Dispensaci&oacute;n</option>
                    </select>
                </td>
                <td nowrap colspan="2">
            <?php if ($sale_id == '' and $_POST['consitem']) {
				$sales_table = $cfg_tableprefix.'sales';
				$field_names = array('date','customer_id','sold_by','invoicenumber','status',
					'tipo_vta','formula','bodega_id');
				$rc_maxin = mysql_query('SELECT MAX(invoicenumber) as maxin  FROM pos_sales',$conn_2);
				$maxin = mysql_fetch_assoc($rc_maxin);
				$maxin = $maxin['maxin'] + 1;
				$field_data = array(date("Y-m-d"),$customer_list,$_SESSION['session_user_id'],$maxin,
					0,$tipo_vta,$numFormula,$cfg_locationid);
				$dbf->insert($field_names,$field_data,$sales_table,false);
				$sale_id = mysql_insert_id();

			}

			if ($tipo_vta == '2') {
				if ($customer_list && $numFormula) {
					$sqlTvta = " AND tipo_vta = 2";
					$sqlTvta .= " AND customer_id = '$customer_list' AND formula = '$numFormula'";
					$almacen_pac = $dbf->idToField('pos_pacientes','almacenid',$customer_list);
					if (!trim($item)) {
						//BUSQUEDA POR EL WEBSERVICE DE LAS FORMULADAS DESPACHADASA
						$customer_codigo = $dbf->idToField('pos_pacientes','account_number',$customer_list);

						$result = Formulas::ConsultarFormula($customer_codigo,$numFormula,'id');

						if (count($result) > 0) {

							$SQL = "SELECT id FROM pos_sales WHERE status = 0 AND customer_id = '$customer_list' AND formula ='$numFormula'";
							$respta = mysql_query($SQL,$dbf->conn);
							while ($rowdel = mysql_fetch_assoc($respta)) {
								$SQL = "DELETE FROM pos_sales_items WHERE sale_id = '".$rowdel['id']."'";
								mysql_query($SQL,$dbf->conn);
								$SQL = "DELETE FROM pos_sales WHERE id = '".$rowdel['id']."'";
								mysql_query($SQL,$dbf->conn);
							}

							$sales_table = $cfg_tableprefix.'sales';
							$field_names = array('date','customer_id','sold_by','invoicenumber','status',
								'tipo_vta','formula','bodega_id','items_purchased');
							$rc_maxin = mysql_query('SELECT MAX(invoicenumber) as maxin  FROM pos_sales',$conn_2);
							$maxin = mysql_fetch_assoc($rc_maxin);
							$maxin = $maxin['maxin'] + 1;
							$field_data = array(date("Y-m-d"),$customer_list,$_SESSION['session_user_id'],$maxin,
								0,$tipo_vta,$numFormula,$cfg_locationid,count($result));
							$dbf->insert($field_names,$field_data,$sales_table,false);
							$sale_idD = mysql_insert_id($dbf->conn);
							$goToWS = true;

							for ($k = 0; $k < count($result); $k++) {
								//			      echo "select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_vta as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".$result[$k]['item_id']."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'<br>";
								if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
									$rc_positems = mysql_query("select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_vta as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
										$result[$k]['item_id'].
										"' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'",
										$dbf->conn);

								} else {
									$rc_positems = mysql_query("select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_evento as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
										$result[$k]['item_id'].
										"' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'",
										$dbf->conn);
								}
								$num_rows = mysql_num_rows($rc_positems);

								if ($num_rows > 0) {

									$itipo = $result[$k]['tipo'];
								}
								//else{
								//$rc_positems = mysql_query('select * from pos_items where id = '.$result[$k]['item_id'].
								//	'',$dbf->conn);

								$positems = mysql_fetch_assoc($rc_positems);
								//VARIABLE PARA DESCUENTO POR PRODUCTO
								$SQL = "SELECT SUM(percent_off) as dcto FROM pos_discounts WHERE item_id = '".$positems['id'].
									"'";
								$dcto_item = mysql_query($SQL,$dbf->conn);
								$rc_dcto = mysql_fetch_assoc($dcto_item);
								$temp_discount = $rc_dcto['dcto'];

								//VALOR DESCUENTO
								$valdsto = number_format($positems['unit_price'] * ($temp_discount / 100),0,'.',
									'');
								//VALOR CON DESCUENTO
								$temp_price2 = ($positems['unit_price'] - $valdsto);
								//VALOR IVA DEL PRODUCTO
								$valimp = number_format(($temp_price2) * (($positems['tax_percent'] / 100)),0,
									'.','') * 1;

								$salesdetail_table = $cfg_tableprefix.'sales_items';
								$field_names = array('sale_id','item_id','quantity_purchased','item_unit_price',
									'item_buy_price','item_tax_percent','item_total_tax','item_total_cost',
									'unit_sale','sale_frac','tipo','porcen_dcto','value_dcto','qtyrecetada','toWS',
									'qtytoWS');
								$field_data = array($sale_idD,$positems['id'],0,$temp_price2,$positems['buy_price'],
									$positems['tax_percent'],$valimp,($temp_price2 + $valimp),1,$positems['pack'],$itipo,
									$temp_discount,$valdsto,$result[$k]['qtyrecetada'],1,$result[$k]['suma']);
								$dbf->insert($field_names,$field_data,$salesdetail_table,false);

							}

						}
					}
					$rc_saleop = mysql_query('select id,customer_id  from pos_sales where sold_by = '.
						$userId.' and status = 0 '.$sqlTvta,$conn_2);
					$NumItems = mysql_num_rows($rc_saleop);
					$saleop = mysql_fetch_assoc($rc_saleop);

					if ($saleop['id'] != '') {
						$sale_id = $saleop['id'];
						$customer_list = $saleop['customer_id'];
					} else {
						$sale_id = '';
					}
				}
			} else {
				$sqlTvta = ' AND tipo_vta = 1';
				if ($customer_list) {
					$sqlTvta .= " AND customer_id = '$customer_list' ";
				}

				$rc_saleop = mysql_query('select id,customer_id  from pos_sales where sold_by = '.
					$userId.' and status = 0 '.$sqlTvta,$conn_2);
				$saleop = mysql_fetch_assoc($rc_saleop);
				if ($saleop['id'] != '') {
					$sale_id = $saleop['id'];
					$customer_list = $saleop['customer_id'];
				} else {
					$sale_id = '';
				}
			}
?>
            <input name="sale_id" type="hidden" id="sale_id" value="<?= $sale_id
?>" />

<div id="selectcustomer">
<table width="100%" class="KT_tngtable">
<tr>
<th align="center" style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap>
<?php if ($tipo_vta == '2') {
				echo $lang->Paciente;
			} else {
				echo $lang->orderBy;
			}
?>
</th>
<td nowrap>
<input type="text" size="23" name="customerDoc_list" id="customerDoc_list" value="<?= $_REQUEST['customerDoc_list']
?>" onchange="searchCustomer(this.value,4)"/>


<input type="hidden" name="customer_list" id="customer_list" value="<?= $customer_list
?>">
			<? if (trim($customer_list)) {
				if ($tipo_vta == '2') {
					$rc_customer = mysql_query("select first_name, last_name, id, account_number from  pos_pacientes where id = '".
						$customer_list."'",$conn_2);
				} else {
					$rc_customer = mysql_query("select first_name, last_name, id, account_number from  pos_customers  where id = '".
						$customer_list."' ",$conn_2);
				}

				$rowc = mysql_fetch_assoc($rc_customer);
				$customerstr = $rowc["account_number"].' - '.$rowc["first_name"].' '.$rowc["last_name"];
			}
?>
<input type="text" name="nameCustomer" id="nameCustomer" autocomplete="off" size="50" value="<?= $customerstr
?>"/>
<?php if ($tipo_vta == '1') {
?>
&nbsp;&nbsp;&nbsp;<a href="sale_ui.php?actionID=addcustomer&act=1" onClick="ventanaSecundaria(this); return false" target="_parent"><img src="../images/edit_add.png" border="0" style="cursor: pointer;" title="Agregar Cliente"/></a>
<?php }
?>
<!--
&nbsp;&nbsp;&nbsp;<img onclick="updCustomer()" src="../images/recur.png" border="0" style="cursor: pointer;" title="Actualizar"/></a>
-->

</td>
<?php if ($tipo_vta == '2') {
?>
<th align="center" style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap>NUM_FORMULA</th>
<td nowrap><input type="text" name="num_formu" id="num_formu" onchange="submitPaciente()" value="<?= $numFormula
?>"/></td>                
<?php } else {
?>
    <input type="hidden" value="0" name="num_formu" id="num_formu" />
<?php }
?>
</tr>
</table>
</div>                
                
                </td>              
                <td colspan="3" ><input type="button" value="<?= $lang->newSale
?>" disabled/>&nbsp;&nbsp;&nbsp;
                <input type="button" value="<?= $lang->cancelsaleall
?>" onClick=javascript:cancelsale(); />&nbsp;&nbsp;&nbsp;
                </td>
                        <!--<td width='243'><? //	$lang->devolucion

?>
			                 <input type="checkbox" name="devolucion" id="devolucion" value="1"  onClick="pedirclave();" />
                        </td>-->
            </tr>
            <tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; display:none " nowrap>
                    <?= $lang->findItem
?>:
                </th> 
                <td style="display: none;">   
            <?php if ($cfg_searchproductcombo == 1) {
?>    
                    <input type='text' size='8' name='item_search' id='item_search'>
                    </font>
                    <input type='submit' value='Go'><a href='delete.php?action=item_search'><font size='-1' color='white'>[<?= $lang->
				clearSearch
?>]</font></a>
                
            <? } else {
?> 
				<input type="text" size="15" name="itemsearch_2" id="item_search2" value="<?= $itemsearch_2
?>" onChange="searchitem(this.value,2);"><? if ($itemsearch_2 != '') {
?>
					<script src="../ajax/ajaxjs2.js"></script>
					<script language="JavaScript">
					//searchitem(document.getElementById("item_search2").value,2);
					</script>
					<? }
?>
                
                <?php }

			// if($cfg_searchproductcombo == 1)
			///////////////////////////////////////////////////////////////////////////////
			$strItem = '';
?>
                    </td>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><?php echo
			$lang->itemID.' / '.$lang->itemNumber
?>: </th>
                <td width="5%" nowrap>
                    <input type='text' name='item' id='item' onChange='searchitem(this.value,2);' size='14' value="<?= $strItem
?>">
                 </td>
                 <th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%"><?= $lang->
			description
?>: </th>
            <?php //////////////////////////////////////////////////////////////
			if ($cfg_searchproductcombo == 1) {
?>    
                <?= $item_title
?><td><select name='item_list' onChange=\"updateScanItemField()\";>
                <option value=''>Elija....</option>
                <?php while ($row = mysql_fetch_assoc($item_result)) {
					if ($cfg_numberForBarcode == "Row ID") {
						$id = $row['id'];

					} elseif ($cfg_numberForBarcode == "Account/Item Number") {
						$id = $row['item_number'];
					}

					$quantity = $row['quantity'];
					$brand_id = $row['brand_id'];
					$brand_name = $dbf->idToField("$brands_table",'brand',"$brand_id");
					$unit_price = $row['unit_price'];
					$tax_percent = $row['tax_percent'];
					$option_value = $id;
					$active = $row['active'];
					$display_item = "$brand_name".'- '.$row['item_name'];
					if ($row['unit_price'] != 0 and $active == 1) {
						if ($quantity <= 0) {
							echo "<option value='$option_value'>$display_item ($lang->outOfStockWarn)</option>\n";

						} else {
							echo "<option value='$option_value'>$display_item</option>\n";

						}
					}
				}
?>
                    </select>
                    </td>
            <?php } else {
				$strItem = '';
?>
                    
                        
                        <td width="5%" nowrap><input type="text" size="50" value="<?= $strItem
?>" id="inputString" name="inputString" onKeyUp="lookup(this.value);" onBlur="fill();" autocomplete= 'off' />
                    <div class="suggestionsBox" id="suggestions" style="display: none;" >
                        <img src="../imagenes/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                        <div class="suggestionList" id="autoSuggestionsList"  style="overflow:scroll;  overflow-x:hidden; width:600; height:200;" onClick="updateScanItem(1,1);">
		                  &nbsp;
                        </div>
                    </div>
                    </td>
            <?php }
?>       
                   
                    <td>             
                    <input type='submit' value='Adicionar Producto' name='consitem' id='consitem' disabled='true' >    
                    <input type='button' value='Limpiar' name='clearfields' id='clearfields'  onclick='ClearField();' >                 
                </td>			
            </tr>                   
            
            <tr>
                <td colspan="7" ><div id="pregg"></div></td>
            </tr>
        </table></form>
<? }
?>
</td>
</tr>
<tr>
<td valign="top">

        <form name='add_sale' action='addsale.php' method='POST' onsubmit='return checkvalue()'>
        <div id="itemssales"  style="overflow:scroll;  overflow-x:hidden; width:auto; height:280;"> <!--height:360;-->
<table border='0'  cellspacing='0' cellpadding='2' align='center' class="KT_tngtable" bgcolor='<?= $table_bg
?>' width="100%">
        <?php //
		//echo 'select id  from pos_sales where status = 0 and sold_by = '.$userId.' and ' . $sqlTvta;
		if ($tipo_vta == '1' || $NumItems > 0) {

			$rc_saleopen = mysql_query('select id  from pos_sales where status = 0 and sold_by = '.
				$userId.' '.$sqlTvta,$dbf->conn);
			$saleopen = mysql_fetch_assoc($rc_saleopen);
			if ($saleopen['id'] != '') {
				$sale_id = $saleopen['id'];
			} else {
				$sale_id = '';
			}
		} else {
			$sale_id = '';
		}
		//        if ($sale_id == '')
		//            exit;

?>    
            
            <tr>
            <thead>
            <? if ($tipo_vta == '2') {
?>    
                <th nowrap><?= $lang->typeVta
?></th>
            <?php }
?>            
                <th nowrap><?= $lang->itemID
?></th>
            	<th nowrap><?= $lang->itemName
?></th>
            	<th nowrap><?= $lang->pvc
?></th>
            	<th nowrap><?= $lang->porcdesto
?></th>
            	<th nowrap><?= $lang->vlrdsto
?></th>
            	<th nowrap><?= $lang->vlrcondsto
?></th>
            	<th nowrap><?= $lang->porciva
?></th>
            	<th nowrap><?= $lang->vlriva
?></th>
            	<th nowrap><?= $lang->pvp
?></th>
            	<th nowrap><?php if ($tipo_vta == '2') {
?><?= $lang->disp
?>&nbsp;&nbsp;<?= $lang->formu
?> (P) <?php }
?>&nbsp;&nbsp;<?= $lang->cant;
?>&nbsp;&nbsp;<?= $lang->fraccion
?></th>
            	<th nowrap><?= $lang->past
?></th>
            	<th nowrap><?= $lang->vlrtot
?></th>
            	<th nowrap><?= $lang->cancel
?></th>
            </tr>
            </thead>
            <input type="hidden" name="sale_id" id="sale_id" value="<?= $sale_id
?>"/>
        <?php //
		if ($sale_id != '' and $item != '') {
			$itipo = 1;
			if ($tipo_vta == '2') {

				if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {

					$rc_positems = mysql_query("select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_vta as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".
						$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'",
						$conn_2);
				} else {
					$rc_positems = mysql_query("select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_evento as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".
						$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'",
						$conn_2);
				}
				$num_rows = mysql_num_rows($rc_positems);
				if ($num_rows > 0) {
					if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
						$itipo = 2;
					} else {
						$itipo = 3;
					}
				}
				//else{
				if (DISTRI_VTA == 1) {

					$rc_positems = mysql_query('select * from pos_items where item_number = '.$item.
						'',$conn_2);
				}

			} else {
				$rc_positems = mysql_query('select * from pos_items where item_number = '.$item.
					'',$conn_2);
			}

			$positems = mysql_fetch_assoc($rc_positems);

			//VARIABLE PARA DESCUENTO POR PRODUCTO
			$SQL = "SELECT SUM(percent_off) as dcto FROM pos_discounts WHERE item_id = '".$positems['id'].
				"'";
			$dcto_item = mysql_query($SQL,$dbf->conn);
			$rc_dcto = mysql_fetch_assoc($dcto_item);
			$temp_discount = $rc_dcto['dcto'];

			//VALOR DESCUENTO
			$valdsto = number_format($positems['unit_price'] * ($temp_discount / 100),0,'.',
				'');
			//VALOR CON DESCUENTO
			$temp_price2 = ($positems['unit_price'] - $valdsto);
			//VALOR IVA DEL PRODUCTO
			$valimp = number_format(($temp_price2) * (($positems['tax_percent'] / 100)),0,
				'.','') * 1;

			$salesdetail_table = $cfg_tableprefix.'sales_items';
			$field_names = array('sale_id','item_id','quantity_purchased','item_unit_price',
				'item_buy_price','item_tax_percent','item_total_tax','item_total_cost',
				'unit_sale','sale_frac','tipo','porcen_dcto','value_dcto','qtyrecetada');
			$field_data = array($sale_id,$positems['id'],1,$temp_price2,$positems['buy_price'],
				$positems['tax_percent'],$valimp,($temp_price2 + $valimp),1,$positems['pack'],$itipo,
				$temp_discount,$valdsto,0);
			$dbf->insert($field_names,$field_data,$salesdetail_table,false);

			mysql_query("UPDATE pos_sales SET items_purchased = items_purchased + 1 WHERE id = '$sale_id'",
				$dbf->conn);

		}

		if ($sale_id && $can != '2') {
			$query = "select * from pos_sales_items where sale_id = ".$sale_id.
				" order by id desc";
			//echo "select * from pos_sales_items where sale_id = ".$sale_id."";
			$result_posslaesitem = mysql_query($query,$conn_2);
			$k = 0;
?>
        <tbody>
        <?php $lins = 0;
			$tot_temp_sindsto = 0;
			$tot_valdsto = 0;
			$tot_temp_price = 0;
			$tot_valimp = 0;
			$finalTax = 0;
			$tot_temp_pricepub = 0;
			$tot_rowTotal = 0;
			$qtyPro = 0;
			while ($row_item = mysql_fetch_assoc($result_posslaesitem)) {
				$lins++;
				if ($row_item['id'] == $saitid) {
					$queryupd = 'update pos_sales_items set quantity_purchased = -'.$row_item['quantity_purchased'].
						' where id = '.$saitid.'';
					//echo 'update pos_sales_items set quantity_purchased = 98 where sale_id = '.$sale_id.' and item_id = '.$saleitemid.'';

					$result_queryupd = mysql_query($queryupd);
				}

				if ($row_item['id'] == $saitemid) {
					if ($tipopast == 2) {
						$precunit = $pvpfin / $pack;
						$prcomp = $preciocompra / $pack;

					} else {
						$precunit = $pvpfin * $pack;
						$prcomp = $preciocompra * $pack;
					}
					$pvptot = $precunit * $qty;
					$queryupd = 'update pos_sales_items set quantity_purchased = '.$qty.
						', unit_sale = '.$tipopast.', item_unit_price = '.$precunit.
						', item_total_cost = '.$pvptot.', item_buy_price = '.$prcomp.' where id = '.$saitemid.
						' and item_id = '.$saleitemid.'';

					$result_queryupd = mysql_query($queryupd);
				}

				$temp_item_id = $row_item['item_id'];
				$idpossalesitems = $row_item['id'];
				$Saleid = $row_item['sales_id'];
				$tipoVenta = '<span style="font-size: 13px"><strong>Vta</strong></span>';
				$itipo_Vta = 1;

				if ($tipo_vta == '2') {
					if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
						$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_vta as unit_price, pos_items.pack, pos_items.quantity,pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
							$row_item['item_id'].
							"' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
					} else {
						$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_evento as unit_price, pos_items.pack, pos_items.quantity,pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
							$row_item['item_id'].
							"' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
					}
					$result = mysql_query($sql,$conn_2);
					$num_rows = mysql_num_rows($result);
					$srtEvent = 'Disp.';
					if ($num_rows > 0) {

						$saleopen = mysql_fetch_assoc($result);
						if ($row_item['qtyrecetada'] > 0) {
							if ($row_item['tipo'] == '3') {
								$temp_price = $saleopen['price_evento'];
								$temp_sindsto = $saleopen['price_evento'];
								$srtEvent = 'D. Evto';
							} else {
								$temp_price = $saleopen['unit_price'];
								$temp_sindsto = $saleopen['unit_price'];
								$srtEvent = 'Disp.';
							}
						} else {
							if (DISTRI_VTA) {
								$temp_price = $dbf->idToField($items_table,'unit_price',$temp_item_id);
								$temp_sindsto = $dbf->idToField($items_table,'unit_price',$temp_item_id);
							} else {
								$temp_price = $saleopen['unit_price'];
								$temp_sindsto = $saleopen['unit_price'];
								$srtEvent = 'Disp.';
							}
						}
						if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
							$tipoVenta = '<span style="font-size: 13px; cursor:pointer" id="tipoDisp'.$k.
								'" onclick="cambioDispe('.$k.','.$row_item['tipo'].')"><strong>'.$srtEvent.
								'</strong></span>';
						} else {
							$tipoVenta = '<span style="font-size: 13px; cursor:pointer" id="tipoDisp'.$k.
								'" ><strong></strong>n'.$almacen_pac.'</span>';
						}
						$itipo_Vta = 2;

					}
					if (DISTRI_VTA) {
						$temp_price = $dbf->idToField($items_table,'unit_price',$temp_item_id);
						$temp_sindsto = $dbf->idToField($items_table,'unit_price',$temp_item_id);
					}
				} else {
					$temp_price = $dbf->idToField($items_table,'unit_price',$temp_item_id);
					$temp_sindsto = $dbf->idToField($items_table,'unit_price',$temp_item_id);
				}

				$temp_tax = $dbf->idToField($items_table,'tax_percent',$temp_item_id);
				$preciocompra = $dbf->idToField($items_table,'buy_price',$temp_item_id);
				$temp_item_name = $dbf->idToField($items_table,'item_name',$temp_item_id);
				$temp_item_code = $dbf->idToField($items_table,'item_number',$temp_item_id);

				$inveQty = $dbf->idToField($items_table,'quantity',$temp_item_id);

				//$temp_pack=$dbf->idToField($items_table,'pack',$temp_item_id);
				$temp_pak = mysql_query("select pack from pos_items where id = ".$temp_item_id.
					"",$dbf->conn);
				//echo "select pack from pos_items where id = ".$temp_item_id."";
				$rw_pack = mysql_fetch_assoc($temp_pak);
				$temp_pack = $rw_pack["pack"];
				$temp_quantity = $dbf->idToField('pos_sales_items','quantity_purchased',$idpossalesitems);

				if ($temp_quantity < 0)
					$canc = 1;
				else
					$canc = 0;

				//VARIABLE PARA DESCUENTO POR PRODUCTO
				$SQL = "SELECT SUM(percent_off) as dcto FROM pos_discounts WHERE item_id = '$temp_item_id'";
				$dcto_item = mysql_query($SQL,$dbf->conn);
				$rc_dcto = mysql_fetch_assoc($dcto_item);
				$temp_discount = $rc_dcto['dcto'];

				//VALOR DESCUENTO
				$valdsto = number_format($temp_sindsto * ($temp_discount / 100),0,'','');

				$temp_packing = $dbf->idToField('pos_sales_items','unit_sale',$idpossalesitems);
				if ($temp_packing == 2) {

					//VALOR CON DESCUENTO
					$temp_price2 = ($temp_sindsto - $valdsto) / $temp_pack;
					//VALOR IVA DEL PRODUCTO
					$valimp = number_format(($temp_price2) * (($temp_tax / 100)),0,'','');
					$temp_pricepub = (($temp_price2 + $valimp));
				} else {
					//VALOR CON DESCUENTO
					$temp_price2 = ($temp_sindsto - $valdsto);
					//VALOR IVA DEL PRODUCTO
					$valimp = number_format(($temp_price2) * (($temp_tax / 100)),0,'','');
					$temp_pricepub = ($temp_price2 + $valimp);
				}

				//VALOR IVA DEL PRODUCTO
				$valimp = number_format(($temp_price2) * (($temp_tax / 100)),0,'','');

				$subTotal = $temp_price2 * $temp_quantity;
				$tax = $subTotal * ($temp_tax / 100);
				$rowTotal = $subTotal + $tax;
				$rowTotal = number_format($rowTotal,0,'','');

				$pak = $_POST['$pack'.$k.''];
				$past = $item_info[5];
				$showitem = $item_info[6];
				$finalSubTotal += $subTotal;

				$finalTotal += $rowTotal;
				$totalItemsPurchased += $temp_quantity;
				$resto = substr($temp_item_name,0,45);

				$temp_sindsto2 = number_format($temp_sindsto,0,'','');

				$valimp2 = $valimp;
				$temp_pricepub2 = number_format($temp_pricepub,0,'','');
				$vlrtot = $temp_pricepub * $temp_quantity;

				//	if($temp_item_code == $temp_item_code) $showitem.$k = 1;
				/*if($k == $kk) $showitem.$k = 1;
				else $showitem.$k = 0; */
				//{
				//  if($can!=1) {

?>
            <tr style="color: #FFFFFF;">
            <input type="hidden" value="<?= $itipo_Vta
?>" name="itipovta[<?= $k
?>]" id="itipovta<?= $k
?>" />
			<? if ($canc == 1)
					$readon = 'readonly';
				else
					$readon = '';
				if ($tipo_vta == '2') {
?>
                <td align='center' nowrap style="text-align: right;color: white;  font-weight: bold;"><?= $tipoVenta
?></td>                    
                    <?php }
?>    
                <td align='center' nowrap style="text-align: right;color: white;  font-weight: bold;"><?= $temp_item_code
?></td>
				<td align='left' nowrap style="text-align: right;color: white;  font-weight: bold;"><?= $resto
?></td>
				<td align='center' nowrap><input type=text name='price<?= $k
?>' style='text-align:center' readonly value='<?= $temp_sindsto2
?>' size='8'></td>
				<td nowrap style="text-align: right;color: white;  font-weight: bold;">
                <input type="hidden" name="temp_discount" id="temp_discount" value="<?= $temp_discount
?>" />
                <?= $temp_discount
?> <?= $lang->sigporc
?></td>
				<td nowrap style="text-align: right;color: white;  font-weight: bold;">
                 <input type="hidden" name="valdsto" id="valdsto" value="<?= $valdsto
?>" />
                <?= number_format($valdsto,0,'','');
?></td>
				<td nowrap ><input type=text name='price<?= $k
?>' id='pricedcto<?= $k
?>' readonly style='text-align:center' value='<?= number_format($temp_price2,0,
				'','');
?>' size='8'></td>
				<td nowrap><input type=text name='tax<?= $k
?>' style='text-align:center; width: 25px;'  readonly  value='<?= $temp_tax
?>' size='5'></td>
				<td nowrap><input type=text name='valimp<?= $k
?>' id='valimp<?= $k
?>' style='text-align:center; width: 35px;'  readonly  value='<?= $valimp2
?>' size='6'></td>
				<td align='center' nowrap ><input type=text name='price<?= $k
?>' readonly style='text-align:center' value='<?= $temp_pricepub2
?>' size='8'></td>
				<td nowrap>                
<?php if ($tipo_vta == '2' && $itipo_Vta == '2') {
					$disableFormu = '';
					$readOnlyqty = '';

					if ($row_item['toWS']) {
						$disableFormu = 'readonly';
						if ($row_item['quantity_purchased'] > 0) {
							$temp_quantity = $row_item['quantity_purchased'];
							$temp_quantityB = $row_item['qtyrecetada'] - $row_item['qtytoWS'];
						} else {
							$temp_quantity = $row_item['quantity_purchased'];
							$temp_quantityB = $row_item['qtyrecetada'] - $row_item['qtytoWS'];
						}
						if ($temp_quantity < 0) {
							$temp_quantity = 0;
							$readOnlyqty = 'readonly';
						} else {
							$readOnlyqty = '';
						}
					} else {
						$temp_quantity = $row_item['quantity_purchased'];
						$temp_quantityB = $row_item['qtyrecetada'];
					}
?>

<input type=text name='dispo<?= $k
?>' id='dispo[<?= $k
?>]' readonly  style='text-align:center; width: 25px;' value='<?= number_format($inveQty,
					0,'','');
?>' size='3'>

<input type=text name='orden<?= $k
?>' id='orden[<?= $k
?>]' style='text-align:center; width: 25px;' value='<?= number_format($row_item['qtyrecetada'],
					0,'','');
?>' size='3' <?= $disableFormu
?>  onchange='validFormulada(<?= $k
?>)'> (<?= number_format($temp_quantityB,'2',',','')
?>)
<? } else {
					if ($tipo_vta == '2') {
?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }
?>
<input type="hidden" name='dispo<?= $k
?>' id='dispo[<?= $k
?>]' <?= $readon
?>  style='text-align:center; width: 25px;' value='<?= number_format($inveQty,0,
					'','');
?>' size='3'>
    <input type="hidden" name='orden<?= $k
?>' id='orden[<?= $k
?>]' value='0'>
<?php }
?>                
                
                <input type=text name='quantity<?= $k
?>' id='qty[<?= $k
?>]' <?= $readon
?> onchange="validQtyInv(this.value,<?= $k
?>,'<?= $temp_quantityB
?>')" style='text-align:center; width: 25px;' value='<?= number_format($temp_quantity,
				0,'','');
?>' size='3' <?= $readOnlyqty
?> >
(<?= $temp_pack
?>)
</td>
				<td nowrap align='center'><input type='hidden' name='pack<?= $k
?>' id='pack[<?= $k
?>]' value='<?= $temp_pack
?>'/> 
                    <select name='past<?= $k
?>' id='past[<?= $k
?>]' onchange="updateitemsale(<?= $k
?>)">
                        <option value="1"
            <?php if (!(strcmp("1",$temp_packing))) {
					echo $selected = "selected=\"selected\"";
				}
?>
                        >Unidad</option>
            <?php if ($temp_pack != 1)
?>
                        <option value="2"
            <?php 
					if (!(strcmp("2",$temp_packing))) {
						echo $selected = "selected=\"selected\"";
					}
?>
                        >Frac</option>
                    </select>
                </td>

				<td align='center' nowrap><font color='white'><b><?= $cfg_currency_symbol.
				number_format($vlrtot,0)
?></b></font>
				<input type='hidden' name='temp_pricepub2<?= $k
?>' id='pvpfin[<?= $k
?>]' value='<?= $temp_price2
?>'/>
				<input type='hidden' name='preciocompra<?= $k
?>' id='preciocompra[<?= $k
?>]' value='<?= $preciocompra
?>'/>
				</td>
                <?php //			  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>
				if ($row_item['toWS']) {
?>
                <input type='hidden' name='item_id<?= $k
?>' id='item_id[<?= $k
?>]' value='<?= $temp_item_id
?>'>
				<input type='hidden' name='idpossalesitems<?= $k
?>' id='idpossalesitems[<?= $k
?>]' value='<?= $idpossalesitems
?>'>
				<input type='hidden' name='<?= $k
?>' value='<?= $k
?>'>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?= $k
?>" />
                 <td align="center">FORMU</td>
                 <?php } else {
					if ($canc == 0) {
?>
                <input type='hidden' name='item_id<?= $k
?>' id='item_id[<?= $k
?>]' value='<?= $temp_item_id
?>'>
				<input type='hidden' name='idpossalesitems<?= $k
?>' id='idpossalesitems[<?= $k
?>]' value='<?= $idpossalesitems
?>'>
				<input type='hidden' name='<?= $k
?>' value='<?= $k
?>'>
				<td align='center'><a href=javascript:void(0)  class=InvUpText ><font color="#FFFFFF"></font></a>
                <img src="../images/cancel.png" border="0" title="<?= $lang->
						cancel
?>"   onClick=javascript:cancelitemsale(<?= $k
?>);  style="cursor:pointer"/>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?= $k
?>" />
				
				<? } else {
?>
				<td colspan="2" align="center" nowrap>
                <input type="hidden" value="0" name="ItemOn" id="ItemOn<?= $k
?>" />
                <font color="white">A N U L A D O</font></td>
				
				<? }
				}
?>
                <input type='hidden' name='showitem<?= $k
?>' id='showitem<?= $k
?>' value='<?= $showitem
?>' />
				</td>
            </tr>
			<? //	 }
				if ($can == 1) {
					//echo '<tr><td>dsds</td><td>'.$k.'</td></tr>';

				}
				//}
				if ($canc == 0) {
					if ($row_item['qtyrecetada'] == 0) {
						$tot_temp_sindsto += $temp_sindsto;
						$tot_valdsto += $valdsto;
						$tot_temp_price += $temp_price2;
						$tot_valimp += $valimp;
						$finalTax += $tax;
						$tot_temp_pricepub += $temp_pricepub;
						$tot_rowTotal += $vlrtot;
						$qtyPro += $temp_quantity;
					} else {
						$tot_temp_sindstoD += $temp_sindsto;
						$tot_valdstoD += $valdsto;
						$tot_temp_priceD += $temp_price2;
						$tot_valimpD += $valimp;
						$finalTaxD += $tax;
						$tot_temp_pricepubD += $temp_pricepub;
						$tot_rowTotalD += $vlrtot;
						$qtyProD += $temp_quantity;
					}
					$tot_temp_quantity += $temp_quantity;
					$aa[$k] = $temp_pricepub;
				}
				// if($showitem.$k == 0)

				$k++;
			}

			$rc_tax = mysql_query('select pos_tax_rates.tax_rates_id  , pos_tax_rates.tax_rate from pos_tax_class, pos_tax_rates where pos_tax_rates.tax_class_id = pos_tax_class.tax_class_id and pos_tax_class.tax_class_id = 1',
				$conn_2);
			$jh = 0;
			$number = mysql_num_rows($rc_tax);
			if ($number) {
				while ($row4 = mysql_fetch_assoc($rc_tax)) {
					for ($k = 0; $k < $num_items; $k++) {
						$item_info = explode(' ',$_SESSION['items_in_sale'][$k]);
						$temp_item_id = $item_info[0];
						$temp_tax = $item_info[2];
						if ($temp_tax == $row4["tax_rate"]) {
							$taxa += $aa[$k];
							echo "<input type=hidden name='taxid".$row4["tax_rates_id"]."' id=''   value='".
								$row4["tax_rates_id"]."'>";
							echo "<input type=hidden name='tax".$row4["tax_rates_id"]."' id=''   value='".$taxa.
								"'>";
							echo "<input type=hidden name='taxrate".$row4["tax_rates_id"].
								"' id=''   value='".$row4["tax_rate"]."'>";

						}
					}
					$taxa = 0;
					//					 echo $row4["tax_rate"].' victor'.'<br>';
					$jh++;
				}
				echo "<input type=hidden name='jh' id=''   value='".$jh."'>";
			}
			// $taxa=$rowTotal;

			//////////////////////////////////////////////
		}
		$numcolTotal = 2;
		if ($tipo_vta == '2') {
			$numcolTotal = 3;
		}
?>
        </tbody>
<?php if ($tipo_vta == '2') {
?>        

        <thead>
            <tr> 
                <th colspan="<?= $numcolTotal
?>" style="text-align: right;"><?= $lang->totDis
?></th>
				<th style="text-align: right;"><b><?= number_format($tot_temp_sindstoD,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valdstoD,0)
?></th>
				<th style="text-align: right;"><?= number_format($tot_temp_priceD,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valimpD)
?></th>
                <th style="text-align: right;"><?= number_format($tot_temp_pricepubD)
?></th>
				<th style="text-align: right;"><?= $qtyProD
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_rowTotalD)
?></th>
				
				<th style="text-align: right;">
	
                </th>
            </tr>
        </thead>
<?php }
?>        
        <thead>
            <tr> 
                <th colspan="<?= $numcolTotal
?>" style="text-align: right;"><?= $lang->tot
?></th>
				<th style="text-align: right;"><b><?= number_format($tot_temp_sindsto,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valdsto,0)
?></th>
				<th style="text-align: right;"><?= number_format($tot_temp_price,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valimp)
?></th>
                <th style="text-align: right;"><?= number_format($tot_temp_pricepub)
?></th>
				<th style="text-align: right;"><?= $qtyPro
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_rowTotal)
?></th>
				
				<th style="text-align: right;">
                <input type="hidden" value="<?= $lins
?>" name="totLin" id="totLin" />
                <input name="totvta" type="hidden" id="totvta" value="<?= $tot_temp_pricepub
?>"/>
            		<input name="tots" type="hidden" id="tots" value="<?= $tot_rowTotal
?>"/>
                    <input name="customerid" type="hidden" id="customerid" value="<?= $customer_list
?>"/>
                    <input name="devolucionid" type="hidden" id="devolucionid" value="<?= $devolucion
?>"/>
		
                </th>
            </tr>
        </thead>
		<? $aa = $finalSubTotal;
		$finalSubTotal = $tot_rowTotal - $finalTax;
		$finalTax = number_format($finalTax,0,'','');
		$totalvta = $tot_rowTotal;
		$finalTotal = number_format($finalTotal,0,'','');
?>
        </table>
        </div>
</td>
<td width="10px" nowrap>



<?php if ($global_sale_discount == "") {
			$descuentporc = 0;
			$decuent = 0;
		} else {
			$descuentporc = $global_sale_discount;
			$decuent = ($aa * ($global_sale_discount / 100));
		}

		if (!$can) {
?>
            <table align='left' border=0 class="KT_tngtable" width="100%">
            <tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; "><?= $lang->
			descuento
?>
                </th>
                <td nowrap>
                <input type="text" name="global_sale_discount" id="global_sale_discount" onChange=" ajaxpage_2('sale_ui.php?actionID=quest&IDLoc='+document.getElementById('global_sale_discount').value,'preg','preg');"  size="3">
			<input type="hidden" name="sale_discount" id="sale_discount" value="0" /> <? echo
			"<input type='button' name='updateQuantity$k' disabled='true' id='updqty' value='$lang->update'  onclick='retval();'>
	$lang->descuento: $cfg_currency_symbol$decuent  ---  $descuentporc % </td></tr>";
			//  onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"

?>
                </td>
			<tr>
                <td colspan="2"><div id="preg"></div>
                </td>
            </tr>
			<tr>
                <th align='left' style="vertical-align: middle; text-align: center; background-color: #A73535; "><?= $lang->
			saleSubTotal
?>:
                </th>
                <td align="center">
                    <span style="font-size: 24; color: blue; text-align: center"><strong><?= $cfg_currency_symbol
?></span></strong><strong><span style="font-size: 24; color: blue; text-align: center" id="str_sub_tot">
                    
                    <?= $finalSubTotal
?>
                    
                    </span></strong>
                  <input name="subtotalvta" type="hidden" id="stvta" size="6" style="text-align:center" readonly maxlength="8" value="<?= $finalSubTotal
?>"   /><input type="hidden" name="sub_tot" id="sub_tot" value="<?= $finalSubTotal
?>" />
                </td>
            </tr>
            <tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; "><?= $lang->
			tax
?>: 
                </th>
                <td>
                <?= $cfg_currency_symbol
?>
<input name="taxtot" type="text" id="taxtot" size="4" style="text-align:center" readonly maxlength="8" value="<?= $finalTax
?>"   /><input type="hidden" name="imp_tot" id="imp_tot" value="<?= $finalTax
?>" />
                </td>
            </tr>
			<tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; "><?= $lang->
			descuento
?>: 
                </th>
                <td>
                <?= $cfg_currency_symbol
?>
                <input name="descuentshow" type="text" id="descuentshow" size="6" style="text-align:center" readonly maxlength="8" value="<?= number_format($descuent)
?>"   />
                <input type="hidden" name="descuent" id="descuent" value="0" />
                <input type="hidden" name="descuentporc" id="descuentporc" value="0" /><span id="showdescporc">&nbsp;&nbsp;0</span>
			
                </td>
            </tr>
            <tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; "><?= $lang->
			saleTotalCost
?>: 
                </th>
                <td align="center">
                <span style="font-size: 24; color: blue; text-align: center" ><strong><?= $cfg_currency_symbol
?></strong></span><strong><span style="font-size: 24; color: blue; text-align: center" id="str_saleTotalCost">
                
                <?= $tot_rowTotal
?></span></strong>
                <input name="saleTotalCost" type="hidden" id="saleTotalCost" size="6" style="text-align:center" readonly maxlength="6" value="<?= $tot_rowTotal
?>"/>
                </td>
            </tr>
			<tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; ">
                    <?= $lang->vrtot
?>: 
                </th>
                <td>    
                    <input type=text name='amountpay' id='amountpay' readonly style='text-align:center'   value='' size='8'>
                </td>    
            <tr>
                <th style="vertical-align: middle; text-align: center; background-color: #A73535; "><?= $lang->
			amtChange
?>:
                </th>
                <td>
                <input type=text name='changep' id='changep' readonly style='text-align:center'   value='' size='8'>
                <input type=hidden name='j' id='j'   value='$k'><input type=hidden name='cliente' id='cliente'   value=''><input type='button' id='addsale' value='<?= $lang->
			addSale
?>' onclick='asig();'><input type=hidden name='totalvta' id='totalvta'   value='$totalvta'>
                </td>
            </tr>
            </table>
            <? /*echo "<table align='center' bgcolor='$table_bg'><tr><td align='left'><font color='white'>$lang->globalSaleDiscount</font></td>
			<td align='left'>Descuento: <input type='text' name='global_sale_discount' size='3'></td>
			<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td></tr>
			</table>";*/

			/*echo "<table border='0' bgcolor='$table_bg' align='center'>
			<tr>
			<td>
			<font color='white'>$lang->paidWith:</font> 
			</td>
			<td>
			<select name='paid_with' id='paid_with' onchange='cambpay(this);'>
			<option value='$lang->cash'>$lang->cash</option>
			<option value='$lang->check'>$lang->check</option>
			<option value='$lang->credit'>$lang->credit</option>
			<option value='$lang->giftCertificate'>$lang->giftCertificate</option>
			<option value='$lang->account'>$lang->account</option>
			<option value='$lang->other'>$lang->other</option>
			</select>
			</td>
			<td>
			<font color='white'>$lang->amtTendered:</font></td><td><input type='text' size='8' name='amt_tendered' id='amt_tendered'></td>
			</td>
			</tr>
			<tr>
			<td>
			<font color='white'>$lang->saleComment:</font>
			</td>
			<td>
			<input type=text name=comment size=25>
			</td>
			<td>
			<font color='white'>Descuento:</font></td><td align='left'><input type='text' name='global_sale_discount' size='3'></td>
			<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td>
			</td>
			</tr>

			</table>*/
			echo "<input type=hidden name='totalItemsPurchased' value='$totalItemsPurchased'>
		<input type=hidden name='totalTax' value='$finalTax'>
		<input type=hidden name='finalTotal' id='finalTotal' value='$tot_rowTotal'>
	";

			////////////// mostrar los metodos de pago
			$pospaymethod_table = "$cfg_tableprefix".'pay_method';
			$paymethod_result = mysql_query("SELECT * FROM $pospaymethod_table where cancel = 0 order by id",
				$dbf->conn);

			while ($row = mysql_fetch_assoc($paymethod_result)) {
				$paymethod_id[] = $row['id'];
				$paymethod_name[] = $row['name'];
				$paymethod_change[] = $row['change'];
				//	$brands_total[$row_paymethod['id']]=0;

			}

			//////////////////////////////////////////

?>
			<table align="center" border="0" class="KT_tngtable">
			<tr>
			<th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><div align="center"><strong><font color='white'><? echo
			"$lang->paidWith";
?></font></strong></div></th>
			<th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><div align="center"><strong><font color='white'><? echo
			"$lang->amount";
?></font></strong></div></th>
			<th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><div align="center"><strong><font color='white'><? echo
			"$lang->doc_num";
?></font></strong></div></th>
			<th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><div align="center"><strong><font color='white'><? echo
			"$lang->entity";
?></font></strong></div></th>
			<th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><div align="center"><strong><font color='white'><? echo
			"$lang->auth_no";
?></font></strong></div></th>
			</tr>
			<? for ($k = 0; $k < count($paymethod_id); $k++) {

				$id = $paymethod_id[$k];
				$name = $paymethod_name[$k];
				$change = $paymethod_change[$k];
?>  
				<tr>
				<th style="vertical-align: middle; text-align: center; background-color: #CDC442; " width="5%" nowrap>
                <?= $name
?>
				<? echo "<input type=hidden name='paymethodid[$k]'   value='$id' size='8'><input type=hidden name='change[$k]' id='change[$k]'   value='$change' size='8'><input type=hidden name='paymethodname[$k]' id='paymethodname[$k]'   value='$name' size='8'>";
?></th>
				<td><? echo "<input type=text name='amount[$k]' id='amount[$k]'   value='' size='8' onblur='cambamount(this);'>";
?></td>
				<? if ($change == 1) {
?>
					<td><? echo "<input type=text name='doc_num[$k]' id='doc_num[$k]'   value='' size='8'>";
?></td>
					<td><select name="<? echo "entity$k";
?>" id="<? echo "entity[$k]";
?>">
					<option value="0">Elija</option>
					<? $rc_detailp = mysql_query('select id, name  from pos_pay_methoddetail  where paymethodid = '.
					$id.' and cancel = 0',$conn_2);
					while ($rowdet = mysql_fetch_assoc($rc_detailp)) {
?>
						<option value="<?= $rowdet["id"]
?>"><?= $rowdet["name"]
?></option>
						<? }
?>
					</select></td>
					<td><? echo "<input type=text name='auth_num[$k]' id='auth_num[$k]'   value='' size='8'><input type='hidden' name='k' id='k' value='$k' />
				<input type='hidden' name='m' id='m' value='$k' />";
?></td>
					
					<? }
?> 
				</tr>
				<? }
			echo "<input type='hidden' name='nummp' id='nummp' value='$k' />";
?>
			<tr>
			<th style="vertical-align: middle; text-align: center; background-color: #CDC442; " width="5%" nowrap><? echo
			"$lang->saleComment";
?></th>
			<td colspan="4" ><? echo
			"<input type='text' name='comment' id='comment' size='40' />";
?></td>
			<input type='hidden' name='claveok' id="claveok" value='0'>
			</tr>
			<tr>
			<? /* echo "<td>
			<font color='white'>Descuento:</font></td><td align='left'><input type='text' name='global_sale_discount' size='3'></td>
			<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td>
			</td>";*/
?>
			</tr>
			</table>
            </form>
			<? }
		// echo "<br><center><input type='submit' value='Add Sale'></center>";

?>
</td>
</tr>
</table> 
</body>
</html>
<? }
	$dbf->closeDBlink();

}
?>


<?php if ($actionID == 'questpass') {
	if ($_POST['usuario'] == 'admin' && $_POST['passw'] == 'adminPos') {
		echo '1';
	} else {
		echo '2';
	}
}

if ($actionID == 'quest') {
	if ($IDLoc != "") {
?>
        <table>
		<tr>
		<td><? echo $lang->username
?>:</td>
		<td><input type="text" name="username" id="username" /></td>
		</tr>
		<tr>
		<td><? echo $lang->password
?>:</td>
		<td><input type="password" name="clave" id="clave" onChange="Validarsuperv_loc(document.getElementById('username').value,this.value);" /></td>
		</tr>
        </table>
		<? } // if($transacc == 2 )
}
if ($actionID == 'quest2') {
	echo 'jk';
}
if ($actionID == 'addcustomer') {
	include ("../classes/form.php");

	//VARIABLES PARA GUARDAR CUSTOMER
	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	$account_number = $_REQUEST['account_number'];
	$phone_number = $_REQUEST['phone_number'];
	$email = $_REQUEST['email'];
	$street_address = $_REQUEST['street_address'];
	$comments = $_REQUEST['comments'];
	$b = $_REQUEST['b'];
	$action = $_REQUEST['action'];
	$id = $_REQUEST['id'];
	$act = $_REQUEST['act'];
	$hj = $_REQUEST['hj'];

	$lang = new language();
	$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,
		$cfg_theme,$lang);
	$sec = new security_functions($dbf,'Sales Clerk',$lang);
	$display = new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

	if (!$sec->isLoggedIn()) {
		header("location: ../login.php");
		exit();
	}
	//set default values, these will change if $action==update.
	$first_name_value = '';
	$last_name_value = '';
	$account_number_value = '';
	$phone_number_value = '';
	$email_value = '';
	$street_address_value = '';
	$comments_value = '';
	$id = -1;

	//decides if the form will be used to update or add a user.
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
	} else {
		$action = "insert";
	}

	//if action is update, sets variables to what the current users data is.
	if ($action == "update") {
		$display->displayTitle("$lang->updateCustomer");

		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$tablename = "$cfg_tableprefix".'customers';
			$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);

			$row = mysql_fetch_assoc($result);
			$first_name_value = $row['first_name'];
			$last_name_value = $row['last_name'];
			$account_number_value = $row['account_number'];
			$phone_number_value = $row['phone_number'];
			$email_value = $row['email'];
			$street_address_value = $row['street_address'];
			$comments_value = $row['comments'];

		}

	} else {
		$display->displayTitle("$lang->addCustomer");
	}
	//creates a form object

?>
	<script language="JavaScript">
	function Validar()
	{
		if(document.getElementById("first_name").value == '')
		{
			alert('Digite los nombres del cliente'); return false; 
		}
		if(document.getElementById("last_name").value == '')
		{
			alert('Digite los apellidos del cliente'); return false; 
		}
		if(document.getElementById("account_number").value == '')
		{
			alert('Digite la Identificacion del Cliente'); return false; 
		}        
		if(document.getElementById("phone_number").value == '')
		{
			alert('Digite el numero telefonico del Cliente'); return false; 
		}
		
		if(document.getElementById("act").value != 1)
		{
			if(document.getElementById("first_name_medico").value == '')
			{
				alert('Digite los nombres del medico'); return false; 
			}
			if(document.getElementById("last_name_medico").value == '')
			{
				alert('Digite  los apellidos del medico'); return false; 
			}
			if(document.getElementById("phone_number_medico").value == '')
			{
				alert('Digite el telefono del medico'); return false; 
			}
			
			var j=document.getElementById("b").value;
			for( var i=0;i<j ;i++)
			{
				var descript = document.getElementById("itemdescription["+i+"]").value;
				if(document.getElementById("toma["+i+"]").value == "")
				{ alert('Digite la cantidad de la toma, para el producto: '+descript); return false; }
				if(document.getElementById("selecttoma["+i+"]").value == 0 )
				{ alert('Elija la presentacion de la toma, para el producto: '+descript); return false; }
				if(document.getElementById("cada["+i+"]").value == '' )
				{ alert('Digite  la frecuencia de la dosis, para el producto: '+descript); return false; }
				if(document.getElementById("selectcada["+i+"]").value == 0 )
				{ alert('Elija  el tiempo de la frecuencia, para el producto: '+descript); return false; }
				if(document.getElementById("durante["+i+"]").value == '' )
				{ alert('Digite  la duracion de la dosis, para el producto: '+descript); return false; }
				if(document.getElementById("selectdurante["+i+"]").value == 0 )
				{ alert('Elija  el tiempo de duracion, para el producto: '+descript); return false; }
				if(document.getElementById("quantity["+i+"]").value == '' )
				{ alert('Digite  la cantidad recetada, para el producto: '+descript); return false; }
				
			}
		}	// if(document.getElementById("act").value != 1)			   
		
	}
	</script>

	<? $f1 = new form('sale_ui.php?actionID=addcustomer&hj=1','POST','customers',
	'450',$cfg_theme,$lang);
	if ($titulo == 2) {
		echo '<br><br>';
		echo '<font color="#FF0000">Esta Factura Contiene Productos Cronicos... Por Favor En Lo Posible Tomar Los Datos</font>';
		//echo '<div align="center"<font color="#FF0000"><Esta Factura Contiene Productos Cronicos... Por Favor En Lo Posible Tomar Los Datos</font></div>';
	}

	//creates form parts.
	echo '<tr bgcolor="DDDDDD"><td align="center"  colspan="2"  width="150"><b>'.$lang->
		datecustom.'</b></td></tr>';
	$f1->createInputField("<b>$lang->firstName :</b> ",'text','first_name',"$first_name_value",
		'24','150');
	$f1->createInputField("<b>$lang->lastName :</b> ",'text','last_name',"$last_name_value",
		'24','150');
	$f1->createInputField("<b>$lang->accountNumber :</b> ",'text','account_number',
		"$account_number_value",'24','150');
	$f1->createInputField("<b>$lang->phoneNumber :</b> ",'text','phone_number',"$phone_number_value",
		'24','150');
	$f1->createInputField("$lang->email :",'text','email',"$email_value",'24','150');
	$f1->createInputField("$lang->streetAddress :",'text','street_address',"$street_address_value",
		'24','150');
	$f1->createInputField("$lang->commentsOrOther :",'text','comments',"$comments_value",
		'40','150');
	if ($act != 1) {
		echo '<tr bgcolor="DDDDDD"><td align="center"  colspan="2"  width="150"><b>'.$lang->
			datosmedico.'</b></td></tr>';
		$f1->createInputField("<b>$lang->firstName :</b> ",'text','first_name_medico',
			"",'24','150');
		$f1->createInputField("<b>$lang->lastName :</b> ",'text','last_name_medico',"",
			'24','150');
		$f1->createInputField("$lang->accountNumber : ",'text','cedula_medico',"",'24',
			'150');
		$f1->createInputField("<b>$lang->phoneNumber :</b> ",'text',
			'phone_number_medico',"",'24','150');
		$f1->createInputField("$lang->direccioncons :",'text','dicons',"",'40','150');
		$f1->createInputField("",'hidden','saleID',"$saleID",'40','150');
		$bgcol = 'DDDDDD';
		$algtext = 'style="text-align:center"';
?></table><table>
		<tr bgcolor="<?= $bgcol
?>">
		<td colspan="6" align="center"><b><?= $lang->posologia
?></b></td>
		</tr>
		<tr bgcolor="<?= $bgcol
?>">
		<td rowspan="2" align="center"><b><?= $lang->medicamento
?></b></td>
		<td colspan="3" align="center"><b><?= $lang->dosis
?></b></td>
		<td rowspan="2" align="center"><b><?= $lang->quantity
?></b></td>
		</tr>
		<tr bgcolor="<?= $bgcol
?>" >
		<td align="center"><b><?= $lang->tomar
?></b></td>
		<td align="center"><b><?= $lang->cada
?></b></td>
		<td align="center"><b><?= $lang->durante
?></b></td>
		</tr>
		<? $rc_itemssales = mysql_query('select * from pos_sales_items where sale_id= '.
		$saleID.'',$conn_2);
		$b = 0;

		while ($row = mysql_fetch_assoc($rc_itemssales)) {
			$rc_infoitem = mysql_query(' select item_number, item_name, cronico from pos_items where id ='.
				$row['item_id'].'',$conn_2);
			$row_item = mysql_fetch_assoc($rc_infoitem);
			if ($row_item['cronico'] == 1) // 1 producto cronico

			{
?>
				<tr bgcolor="<?= $bgcol
?>" >
				<td align="center"><?= $row_item['item_name']
?></td>
				<td align="center"> <input type="hidden" name="itemid[<?= $b
?>]" id="itemid[<?= $b
?>]" value="<?= $row['item_id']
?>" />
				<input type="hidden" name="itemdescription[<?= $b
?>]" id="itemdescription[<?= $b
?>]" value="<?= $row_item['item_name']
?>" />
				<input type="text" name="toma[<?= $b
?>]" size="2" id="toma[<?= $b
?>]" <?= $algtext
?>/><br>
				<select name="selecttoma[<?= $b
?>]" id="selecttoma[<?= $b
?>]">
				<option value="0">Elige...</option>
				<option value="1">Pastillas</option>
				<option value="2">Frasco</option>
				<option value="3">Cc</option>
				<option value="4">Cucharada</option>
				<option value="5">Cucharadita</option>
				<option value="6">Tableta</option>
				<option value="7">Capsula</option>
				<option value="8">Aplicacion</option>
				<option value="9">Gotas</option>
				<option value="10">Gragea</option>
				</select>
				</td>
				<td align="center"><input type="text" name="cada[<?= $b
?>]" size="2" id="cada[<?= $b
?>]" <?= $algtext
?> /><br>
				<select name="selectcada[<?= $b
?>]" id="selectcada[<?= $b
?>]">
				<option value="0">Elige...</option>
				<option value="1">Hora(s)</option>
				<option value="2">Dia(s)</option>
				<option value="3">Mes(es)</option>
				</select>
				</td>
				<td align="center"><input type="text" name="durante[<?= $b
?>]" size="2" id="durante[<?= $b
?>]" <?= $algtext
?> /><br>
				<select name="selectdurante[<?= $b
?>]" id="selectdurante[<?= $b
?>]">
				<option value="0">Elige...</option>
				<option value="1">Hora(s)</option>
				<option value="2">Dia(s)</option>
				<option value="3">Mes(es)</option>
				</select></td>
				<td align="center"><input type="text" name="quantity[<?= $b
?>]" size="2" id="quantity[<?= $b
?>]" <?= $algtext
?> /></td>
				</tr>
				<? $b++;

			}
		}
	} // if($act != 1)

?><input type="hidden" name="b" id="b" value="<?= $b
?>" /><? //sends 2 hidden varibles needed for process_form_users.php.
	echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='act' id = 'act' value='$act'>";
	echo '
		<tr>
		<td colspan=2 align=center><input type=submit value=Submit onClick="return Validar(this);" ></td>
		</tr>
	</table>
</center>
</form>';
	$dbf->closeDBlink();

	if ($hj == 1) {
		/*   echo $first_name;
		echo '<br>';
		echo $last_name;
		echo '<br>';
		echo $account_number;
		echo '<br>';
		echo $phone_number;
		echo '<br>';
		echo $email;
		echo '<br>';
		echo $street_address;
		echo '<br>';
		echo $comments;
		echo '<br>';*/
		$gh = 0;

		$sql = "SELECT * FROM pos_customers WHERE account_number = '$account_number'";
		$result = mysql_query($sql,$conn_2);
		if (mysql_num_rows($result) > 0) {
?>
            <script>
                alert('Cliente ya Existe !!!')
                window.opener.document.getElementById('customerDoc_list').value = <?= $account_number
?>;
                window.opener.searchCustomer(<?= $account_number
?>,4);                
                window.close();
            </script>
            <? exit;
		}

		if (mysql_query("INSERT INTO pos_customers (first_name, last_name, account_number, phone_number, email, street_address, comments) VALUES ('".
			$first_name."','".$last_name."','".$account_number."','".$phone_number."','".$email.
			"','".$street_address."','".$comments."')",$conn_2) === false) {
			$gh = 1;
			echo 'Error adicionando Cliente';

			exit;
		} else {
			$rc_custid = mysql_query('select * from pos_customers where first_name= "'.$first_name.
				'" and last_name =  "'.$last_name.'"',$conn_2);
			$custid = mysql_fetch_assoc($rc_custid);
		}
		if ($act != 1) {

			if (mysql_query("INSERT INTO pos_medical (first_name, last_name, cedula,phone, dir_consult) VALUES ('".
				$first_name_medico."','".$last_name_medico."','".$cedula_medico."','".$phone_number_medico.
				"','".$dicons."')",$conn_2) === false) {
				$gh = 1;
				echo 'Error adicionando Medico';
				exit;
			}

			if (mysql_query("update pos_sales set customer_id = ".$custid['id'].
				"  where id = ".$saleID."",$conn_2) === false) {
				$gh = 1;
				echo 'Error Actualizando Factura';
				echo "update pos_sales set customer_id = ".$custid['id']."  where id = ".$saleID.
					"";
				exit;
			}
			for ($k = 0; $k < $b; $k++) {
				$rc_itemsales = mysql_query('update pos_sales_items set tomadosis = '.$toma[$k].
					', presenttoma  = '.$selecttoma[$k].', frecuenciadosis  = '.$cada[$k].
					', tiempofcia  = '.$selectcada[$k].', duraciondosis  = '.$durante[$k].
					', tiempoduracion  = '.$selectdurante[$k].', qtyrecetada  = '.$quantity[$k].
					'   where sale_id= "'.$saleID.'" and item_id =  "'.$itemid[$k].'"',$conn_2);

			}
		} // if($act != 1)
		if ($gh == 0) {
?>
			<script type="text/javascript">
			alert("Cliente Adicionado satisfactoriamente");
            window.opener.document.getElementById('customerDoc_list').value = <?= $account_number
?>;
            window.opener.searchCustomer(<?= $account_number
?>,4);
			window.close();
			</script>
			<? }
	}
} // if($actionID=='addcustomer')
if ($actionID == 'selectcustomer') {
?>
<table width="100%" class="KT_tngtable">
<tr>
<th align="center" style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap>
<?php if ($tipo_vta == '2') {
		echo $lang->Paciente;
	} else {
		echo $lang->orderBy;
	}
?>
</th>
<td >

<select name="customer_list" id="customer_list">
			<? if ($tipo_vta == '2') {
		echo '<option value="">Seleccione...</option>';
		$rc_customer = mysql_query('select first_name, last_name, id, account_number from  pos_pacientes ',
			$conn_2);
	} else {
		$rc_customer = mysql_query('select first_name, last_name, id, account_number from  pos_customers ',
			$conn_2);
	}
	while ($rowc = mysql_fetch_assoc($rc_customer)) {
		echo '<option value="'.$rowc["id"].'"';
		if (!(strcmp($rowc["id"],$customer_list))) {
			echo $selected = "selected=\"selected\"";
		}
		echo '>'.$rowc["account_number"].'   '.$rowc["first_name"].' '.$rowc["last_name"].
			'</option>';
	}
?>
</select>
<?php if ($tipo_vta == '1') {
?>
&nbsp;&nbsp;&nbsp;<a href="sale_ui.php?actionID=addcustomer&act=1" onClick="ventanaSecundaria(this); return false" target="_parent"><img src="../images/edit_add.png" border="0" style="cursor: pointer;" title="Agregar Cliente"/></a>
<?php }
?>
<!--
&nbsp;&nbsp;&nbsp;<img onclick="updCustomer()" src="../images/recur.png" border="0" style="cursor: pointer;" title="Actualizar"/></a>
-->

</td>
</tr>
</table>
	<? }
if ($actionID == 'pedirclave') {
?>
	<table>
	<tr>
	<td><? echo $lang->username
?>:</td>
	<td><input type="text" name="username" id="usernameadmon" size="15" /></td>
	</tr>
	<tr>
	<td><? echo $lang->password
?>:</td>
	<td><input type="password" name="clave" id="claveadmon" size="15"/></td>
	</tr>
	<tr>
	<td colspan="2">
	<div align="center">
	<input type="submit" name="button" id="button" value="Enviar" onClick="return Validaradmon(2);">
	</div></td>
	</tr>
	</table>

	<? }

if ($actionID == 'ListItemTable') {
	$table_bg = $display->sale_bg;
	$items_table = "$cfg_tableprefix".'items';
	$almacen_pac = $dbf->idToField('pos_pacientes','almacenid',$customer_list);
?>
<table border='0'  cellspacing='0' cellpadding='2' align='center' class="KT_tngtable" bgcolor='<?= $table_bg
?>' width="100%">
        <?php //
	if ($tipo_vta == '2') {
		$sqlTvta = " AND tipo_vta = 2";
		if ($customer_list) {
			$sqlTvta .= " AND customer_id = '$customer_list' AND formula = '$numFormula'";
		}
	} else {
		$sqlTvta = ' AND tipo_vta = 1';
	}
	$rc_saleopen = mysql_query('select id  from pos_sales where sold_by = '.$userId.
		' and status = 0  '.$sqlTvta,$conn_2);
	$saleopen = mysql_fetch_assoc($rc_saleopen);
	if ($saleopen['id'] != '')
		$sale_id = $saleopen['id'];
	else
		$sale_id = '';
	//    if ($sale_id == '')
	//        exit;

?>    
            <tr>
            <thead>
            <? if ($tipo_vta == '2') {
?>    
                <th nowrap><?= $lang->typeVta
?></th>
            <?php }
?>             
                <th><?= $lang->itemID
?></th>
            	<th><?= $lang->itemName
?></th>
            	<th><?= $lang->pvc
?></th>
            	<th><?= $lang->porcdesto
?></th>
            	<th><?= $lang->vlrdsto
?></th>
            	<th><?= $lang->vlrcondsto
?></th>
            	<th><?= $lang->porciva
?></th>
            	<th><?= $lang->vlriva
?></th>
            	<th><?= $lang->pvp
?></th>
            	<th nowrap><?php if ($tipo_vta == '2') {
?><?= $lang->disp
?>&nbsp;&nbsp;<?= $lang->formu
?> (P) <?php }
?>&nbsp;&nbsp;<?= $lang->cant;
?>&nbsp;&nbsp;<?= $lang->fraccion
?></th>
            	<th><?= $lang->past
?></th>

            	<th><?= $lang->vlrtot
?></th>
            	<th><?= $lang->cancel
?></th>
            </tr>
            </thead>
        <?php //
	if ($sale_id != '' and $item != '') {
		if ($tipo_vta == '2') {
			if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
				$rc_positems = mysql_query("select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_vta as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".
					$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'",
					$conn_2);
			} else {
				$rc_positems = mysql_query("select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_evento as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".
					$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'",
					$conn_2);
			}
		} else {
			$rc_positems = mysql_query('select * from pos_items where item_number = '.$item.
				'',$conn_2);
		}
		$positems = mysql_fetch_assoc($rc_positems);
		$temp_item_tax = $positems['tax_percent'] / 100 * $positems['unit_price'];
		$costtot_item = $positems['unit_price'];
		$salesdetail_table = $cfg_tableprefix.'sales_items';
		$field_names = array('sale_id','item_id','quantity_purchased','item_unit_price',
			'item_buy_price','item_tax_percent','item_total_tax','item_total_cost',
			'unit_sale','sale_frac');
		$field_data = array($sale_id,$positems['id'],1,$positems['unit_price'],$positems['buy_price'],
			$positems['tax_percent'],$temp_item_tax,$costtot_item,1,$positems['pack']);
		$dbf->insert($field_names,$field_data,$salesdetail_table,false);

	}

	$query = "select * from pos_sales_items where sale_id = ".$sale_id.
		" order by id desc";
	//echo "select * from pos_sales_items where sale_id = ".$sale_id."";
	$result_posslaesitem = mysql_query($query);
	$k = 0;
?>
        <input type="hidden" name="sale_id" id="sale_id" value="<?= $sale_id
?>"/>
        <tbody>
        <?php $lins = 0;
	$tot_temp_sindsto = 0;
	$tot_valdsto = 0;
	$tot_temp_price = 0;
	$tot_valimp = 0;
	$finalTax = 0;
	$tot_temp_pricepub = 0;
	$tot_rowTotal = 0;
	$qtyPro = 0;
	while ($row_item = mysql_fetch_assoc($result_posslaesitem)) {
		$lins++;
		if ($row_item['id'] == $saitid) {
			//$queryupd = 'update pos_sales_items set quantity_purchased = -'.$row_item['quantity_purchased'].'' where id = '.$saitid.'';
			// echo 'update pos_sales_items set quantity_purchased = 98 where sale_id = '.$sale_id.' and item_id = '.$saleitemid.'';
			$queryupd = "DELETE FROM pos_sales_items WHERE id = $saitid";
			$result_queryupd = mysql_query($queryupd);
			mysql_query("UPDATE pos_sales SET items_purchased = items_purchased - 1 where id = $sale_id");
		}

		if ($row_item['id'] == $saitemid) {

			if (trim($row_item['unit_sale']) == trim($tipopast)) {
				$pack = 1;
			} else {
				$pack = $pack;
			}

			if ($tipopast == 2) {

				$precunit = $pvpfin / $pack;
				$prcomp = $row_item['item_buy_price'] / $pack;

			} else {
				$precunit = $pvpfin * $pack;
				$prcomp = $row_item['item_buy_price'] * $pack;
			}

			$temp_taxN = $dbf->idToField('pos_sales_items','item_tax_percent',$saitemid);
			$valimpN = number_format(($precunit) * (($temp_taxN / 100)),0,'','');

			$pvptot = ($precunit + $valimpN) * $qty;

			$queryupd = 'update pos_sales_items set quantity_purchased = '.$qty.
				', unit_sale = '.$tipopast.', item_unit_price = '.$precunit.
				', item_total_tax = '.$valimpN * $qty.',item_total_cost = '.$pvptot.
				', item_buy_price = '.$prcomp.',qtyrecetada = '.$_REQUEST['qtyreceta'.$cont].
				' where id = '.$saitemid.' and item_id = '.$saleitemid.'';

			$result_queryupd = mysql_query($queryupd);
		}
		$temp_item_id = $row_item['item_id'];
		$idpossalesitems = $row_item['id'];
		$Saleid = $row_item['sales_id'];
		$tipoVenta = '<span style="font-size: 13px"><strong>Vta</strong></span>';

		$itipo_Vta = 1;
		if ($tipo_vta == '2') {
			if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
				$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_vta as unit_price, pos_items.pack, pos_items.quantity, pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
					$row_item['item_id'].
					"' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
			} else {
				$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_evento as unit_price, pos_items.pack, pos_items.quantity, pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
					$row_item['item_id'].
					"' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
			}
			$result = mysql_query($sql,$conn_2);
			$num_rows = mysql_num_rows($result);
			$srtEvent = 'Disp.';
			if ($num_rows > 0) {
				$saleopen = mysql_fetch_assoc($result);
				if ($row_item['qtyrecetada'] > 0) {
					if ($row_item['tipo'] == '3') {
						$temp_price = $saleopen['price_evento'];
						$temp_sindsto = $saleopen['price_evento'];
						$srtEvent = 'D. Evto';
					} else {
						$temp_price = $saleopen['unit_price'];
						$temp_sindsto = $saleopen['unit_price'];
						$srtEvent = 'Disp.';
					}
				} else {
					if (DISTRI_VTA) {
						$temp_price = $dbf->idToField($items_table,'unit_price',$temp_item_id);
						$temp_sindsto = $dbf->idToField($items_table,'unit_price',$temp_item_id);
					} else {
						$temp_price = $saleopen['unit_price'];
						$temp_sindsto = $saleopen['unit_price'];
						$srtEvent = 'Disp.';
					}
				}
				if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
					$tipoVenta = '<span style="font-size: 13px;cursor:pointer" id="tipoDisp'.$k.
						'" onclick="cambioDispe('.$k.','.$row_item['tipo'].')"><strong>'.$srtEvent.
						'</strong></span>';
				} else {
					$tipoVenta = '<span style="font-size: 13px;cursor:pointer" id="tipoDisp'.$k.
						'" ><strong>'.$srtEvent.'</strong></span>';
				}
				$itipo_Vta = 2;
			}
			if (DISTRI_VTA) {
				$temp_price = $dbf->idToField($items_table,'unit_price',$temp_item_id);
				$temp_sindsto = $dbf->idToField($items_table,'unit_price',$temp_item_id);
			}
		} else {
			$temp_price = $dbf->idToField($items_table,'unit_price',$temp_item_id);
			$temp_sindsto = $dbf->idToField($items_table,'unit_price',$temp_item_id);
		}

		$temp_tax = $dbf->idToField($items_table,'tax_percent',$temp_item_id);
		$preciocompra = $dbf->idToField($items_table,'buy_price',$temp_item_id);
		$temp_item_name = $dbf->idToField($items_table,'item_name',$temp_item_id);
		$temp_item_code = $dbf->idToField($items_table,'item_number',$temp_item_id);

		$inveQty = $dbf->idToField($items_table,'quantity',$temp_item_id);
		//$temp_pack=$dbf->idToField($items_table,'pack',$temp_item_id);
		$temp_pak = mysql_query("select pack from pos_items where id = ".$temp_item_id.
			"",$dbf->conn);
		//echo "select pack from pos_items where id = ".$temp_item_id."";
		$rw_pack = mysql_fetch_assoc($temp_pak);
		$temp_pack = $rw_pack["pack"];
		$temp_quantity = $dbf->idToField('pos_sales_items','quantity_purchased',$idpossalesitems);
		$formu_quantity = $dbf->idToField('pos_sales_items','qtyrecetada',$idpossalesitems);

		if ($temp_quantity < 0)
			$canc = 1;
		else
			$canc = 0;

		//VARIABLE PARA DESCUENTO POR PRODUCTO
		$SQL = "SELECT SUM(percent_off) as dcto FROM pos_discounts WHERE item_id = '$temp_item_id'";
		$dcto_item = mysql_query($SQL,$dbf->conn);
		$rc_dcto = mysql_fetch_assoc($dcto_item);
		$temp_discount = $rc_dcto['dcto'];
		//VALOR DESCUENTO
		$valdsto = number_format($temp_sindsto * ($temp_discount / 100),0,'','');

		$temp_packing = $dbf->idToField('pos_sales_items','unit_sale',$idpossalesitems);
		if ($temp_packing == 2) {

			//VALOR CON DESCUENTO
			$temp_price2 = ($temp_sindsto - $valdsto) / $temp_pack;
			//VALOR IVA DEL PRODUCTO
			$valimp = number_format(($temp_price2) * (($temp_tax / 100)),0,'','');
			$temp_pricepub = (($temp_price2 + $valimp));
		} else {
			//VALOR CON DESCUENTO
			$temp_price2 = ($temp_sindsto - $valdsto);
			//VALOR IVA DEL PRODUCTO
			$valimp = number_format(($temp_price2) * (($temp_tax / 100)),0,'','');
			$temp_pricepub = ($temp_price2 + $valimp);
		}

		//VALOR IVA DEL PRODUCTO
		$valimp = number_format(($temp_price2) * (($temp_tax / 100)),0,'','');

		$subTotal = $temp_price2 * $temp_quantity;
		$tax = $subTotal * ($temp_tax / 100);
		$rowTotal = $subTotal + $tax;
		$rowTotal = number_format($rowTotal,0,'','');

		$pak = $_POST['$pack'.$k.''];
		$past = $item_info[5];
		$showitem = $item_info[6];
		$finalSubTotal += $subTotal;

		$finalTotal += $rowTotal;
		$totalItemsPurchased += $temp_quantity;
		$resto = substr($temp_item_name,0,45);

		$temp_sindsto2 = number_format($temp_sindsto,0,'','');

		$valimp2 = $valimp;
		$temp_pricepub2 = number_format($temp_pricepub,0,'','');
		$vlrtot = $temp_pricepub * $temp_quantity;

		//	if($temp_item_code == $temp_item_code) $showitem.$k = 1;
		/*if($k == $kk) $showitem.$k = 1;
		else $showitem.$k = 0; */
		//{
		//  if($can!=1) {

		if ($formu_quantity > '0' && $itipo_Vta == '2') {
			$strColortr = '#FFFFFF';
		}
?>
            <tr style="background-color: #LKIKEI;">
            <input type="hidden" value="<?= $itipo_Vta
?>" name="itipovta[<?= $k
?>]" id="itipovta<?= $k
?>" />
			<? if ($canc == 1)
			$readon = 'readonly';
		else
			$readon = '';
		if ($tipo_vta == '2') {
?>
                <td align='center' nowrap style="text-align: right;color: white;  font-weight: bold;"><?= $tipoVenta
?></td>                    
                    <?php }
?>      
                <td align='center' nowrap style="text-align: right;color: white;  font-weight: bold;"><?= $temp_item_code
?></td>
				<td align='left' nowrap style="text-align: right;color: white;  font-weight: bold;"><?= $resto
?></td>
				<td align='center' nowrap><input type=text name='price<?= $k
?>' style='text-align:center' readonly value='<?= $temp_sindsto2
?>' size='8'></td>
				<td nowrap style="text-align: right;color: white;  font-weight: bold;">0 <?= $lang->
		sigporc
?></td>
				<td nowrap style="text-align: right;color: white;  font-weight: bold;"><?= number_format($valdsto,
		0,'','');
?></td>
				<td nowrap ><input type=text name='price<?= $k
?>' readonly style='text-align:center' id='pricedcto<?= $k
?>' value='<?= number_format($temp_price2,0,'','');
?>' size='8'></td>
				<td nowrap><input type=text id="tax<?= $k
?>" name='tax<?= $k
?>' style='text-align:center;width: 25px;'  readonly  value='<?= $temp_tax
?>' size='5'></td>
				<td nowrap><input type=text id="valimp<?= $k
?>" name='valimp<?= $k
?>' style='text-align:center;width: 35px;'  readonly  value='<?= $valimp2
?>' size='6'></td>
				<td align='center' nowrap ><input type=text name='price<?= $k
?>' readonly style='text-align:center' value='<?= $temp_pricepub2
?>' size='8'></td>
				<td nowrap>

<? if ($tipo_vta == '2' && $itipo_Vta == '2') {

			$disableFormu = '';
			$readOnlyqty = '';

			if ($row_item['toWS']) {
				$disableFormu = 'readonly';

				if ($row_item['quantity_purchased'] > 0) {
					$temp_quantity = $row_item['quantity_purchased'];
					$temp_quantityB = $row_item['qtyrecetada'] - $row_item['qtytoWS'];
				} else {
					$temp_quantity = $row_item['quantity_purchased'];
					$temp_quantityB = $row_item['qtyrecetada'] - $row_item['qtytoWS'];
				}

				if ($temp_quantity < 0) {
					$temp_quantity = 0;
					$temp_quantityB = 0;
					$readOnlyqty = 'readonly';
				} else {
					$readOnlyqty = '';
				}
			} else {
				$temp_quantity = $row_item['quantity_purchased'];
				$temp_quantityB = $row_item['qtyrecetada'];
			}
?>
<input type=text name='dispo<?= $k
?>' id='dispo[<?= $k
?>]' readonly  style='text-align:center; width: 25px;' value='<?= number_format($inveQty,
			0,'','');
?>' size='3'>

<input type=text name='orden<?= $k
?>' id='orden[<?= $k
?>]' style='text-align:center; width: 25px;' value='<?= number_format($formu_quantity,
			0,'','');
?>' size='3' <?= $disableFormu
?> onchange='validFormulada(<?= $k
?>,<?= $temp_quantity
?>)'> (<?= number_format($temp_quantityB,'2',',','')
?>)
<? } else {
			if ($tipo_vta == '2') {
?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }
?>
<input type="hidden" name='dispo<?= $k
?>' id='dispo[<?= $k
?>]' <?= $readon
?>  style='text-align:center; width: 25px;' value='<?= number_format($inveQty,0,
			'','');
?>' size='3'>
    <input type="hidden" name='orden<?= $k
?>' id='orden[<?= $k
?>]' value='0'>
<?php }
?>
                
                <input type=text name='quantity<?= $k
?>' id='qty[<?= $k
?>]' onchange="validQtyInv(this.value,<?= $k
?>,'<?= $temp_quantityB
?>')"  <?= $readon
?>  style='text-align:center; width: 25px;' value='<?= number_format($temp_quantity,
		0,'','');
?>' size='3' onchange="updateitemsale(<?= $k
?>)">

(<?= $temp_pack
?>)</td>
				<td nowrap align='center'><input type='hidden' name='pack<?= $k
?>' id='pack[<?= $k
?>]' value='<?= $temp_pack
?>'/> 
                    <select name='past<?= $k
?>' id='past[<?= $k
?>]' onchange="updateitemsale(<?= $k
?>)">
                        <option value="1"
            <?php if (!(strcmp("1",$temp_packing))) {
			echo $selected = "selected=\"selected\"";
		}
?>
                        >Unidad</option>
            <?php if ($temp_pack != 1)
?>
                        <option value="2"
            <?php 
			if (!(strcmp("2",$temp_packing))) {
				echo $selected = "selected=\"selected\"";
			}
?>
                        >Frac</option>
                    </select>
                </td>

				<td align='center' nowrap><font color='white'><b><?= $cfg_currency_symbol.
		number_format($vlrtot,0)
?></b></font>
				<input type='hidden' name='temp_pricepub2<?= $k
?>' id='pvpfin[<?= $k
?>]' value='<?= $temp_price2
?>'/>
				<input type='hidden' name='preciocompra<?= $k
?>' id='preciocompra[<?= $k
?>]' value='<?= $preciocompra
?>'/>
				</td>
                <?php //			  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>
		if ($row_item['toWS']) {
?>
                <input type='hidden' name='item_id<?= $k
?>' id='item_id[<?= $k
?>]' value='<?= $temp_item_id
?>'>
				<input type='hidden' name='idpossalesitems<?= $k
?>' id='idpossalesitems[<?= $k
?>]' value='<?= $idpossalesitems
?>'>
				<input type='hidden' name='<?= $k
?>' value='<?= $k
?>'>
<td align="center">FORMU</td>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?= $k
?>" />
<?php } else {
			if ($canc == 0) {
?>
                <input type='hidden' name='item_id<?= $k
?>' id='item_id[<?= $k
?>]' value='<?= $temp_item_id
?>'>
				<input type='hidden' name='idpossalesitems<?= $k
?>' id='idpossalesitems[<?= $k
?>]' value='<?= $idpossalesitems
?>'>
				<input type='hidden' name='<?= $k
?>' value='<?= $k
?>'>
				<td align='center'><a href=javascript:void(0)  class=InvUpText ><font color="#FFFFFF"></font></a>
                <img src="../images/cancel.png" border="0" title="<?= $lang->
				cancel
?>"   onClick=javascript:cancelitemsale(<?= $k
?>);  style="cursor:pointer"/>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?= $k
?>" />
				
				<? } else {
?>
				<td colspan="2" align="center" nowrap>
                <input type="hidden" value="0" name="ItemOn" id="ItemOn<?= $k
?>" />
                <font color="white">A N U L A D O</font>
                </td>
				
				<? }
		}
?>
                <input type='hidden' name='showitem<?= $k
?>' id='showitem<?= $k
?>' value='<?= $showitem
?>' />
				</td>
            </tr>
			<? //	 }
		if ($can == 1) {
			//echo '<tr><td>dsds</td><td>'.$k.'</td></tr>';

		}
		//}
		if ($canc == 0) {
			if ($row_item['qtyrecetada'] == 0) {
				$tot_temp_sindsto += $temp_sindsto;
				$tot_valdsto += $valdsto;
				$tot_temp_price += $temp_price2;
				$tot_valimp += $valimp;
				$finalTax += $tax;
				$tot_temp_pricepub += $temp_pricepub;
				$tot_rowTotal += $vlrtot;
				$qtyPro += $temp_quantity;
			} else {
				$tot_temp_sindstoD += $temp_sindsto;
				$tot_valdstoD += $valdsto;
				$tot_temp_priceD += $temp_price2;
				$tot_valimpD += $valimp;
				$finalTaxD += $tax;
				$tot_temp_pricepubD += $temp_pricepub;
				$tot_rowTotalD += $vlrtot;
				$qtyProD += $temp_quantity;
			}
			$tot_temp_quantity += $temp_quantity;
			$aa[$k] = $temp_pricepub;
		}
		// if($showitem.$k == 0)

		$k++;
	}

	$rc_tax = mysql_query('select pos_tax_rates.tax_rates_id  , pos_tax_rates.tax_rate from pos_tax_class, pos_tax_rates where pos_tax_rates.tax_class_id = pos_tax_class.tax_class_id and pos_tax_class.tax_class_id = 1',
		$conn_2);
	$jh = 0;
	$number = mysql_num_rows($rc_tax);
	if ($number) {
		while ($row4 = mysql_fetch_assoc($rc_tax)) {
			for ($k = 0; $k < $num_items; $k++) {
				$item_info = explode(' ',$_SESSION['items_in_sale'][$k]);
				$temp_item_id = $item_info[0];
				$temp_tax = $item_info[2];
				if ($temp_tax == $row4["tax_rate"]) {
					$taxa += $aa[$k];
					echo "<input type=hidden name='taxid".$row4["tax_rates_id"]."' id=''   value='".
						$row4["tax_rates_id"]."'>";
					echo "<input type=hidden name='tax".$row4["tax_rates_id"]."' id=''   value='".$taxa.
						"'>";
					echo "<input type=hidden name='taxrate".$row4["tax_rates_id"].
						"' id=''   value='".$row4["tax_rate"]."'>";

				}
			}
			$taxa = 0;
			//					 echo $row4["tax_rate"].' victor'.'<br>';
			$jh++;
		}
		echo "<input type=hidden name='jh' id=''   value='".$jh."'>";
	}
	// $taxa=$rowTotal;

	//////////////////////////////////////////////

	$numcolTotal = 2;
	if ($tipo_vta == '2') {
		$numcolTotal = 3;
	}
?>
        </tbody>
        
<?php if ($tipo_vta == '2') {
?>        

        <thead>
            <tr> 
                <th colspan="<?= $numcolTotal
?>" style="text-align: right;"><?= $lang->totDis
?></th>
				<th style="text-align: right;"><b><?= number_format($tot_temp_sindstoD,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valdstoD,0)
?></th>
				<th style="text-align: right;"><?= number_format($tot_temp_priceD,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valimpD)
?></th>
                <th style="text-align: right;"><?= number_format($tot_temp_pricepubD)
?></th>
				<th style="text-align: right;"><?= $qtyProD
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_rowTotalD)
?></th>
				
				<th style="text-align: right;">
	
                </th>
            </tr>
        </thead>
<?php }
?>        
        <thead>
            <tr> 
                <th colspan="<?= $numcolTotal
?>" style="text-align: right;"><?= $lang->tot
?></th>
				<th style="text-align: right;"><b><?= number_format($tot_temp_sindsto,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valdsto,0)
?></th>
				<th style="text-align: right;"><?= number_format($tot_temp_price,0)
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valimp)
?></th>
				<th style="text-align: right;"><?= number_format($tot_temp_pricepub)
?></th>
				<th style="text-align: right;"><?= $qtyPro
?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_rowTotal)
?></th>

				<th style="text-align: right;">
                <input type="hidden" value="<?= $lins
?>" name="totLin" id="totLin" />
                <input name="totvta" type="hidden" id="totvta" value="<?= $tot_temp_pricepub
?>"/>
            		<input name="tots" type="hidden" id="tots" value="<?= $tot_rowTotal
?>"/>
                    <input name="customerid" type="hidden" id="customerid" value="<?= $customer_list
?>"/>
                    <input name="devolucionid" type="hidden" id="devolucionid" value="<?= $devolucion
?>"/>
		
                </th>
            </tr>
        </thead>
		<? $aa = $finalSubTotal;
	$finalSubTotal = $tot_rowTotal;
	$finalTax = number_format($finalTax,0,'','');
	$totalvta = $tot_rowTotal;
	$finalTotal = number_format($finalTotal,0,'','');
?>
        </table>
<?php exit;
}

if ($actionID == 'modifiItem') {
	$items_table = "$cfg_tableprefix".'items';
	if ($tipo_vta == '2' && $_REQUEST['qtyreceta'] > 0) {
		$almacen_pac = $dbf->idToField('pos_pacientes','almacenid',$customer_list);
		if ($almacen_pac == $cfg_locationid || $almacen_pac == '999') {
			$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_vta as unit_price, pos_items.pack, pos_items.quantity, pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
				$saleitemid."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
		} else {
			$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_evento as unit_price, pos_items.pack, pos_items.quantity, pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".
				$saleitemid."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
		}
		$result = mysql_query($sql,$conn_2);
		$num_rows = mysql_num_rows($result);
		if ($num_rows > 0) {
			$saleopen = mysql_fetch_assoc($result);
			if ($_POST['tipoDisp'] == '3') {
				$temp_price = $saleopen['price_evento'];
				$temp_sindsto = $saleopen['price_evento'];
				$strTipo = ",tipo = 3";
			} else {
				$temp_price = $saleopen['unit_price'];
				$temp_sindsto = $saleopen['unit_price'];
				$strTipo = ",tipo = 2";
			}
		} else {
			$temp_price = $dbf->idToField($items_table,'unit_price',$saleitemid);
			$temp_sindsto = $dbf->idToField($items_table,'unit_price',$saleitemid);
		}
	} else {
		$temp_price = $dbf->idToField($items_table,'unit_price',$saleitemid);
		$temp_sindsto = $dbf->idToField($items_table,'unit_price',$saleitemid);
	}
	$taximpo = $temp_price * ($dbf->idToField($items_table,'tax_percent',$saleitemid) /
		100);

	if ($_REQUEST['qtyreceta'] == 0)
		$qtyPedido = 1;
	else
		$qtyPedido = $_REQUEST['qtyDespa'];
	echo $queryupd = 'update pos_sales_items set item_unit_price = '.$temp_price.
		', item_total_tax = '.$taximpo * $qtyPedido.',item_total_tax = '.($temp_price +
		$taximpo) * $qtyPedido.',quantity_purchased = '.$qtyPedido.', qtyrecetada = '.$_REQUEST['qtyreceta'].
		' '.$strTipo.'  where id = '.$saitemid.' ';

	$result_queryupd = mysql_query($queryupd);

}
?>
