<?php session_start();
			define(FOLDER_RAIZ,'../');
			
/**
 * @coment 		:SE AGREGA OPCION PARA PEDIR CANTIDAD DESDE EL PRINCIPIO
 * @autor 		:@wizanchez,luiswebcam@hotmail.com
 * @fecha 		:Sep 27 de 2014
 */

																		define(HIDDEN,'hidden');
																		
																		#####################################################
																		##	SI HABILITAMOS LA BUSQUEDA POR PLU
																				define(HABILITAR_BUSQUEDA_PLU,false);
																		#####################################################
																		
																		
																		#####################################################
																		##	PARA PODER FACURAR CON TODAS LAS CANTIDADES PEDIDAS EN CERO
																				define(FACTURAR_CON_TODO_INV_EN_CERO,true);
																		#####################################################

											#----------------------------------------------------------------------------------------
											#	VALIDACION SI SOLO ACEPTA VENTA DIRECTA
														define(DF_ACEPTAR_UNICAMENTE_VENTA_DIRECTA,true);
											#----------------------------------------------------------------------------------------													
											#----------------------------------------------------------------------------------------
											#	MINIMO DE LETRAS DEL AUTOCOMPLETE
						 						define(DF_MINIMO_LETRA_AUTOCOMPLETE_ITEM, 3);	
														
											#----------------------------------------------------------------------------------------							
											#----------------------------------------------------------------------------------------
											#	PARA ENVIAR EL ID DE LA LISTA DE PRECIOS 
						 						define(DF_LISTA_PRECIO_ID, 1);	
														
											#----------------------------------------------------------------------------------------							
											#----------------------------------------------------------------------------------------
											#	SINCRONIZAR_WEBSERVICE
						 						define(DF_SINCRONIZAR_WEB_SERVICE, true);	
														
											#----------------------------------------------------------------------------------------							
											#	VALIDACION DE LAS COLUMNAS [none,block]
						 						define(DF_COL_FRACCION,'' );	
						 						define(DF_COL_UNIDAD_VENTA, 'none');
						 					#	PARA OCULTAR EL REGISTRO DE TIPO VENTA [none,block]
						 						define(DF_MODO_VENTA_PEDIR_CLIENTE_ANULAR_VENTA, 'none');	
						 					
						 					# PARA SABER SI SE MUESTRO EL BOTON LINMPIAR O COLOCAR LA CAJA EN BLANCO [true,false]
						 						define(DF_MOSTRAR_BOTON_LIMIAR_AUTOCOMPLETE, false);
						 					#	PARA LA COLUMNA MEDIO DE PAGO, DOCUMENTO [none,block]
						 						define(DF_MEDIO_PAGO_COL_DOCUMENTO, 'none');
						 					#	PARA LA COLUMNA MEDIO DE PAGO, AUTORIZA [none,block]
						 						define(DF_MEDIO_PAGO_COL_AUTORIZA, 'none');
						 					#	ENTIDAD
						 						define(DF_MEDIO_PAGO_COL_ENTIDAD, 'none');
						 					#	PARA MOSTRAR EL TECLADO DEL NUMERO, [true,false]
						 						define(DF_MOSTRAR_TECLADO_NUMERO_PAGO, true);

						 					#	PARA CARGAR EN EL AUTOCOMPLETAR LOS PRODUCTOS DE MAYOR VENTA AUTOMATICAMENS, [true,false]
						 						define(DF_ACTIVAR_ITEM_MAYOR_ROTACION, true);
						 					
														
											#----------------------------------------------------------------------------------------							
						

		#################################################################################################
		##	CARGO EL FRAMEWORK
        	require_once	FOLDER_RAIZ.'framework_jvm/Fjvm_cargar.frj.php';
		#################################################################################################

						#######################################################################################################
						##	INCLUIMOS LAS LIBRERIAS DEL FRAMEWORK	
								$a_vec_libreria		=array(
															'formulario'
															);
															
								Fjvm_cargar::fjvm_importar_libreria($a_vec_libreria,FOLDER_RAIZ);


$userId = $_SESSION['session_user_id'];
if ($_GET['reloadFrame']) {
	header("location: sale_ui.php");
}
define(URL_RAIZ_FONDO,'../');
include('../classes/TextDecoracion.php'); 
include('../classes/stylos_new.class.php'); 
	$ObjDeco=new TextDecoracion();		

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
include ("Formulas.class.php");


$lang = new language();
define('DCTO_ITEM',0);
define('DISTRI_VTA',0);
//OBTENCION DE VARIABLES POR METODO POST - GET
$tipo_vta 						= DF_ACEPTAR_UNICAMENTE_VENTA_DIRECTA===true?1:$_REQUEST['tipo_vta'];
$tipo_disp 						= $_REQUEST['tipo_disp'];


$itemsearch_2 					= $_REQUEST['itemsearch_2'];
$item 							= $_REQUEST['item'];
$consitem 						= $_REQUEST['consitem'];
$clearfields 					= $_REQUEST['clearfields'];
$customer_list					= $_REQUEST['customer_list'];
$inputString					= $_REQUEST['inputString'];
$sale_id 						= $_REQUEST['sale_id'];

$can 							= $_REQUEST['can'];
 $sale_id 						= $_REQUEST['sale_id'];
$pack 							= $_REQUEST['pack'];
$preciocompra 					= $_REQUEST['preciocompra'];
$pvpfin 						= $_REQUEST['pvpfin'];
$qty 							= $_REQUEST['qty'];
$saitemid 						= $_REQUEST['saitemid'];
$saleitemid 					= $_REQUEST['saleitemid'];
$tipopast 						= $_REQUEST['tipopast'];
$actionID 						= $_REQUEST['actionID'];
$order_customer_code 			= $_REQUEST['order_customer_code'];
$act 							= $_REQUEST['act'];
$saitid 						= $_REQUEST['saitid'];
$IDLoc 							= $_REQUEST['IDLoc'];
$numFormula 					= $_REQUEST['num_formu'];

$v_cant_pru 					= $_REQUEST['cant_item_form'];

if (!$tipo_vta) {
	$tipo_vta = 2;
}

if ($actionID == 'loadfi') {
	//
}

//updating row for an item already in sale.
if (isset($_REQUEST['update_item'])) {
	$k 				= $_GET['update_item'];
	$new_price 		= $_POST["price$k"];
	$new_tax 		= $_POST["tax$k"];
	$new_quantity 	= $_POST["quantity$k"];
	$past 			= $_POST["past$k"];
	$showitem 		= $_POST["showitem$k"];

	$item_info 		= explode(' ',$_SESSION['items_in_sale'][$k]);
	$item_id 		= $item_info[0];
	$percentOff 	= $item_info[4];

	$_SESSION['items_in_sale'][$k] = $item_id.' '.$new_price.' '.$new_tax.' '.$new_quantity.
		' '.$percentOff.' '.$past.' '.$showitem;
	echo "<script>window.open('sale_ui.php','_self')</script>";
	//	header("location: sale_ui.php");

}

if (isset($_GET['discount'])) {
	$discount = $_POST['global_sale_discount'];

	if (is_numeric($discount)) {
		for ($k = 0; $k < count($_SESSION['items_in_sale']); $k++) {
			$item_info 	= explode(' ',$_SESSION['items_in_sale'][$k]);
			$item_id 	= $item_info[0];
			$new_price 	= $item_info[1] * (1 - ($discount / 100));
			$tax 		= $item_info[2];
			$quantity 	= $item_info[3];
			$percentOff = $item_info[4];
			$past 		= $item_info[5];
			$showitem 	= $item_info[6];
			$new_price 	= number_format($new_price,0);

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
/**
 * FUNCIONES JS ADICIONADAS
 * @fecha Sep 25 de 2014
 */
include ('js/sale_ui.js.php');


$dbf = new db_functions(
						$cfg_server
						,$cfg_username
						,$cfg_password
						,$cfg_database
						,$cfg_tableprefix
						,$cfg_theme
						,$lang
						);
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
	  <link rel="stylesheet" href="../js/jquery/modal/jquery-ui.css">
<!--<body onload="pedirVoto()"> -->
    <script src="../jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="../jquery_ui/js/jquery-ui-1.8.7.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <link rel="stylesheet" rev="stylesheet" href="../jquery_ui/css/ui-lightness/jquery-ui-1.8.7.custom.css" media="all" />
   <!--
 <script src="../jquery_ui/js/effects.core.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="../jquery_ui/js/ui.core.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
-->
<?						#######################################################################################################
						#######################################################################################################
						##	COLOCAMOS LAS LIBRERIAS PARA ORDENAMIENTO DE TABLAS
								Fjvm_formulario::html_ordenar_tabla_js();
								Fjvm_formulario::tooltips_main();

						#######################################################################################################
?>
<style type="text/css" media="screen">

body{
	
	cursor: s-resize !important;	
}

.cl_cant_valor{
	-moz-border-radius-topright: 10px;
	-webkit-border-top-right-radius: 10px;
	border-top-right-radius: 10px;
	-moz-border-radius-bottomright: 10px;
	-webkit-border-bottom-right-radius: 10px;
	border-bottom-right-radius: 10px;	
}

.cajas_22:focus{

background: #ffaf4b; /* Old browsers */
background: -moz-linear-gradient(top,  #ffaf4b 0%, #ff920a 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffaf4b), color-stop(100%,#ff920a)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffaf4b 0%,#ff920a 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffaf4b 0%,#ff920a 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffaf4b 0%,#ff920a 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffaf4b 0%,#ff920a 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffaf4b', endColorstr='#ff920a',GradientType=0 ); /* IE6-9 */

}

.all_billete{

		height: 80px;

		border: 2px solid #574747;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		border-radius: 2px;

}
.all_billete:active{

background: #b2e1ff; /* Old browsers */
background: -moz-linear-gradient(top,  #b2e1ff 0%, #66b6fc 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b2e1ff), color-stop(100%,#66b6fc)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b2e1ff 0%,#66b6fc 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b2e1ff 0%,#66b6fc 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b2e1ff 0%,#66b6fc 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b2e1ff 0%,#66b6fc 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b2e1ff', endColorstr='#66b6fc',GradientType=0 ); /* IE6-9 */

color:#43E919;
opacity: .3;

}

.cuadro_5000{

	background: #b4df5b; /* Old browsers */
background: -moz-linear-gradient(top,  #b4df5b 0%, #b4df5b 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b4df5b), color-stop(100%,#b4df5b)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b4df5b 0%,#b4df5b 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b4df5b 0%,#b4df5b 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b4df5b 0%,#b4df5b 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b4df5b 0%,#b4df5b 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4df5b', endColorstr='#b4df5b',GradientType=0 ); /* IE6-9 */

}
.cuadro_2000{
background: #eeeeee; /* Old browsers */
background: -moz-linear-gradient(top,  #eeeeee 0%, #cccccc 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(100%,#cccccc)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* IE10+ */
background: linear-gradient(to bottom,  #eeeeee 0%,#cccccc 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-9 */

}

.cuadro_1000{

background: #fac695; /* Old browsers */
background: -moz-linear-gradient(top,  #fac695 0%, #f5ab66 47%, #ef8d31 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fac695), color-stop(47%,#f5ab66), color-stop(100%,#ef8d31)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #fac695 0%,#f5ab66 47%,#ef8d31 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #fac695 0%,#f5ab66 47%,#ef8d31 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #fac695 0%,#f5ab66 47%,#ef8d31 100%); /* IE10+ */
background: linear-gradient(to bottom,  #fac695 0%,#f5ab66 47%,#ef8d31 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fac695', endColorstr='#ef8d31',GradientType=0 ); /* IE6-9 */



}

.cuadro_10000{
	background: #aebcbf; /* Old browsers */
background: -moz-linear-gradient(top,  #aebcbf 0%, #6e7774 50%, #0a0e0a 51%, #0a0809 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#aebcbf), color-stop(50%,#6e7774), color-stop(51%,#0a0e0a), color-stop(100%,#0a0809)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* IE10+ */
background: linear-gradient(to bottom,  #aebcbf 0%,#6e7774 50%,#0a0e0a 51%,#0a0809 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#aebcbf', endColorstr='#0a0809',GradientType=0 ); /* IE6-9 */

}

.cuadro_50000
{

	background: #fb83fa; /* Old browsers */
background: -moz-linear-gradient(top,  #fb83fa 0%, #e93cec 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fb83fa), color-stop(100%,#e93cec)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #fb83fa 0%,#e93cec 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #fb83fa 0%,#e93cec 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #fb83fa 0%,#e93cec 100%); /* IE10+ */
background: linear-gradient(to bottom,  #fb83fa 0%,#e93cec 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fb83fa', endColorstr='#e93cec',GradientType=0 ); /* IE6-9 */

}
.boton_numero{


background: #cedce7; /* Old browsers */
background: -moz-linear-gradient(top,  #cedce7 0%, #596a72 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cedce7), color-stop(100%,#596a72)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #cedce7 0%,#596a72 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #cedce7 0%,#596a72 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #cedce7 0%,#596a72 100%); /* IE10+ */
background: linear-gradient(to bottom,  #cedce7 0%,#596a72 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7', endColorstr='#596a72',GradientType=0 ); /* IE6-9 */
 font-family:Arial Black;
	
	padding-top: 1%;
	padding-bottom: 1%;	

		font-size: 25px;
		text-align: center;
		height: 80px;
		width: 80px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;

		border: 2px solid #574747;
		color: white; text-shadow: black 0.1em 0.1em 0.2em

}
.boton_numero:active{

background: #b2e1ff; /* Old browsers */
background: -moz-linear-gradient(top,  #b2e1ff 0%, #66b6fc 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b2e1ff), color-stop(100%,#66b6fc)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b2e1ff 0%,#66b6fc 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b2e1ff 0%,#66b6fc 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b2e1ff 0%,#66b6fc 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b2e1ff 0%,#66b6fc 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b2e1ff', endColorstr='#66b6fc',GradientType=0 ); /* IE6-9 */

color:#43E919;

}

</style>
<script type="text/javascript">



var id_caja_toma;	/* ESTE ES EL ID DEL INPUNT A COLOCAR*/
	
	jQuery(document).ready(function(){
  	
	<?PHP if(DF_ACTIVAR_ITEM_MAYOR_ROTACION===true){?>

		js_cargar_item_mayor_rotacion();

	<?PHp }?>

		jQuery('#inputString').focus();

		});

	function js_cargar_item_mayor_rotacion()
	{

		jQuery.ajax({
					url: "rpc_new.php",
                    dataType: "html",
					type: 'POST',
					data: {
						VALORES_INICIALES  	:'YES'
						,queryString 		:'false'
					},
                    success: function( data ) {
                        
						
						jQuery('#autoSuggestionsList').html(data);
						 
						 // var names = [ 'foo','bar' ];

										
					}
				});

	}

	function validarSiNumero(este){
		
		var valor 	=jQuery('#'+este).val();

		if (!/^([0-9])*$/.test(valor)){


					jQuery('#'+este).val(1);

		}

		if(valor==""){

			
			jQuery('#'+este).val(1);
		}
	
	}

	function js_add_monedo(valor_moneda)
	{


		var valor_obtenido 	=parseInt(document.getElementById(id_caja_toma).value);

			valor_obtenido 	=valor_obtenido>0?valor_obtenido:'';



	switch(valor_moneda){


		case 'prev':{

						var sss 			=''+valor_obtenido+'';
						var total_reg 		=sss.length;
							total_reg_menos	=total_reg-1;
						var suma 			=sss.substring(0, total_reg_menos);
			}break;
		case 'cero':{
						var suma 			=valor_obtenido+'0';
			}break;

		default:{


					if(valor_moneda>10){
						
						var suma 			=valor_obtenido+valor_moneda;

					}else{

						var suma 			=valor_obtenido+''+valor_moneda;

					}		



		}break;

	}





			document.getElementById(id_caja_toma).value =suma;




				/**
				 * funcion para sumar al pago
				 */
				cambamount();
	


	}

	function js_abrir_cal(kdj)
    {

    	<?PHp if(DF_MOSTRAR_TECLADO_NUMERO_PAGO===false){echo 'return false;';}?>
        jQuery( "#dialog" ).dialog();

        id_caja_toma		=kdj;


        switch(id_caja_toma){


        	case 'amount[0]':{

        							var ancho_ventana =460;
        							jQuery('.cl_billete_cop').show();
        							
        	}break;
        	case 'cant_item_form':{

        							var ancho_ventana =300;
        							jQuery('.cl_billete_cop').hide();
        	}break;




        }






	
	jQuery('.ui-dialog').width(ancho_ventana);

var position 	= jQuery('.ui-dialog').position();
var v_left		= parseInt(position.left) ;

	if(v_left>110)
			jQuery('.ui-dialog').css("left" , (v_left-100));
	


//jQuery('.ui-dialog').css({ "height","=450" ); });


    }



	function sincronizar_info_pac(cc_num)
	{
		
				$.ajax({
					url: "../ws_sincronizar_all.wsc.php",
                    dataType: "html",
					type: 'POST',
					data: {
						cc_num:cc_num,
						ws_sinronizar_all: 'view_info_paciente',
						AJAXX:'TRUE'
					},
                    success: function( data ) {
                        
						
						jQuery('#d_info_pac').html(data);
						 
						 // var names = [ 'foo','bar' ];

										
					}
				});
		
		
		}
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
                                cc: item.cc_num,									
								
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
	
	
	function seleccionar_campo(este)
	{
		
		document.getElementById(este).focus();
		document.getElementById(este).select();
		
		} 
		  
	function number_format(a, b, c, d) 
	{
 a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
 e = a + '';
 f = e.split('.');
 if (!f[0]) {
  f[0] = '0';
 }
 if (!f[1]) {
  f[1] = '';
 }
 if (f[1].length < b) {
  g = f[1];
  for (i=f[1].length + 1; i <= b; i++) {
   g += '0';
  }
  f[1] = g;
 }
 if(d != '' && f[0].length > 3) {
  h = f[0];
  f[0] = '';
  for(j = 3; j < h.length; j+=3) {
   i = h.slice(h.length - j, h.length - j + 3);
   f[0] = d + i +  f[0] + '';
  }
  j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
  f[0] = j + f[0];
 }
 c = (b <= 0) ? '' : c;
 return f[0] + c + f[1];
 
 }
 	
	function verificar_boton_agregar(){
		
		var modo	=jQuery('#tipo_vta').val();
		//alert(modo);
		//alert(jQuery('d_to_inv').html());
				if(modo=='1'){
		
		<?PHp if(FACTURAR_CON_TODO_INV_EN_CERO!==true){?>
					if(parseInt(jQuery('#d_to_inv').html())>0){
						
						document.getElementById("consitem").disabled = false;
						}else{
							document.getElementById("consitem").disabled = true;
							
							}
					
		<?PHp }?>
				}
		}		
 	function sincronizar_inventario(plu,location_id)
	{
		
<?PHp if(DF_SINCRONIZAR_WEB_SERVICE===true){?>	

		jQuery("#d_to_inv").addClass("fondo_carga");		
	$.ajax({
			url:'../ws_productos.wsc.php',
			type: 'POST',
			cache: false,
			dataType: 'json',
			data: ({value 			:plu,
					location_id 	:location_id,
					tipo 			:'plu',
					proveedor_id 	:'',
					ws_productos	:'actualizar_precios',
					lista_id 		:'<?Php echo base64_encode(DF_LISTA_PRECIO_ID);?>'
					}),
			error:function(objeto, quepaso, otroobj){
				var conf	=confirm('Web Service Fallido, No pudo actualizar el inventario, desea intentar de Nuevo?');
								
								if(conf){
									
										sincronizar_inventario(plu,location_id);
									}
					},
			success: function(data){
				
						var can_old	=jQuery('#d_to_inv').html();
							
							
						jQuery('#d_to_pre').html( number_format(data.unit_price, 0,'.',','));
						jQuery('#d_to_inv').html(data.quantity);
							
							if(parseInt(can_old)!=parseInt(data.quantity)){
								
								jQuery("th[rel=tipsy_sincro_inv]").tipsy("show");
								
								document.getElementById('d_to_inv').style.backgroundColor='#FF0000';
								setTimeout("apagar_sincr_inv()", 7000);

								}
								jQuery("#d_to_inv").removeClass("fondo_carga");
	
				}/*data*/
				});	
		
		setTimeout("verificar_boton_agregar();", 300);
		setTimeout("verificar_boton_agregar();", 5000);


<?PHp }?>
		}  

	function apagar_sincr_inv()
	{
		document.getElementById('d_to_inv').style.backgroundColor='#FFFFFF';
		jQuery("th[rel=tipsy_sincro_inv]").tipsy("hide");
		}
 
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
    tipo_vta: document.getElementById('tipo_vta').value,
    
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
    tipo_disp: document.getElementById('tipo_disp').value ,
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
//modifiItem ->Yaruro
formu = document.getElementById('orden['+k+']').value;
validQty(formu,k);
qtyDespa = document.getElementById('qty['+k+']').value;
$.post("sale_ui.php", { 
    customer_list: document.getElementById('customer_list').value, 
    tipo_vta: document.getElementById('tipo_vta').value ,
    tipo_disp: document.getElementById('tipo_disp').value ,
    
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
            tipo_disp: document.getElementById('tipo_disp').value ,
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
	
<?php if(FACTURAR_CON_TODO_INV_EN_CERO===false){?>	
	var VAL_CANTIDADES_TOTALES_CEROS	='FALSE';
	
	var max_item=	parseInt(document.getElementById("total_productos_pedidos").value);
	
				for(var y=0;y<max_item;++y){
					
						if(document.getElementById('dispo['+y+']')){
									
									if(parseFloat(document.getElementById('dispo['+y+']').value)>0){
										
										VAL_CANTIDADES_TOTALES_CEROS	='TRUE';
										break;
										}
							}
					
					}
	if(VAL_CANTIDADES_TOTALES_CEROS=='FALSE'){
			
			alert('NO PUEDE ENVIAR ESTA FACTURA CON TODOS LOS SALDOS EN CERO');
			
		return false;
		}
		
	<?php }?>
	
	document.getElementById("cliente").value =  document.getElementById("customer_list").value;
    var sigue = 0;
    var tipovta = document.getElementById('tipo_vta').value;
	//alert(tipovta);
    if(tipovta == '1'){
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
		alert('usuario y contrase�a incorrecta');
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
function lookup_s(inputString) {
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
	if(inputString.length >6){	
		$.post("rpc.php", {queryString: ""+inputString+"",tipo_vta: document.getElementById('tipo_vta').value,customer_list : document.getElementById('customer_list').value}, function(data){
			if(data.length >0) {
				$('#suggestions').show();
				$('#autoSuggestionsList').html(data);
			}
		});
		}
	}
} // lookup

function fill_old(thisValue) {
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
    tipo_vta 				= document.getElementById('tipo_vta').value;
    customer_list 			= document.getElementById('customer_list').value; 
	ajax 					=nuevoAjax();
	//var a = document.getElementById("inputString").value; 
	ajax.onreadystatechange = procesarinfo3;
	ajax.open("GET","../ajaxcampos1.php?a="+cadena+"&c="+c+'&tipo_vta='+tipo_vta+'&customer_list='+customer_list,true);
	ajax.send(null);

}

function searchCustomer(cadena,c){
	
	 jQuery("#customerDoc_list").addClass("fondo_carga");
    var tipoVta = document.getElementById('tipo_vta').value;
    $.post('../buscarjson.php',{
			a: cadena, 
			c: c, 
			tipoVta : 
			tipoVta,
			tipSearch : '1'
			},function(data){ 
							 jQuery("#customerDoc_list").removeClass("fondo_carga");
        if(data[0].id > 0){
            //$('#customer_list').val(data.account_number);
            $("#customer_list").val(data[0].id);
            $("#nameCustomer").val(data[0].label);
			if(parseInt(data[0].diferencia_dias)<32 && parseInt(data[0].diferencia_dias)>=0){
									var dais	=(parseInt(data[0].diferencia_dias)==1)?'dia':'dias';
				alert('Hace '+data[0].diferencia_dias+' '+dais+', se le dispenso para este paciente , fecha ultima dispensacion :'+data[0].ult_fech_disp);
			}
			//alert((data[0].tipo_sub));
   							 sincronizar_info_pac(data[0].cc_num);
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

	 jQuery("#num_formu").addClass("fondo_carga");
	
	document.getElementById('select_itemw').submit();
   // select_item.submit();
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


<?PHp if(FACTURAR_CON_TODO_INV_EN_CERO===false){?>
        document.getElementById('qty['+k+']').value = maxi;
        alert('No se Dispone en inventario las cantidades para Despachar lo Formulado');
        //document.getElementById('orden['+k+']').value = '0';
<?PHp }?>     
   	 }
    }
}
</script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script src="../ajax/ajaxjs1.js"></script>
<!--<script src="../ajax/ajaxjs2.js"></script>-->
<style type="text/css">
.fondo_carga{
	background-image: url(../images/ajax-face.gif);
	background-repeat: no-repeat;
	background-position: right center;	
	padding-right:2px;
	
	}

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

?><!-- <hr></hr>-->

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
				$rc_3 = mysql_query("update   
											pos_sales_items 
									set  
											quantity_purchased  = (".$sign." * quantity_purchased) 
									where 
											id = ".$rowcan['id']."",$conn_2);
			}
			echo '<div align="center"><font size="5" align="center"><strong>V E N T A&nbsp;&nbsp;&nbsp;&nbsp;A N U L A D A</strong></font></div>';
			//exit;
		}
?>
<table border="0" width="100%" class="fondo_fondo">
<tr>
<td colspan="2" >
<? if (!$can) {
	
	#$ped		=($tipo_vta == '1')?'Venta':'Dispensaci&oacute;n';
	/**
	 * variable para representar los tipos de venta
	 * @var varchar
	 * @fecha :Sep 25 de 2014
	 */
	
	$ped		=($tipo_vta == '1')?'Venta':'Venta - Cliente';


	?>
            
	<form name='select_item' id='select_itemw' action='sale_ui.php' method='POST'>
            <table border='0' bgcolor='<?=$table_bg?>' align='center' class="fondo_fondo" width="100%" >
            <tr style="display:<?PHp echo DF_MODO_VENTA_PEDIR_CLIENTE_ANULAR_VENTA;?>">
            	<td><?=$ObjDeco->CuadroLabels('MODO-'.$ped,'modo','derecha','')?></td>
            <!--<th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><strong>Modo</strong></th>-->
                <td width="5%" nowrap><?PHp fc_tipo_venta($tipo_vta);?></td>
                <td nowrap colspan="2">
            <?php 


            if ($sale_id == '' and $_REQUEST['consitem']) {
				
				 $sales_table 	= $cfg_tableprefix.'sales';
				$field_names 	= array(
											'date'
											,'customer_id'
											,'sold_by'
											,'invoicenumber'
											,'status'
											,'tipo_vta'
											,'formula'
											,'bodega_id'
											,'entrydate'
										);
				$rc_maxin 		= mysql_query('SELECT 
														MAX(invoicenumber) as maxin  
												FROM 
														pos_sales 
												WHERE 
														pos_sales.`status` NOT LIKE "-1"
											',$conn_2
											);
				
				
				$maxin = mysql_fetch_assoc($rc_maxin);
				$maxin = $maxin['maxin'] + 1;
				
				if($maxin<$cfg_fact_desde)
					  { 
					$maxin=$cfg_fact_desde;
					  }
					  $tempmaxin=$cfg_fac_hasta-2000;
					  if($maxin >= $tempmaxin)
					  {
					  	echo "ESTA LLEGANDO AL L�MITE DE N�MERO DE FACTURAS DE LA RESOLUCI�N";
					  }
				
				
				
				
				$field_data = array(
									date("Y-m-d")
									,$customer_list
									,$_SESSION['session_user_id']
									,$maxin
									,0
									,$tipo_vta
									,$numFormula
									,$cfg_locationid
									,date("Y-m-d H:i:s")
									);
				$dbf->insert(
								$field_names
								,$field_data
								,$sales_table
								,false
							);
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
//echo '<pre>'; print_r($result);
						if (count($result) > 0) {

													$SQL = "SELECT id FROM pos_sales WHERE status = 0 AND customer_id = '$customer_list' AND formula ='$numFormula'";
													//echo $SQL; 
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
							$rc_maxin = mysql_query('SELECT MAX(invoicenumber) as maxin  FROM pos_sales  WHERE pos_sales.`status` NOT LIKE "-1"',$conn_2);
							$maxin = mysql_fetch_assoc($rc_maxin);
							$maxin = $maxin['maxin'] + 1;
											if($maxin<$cfg_fact_desde)
											  { 
												$maxin=$cfg_fact_desde;
											  }
							  $tempmaxin=$cfg_fac_hasta-2000;
											  if($maxin >= $tempmaxin)
									  			{
												  echo "ESTA LLEGANDO AL L�MITE DE N�MERO DE FACTURAS DE LA RESOLUCI�N";
												 }
							$field_data = array(date("Y-m-d"),$customer_list,$_SESSION['session_user_id'],$maxin,
								0,$tipo_vta,$numFormula,$cfg_locationid,count($result));
							$dbf->insert($field_names,$field_data,$sales_table,false);
							$sale_idD = mysql_insert_id($dbf->conn);
							$goToWS = true;

							for ($k = 0; $k < count($result); $k++) {
								//			      echo "select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_vta as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".$result[$k]['item_id']."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'<br>";
												if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
													$rc_positems = mysql_query("select 
																						pos_items.id
																						,pos_items.tax_percent
																						,pos_itemconvenio.price_vta as unit_price
																						,pos_items.pack
																						,pos_items.buy_price
																						,pos_items.tax_percent 
																					FROM 
																						pos_items
																						, pos_itemconvenio
																						,pos_pacientes 
																					WHERE 
																						pos_items.id = '".$result[$k]['item_id']. "' 
																						and pos_items.active = 1 
																						and pos_itemconvenio.estado = 1 
																						and pos_items.id = pos_itemconvenio.items_id 
																						AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid 
																						and pos_pacientes.id = '$customer_list'",
														$dbf->conn);

												} else {
													$rc_positems = mysql_query("select 
																						pos_items.id
																						,pos_items.tax_percent
																						,pos_itemconvenio.price_evento as unit_price
																						,pos_items.pack
																						,pos_items.buy_price
																						,pos_items.tax_percent 
																					FROM 
																						pos_items
																						, pos_itemconvenio
																						,pos_pacientes 
																					WHERE 
																						pos_items.id = '". $result[$k]['item_id']. "' 
																						and pos_items.active = 1 
																						and pos_itemconvenio.estado = 1 
																						and pos_items.id = pos_itemconvenio.items_id 
																						AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid 
																						and pos_pacientes.id = '$customer_list'",
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
								$field_names = array(
														'sale_id'
														,'item_id'
														,'quantity_purchased'
														,'item_unit_price'
														,'item_buy_price'
														,'item_tax_percent'
														,'item_total_tax'
														,'item_total_cost'
														,'unit_sale'
														,'sale_frac'
														,'tipo'
														,'porcen_dcto'
														,'value_dcto'
														,'qtyrecetada'
														,'toWS'
														,'qtytoWS'
														,'entrydate'
													);
								$field_data = array(
														$sale_idD
														,$positems['id']
														,0
														,$temp_price2
														,$positems['buy_price']
														,$positems['tax_percent']
														,$valimp
														,($temp_price2 + $valimp)
														,1
														,$positems['pack']
														,$itipo
														,$temp_discount
														,$valdsto
														,$result[$k]['qtyrecetada']
														,1
														,$result[$k]['suma']
														,date('Y-m-d H:i:s')
													);

								$dbf->insert($field_names,$field_data,$salesdetail_table,false);

							}// For para moverme dentro de los productos

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
				 $rc_saleop = mysql_query('select id,customer_id  from pos_sales where sold_by = '.$userId.' and status = 0 '.$sqlTvta,$conn_2);
				 $saleop = mysql_fetch_assoc($rc_saleop);
				
				if ($saleop['id'] != '') {
					$sale_id = $saleop['id'];
					$customer_list = $saleop['customer_id'];
				} else {
					$sale_id = '';
				}
			}
?>
            <input name="sale_id" type="hidden" id="sale_id" value="<?=$sale_id?>" />

<div id="selectcustomer">
<table width="80%"  class="fondo_fondo">
	<tr>
		<td>
			<?php 	if ($tipo_vta == '2') {$ObjDeco->CuadroLabels($lang->Paciente,'paciente','derecha','');} 
			else {$ObjDeco->CuadroLabels($lang->orderBy,'pacientes','derecha','');}?>
		</td>
		<td nowrap>
        	<input type="text" size="5" name="customerDoc_list" id="customerDoc_list" value="<?=$_REQUEST['customerDoc_list']?>" onChange="searchCustomer(this.value,4)" class="cajas_22"/>
			<input type="hidden" name="customer_list" id="customer_list" value="<?=$customer_list?>">
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
			<input type="text" class="cajas_22" name="nameCustomer" id="nameCustomer" autocomplete="off" size="40" value="<?=$customerstr?>"/>
			<?php if ($tipo_vta == '1') {?>&nbsp;&nbsp;&nbsp;
            <a href="sale_ui.php?actionID=addcustomer&act=1" onClick="ventanaSecundaria(this); return false" target="_parent">
            <img src="../images/edit_add.png" border="0" style="cursor: pointer;" title="Agregar Cliente"/></a><?php }?>
            <!--&nbsp;&nbsp;&nbsp;<img onclick="updCustomer()" src="../images/recur.png" border="0" style="cursor: pointer;" title="Actualizar"/></a>-->
            <div id="d_info_pac"></div>
		</td>
<?php if ($tipo_vta == '2') {?>
		<td><?=$ObjDeco->CuadroLabels('NUM_FORMULA','sin_nombre','derecha','')?></td>
		<td nowrap><input type="text" class="cajas_22 " name="num_formu" id="num_formu" onChange="submitPaciente()" value="<?=$numFormula?>" size="15"/></td>                
<?php } else {?>
		<div style="width:5%"></div>
    	<input type="hidden" value="0" name="num_formu" id="num_formu" />
		<?php }?>
	<td><input type="button" value="<?=$lang->newSale?>" class="display_naranja" disabled/></td>
	</tr>
</table>     
</div>                
          
    	</td>              
        <td  ></td>
        <td colspan="3"></td>
              <!--<td width='243'>< ? //	$lang->devolucion?><input type="checkbox" name="devolucion" id="devolucion" value="1"  onClick="pedirclave();" /</td>-->
    </tr>
    <tr>
    	<th style="vertical-align: middle; text-align: center; background-color: #A73535; display:none " nowrap><?=$lang->findItem?>:</th> 
        <td style="display: none;"><?php if ($cfg_searchproductcombo == 1) {?>    
			<input type='text' size='8' name='item_search' id='item_search' class="cajas_22">
            </font>
            <input type='submit' value='Go'><a href='delete.php?action=item_search'><font size='-1' color='white'>[<?=$lang->clearSearch?>]</font></a>
            <? } else {?> 
                    <input type="text" class="cajas_22" size="15" name="itemsearch_2" id="item_search2" value="<?=$itemsearch_2?>" onChange="searchitem(this.value,2);">
                    <? if ($itemsearch_2 != '') {?>
					<!--<script src="../ajax/ajaxjs2.js"></script>-->
					<script language="JavaScript">
					//searchitem(document.getElementById("item_search2").value,2);
					</script>
					<? }?>                            
           		 <?php }
			// if($cfg_searchproductcombo == 1)
			///////////////////////////////////////////////////////////////////////////////
			$strItem = '';?>
        </td>
        <th style="vertical-align: middle; text-align: center; " width="5%" nowrap >
			<!--< ?=$ObjDeco->CuadroLabels($lang->itemID.' / '.$lang->itemNumber,'formula','derecha','')?>-->
            <?=$ObjDeco->CuadroLabels($lang->itemNumber,'sin_nombre','derecha','')?>
        </th>
		<td width="5%" >
   		<input type='text' name='item' id='item'  class="cajas_22"onChange='searchitem(this.value,2);' size='5' value="<?php echo $strItem;?>" onClick="seleccionar_campo(this.id);" <?php if(HABILITAR_BUSQUEDA_PLU===false){echo 'readonly';}?>  >
		</td>
		<th style="vertical-align: middle; text-align: center;  " width="5%">			  
			<?=$ObjDeco->CuadroLabels($lang->description,'sin_nombre','derecha','');
			##############################################################
		  	## mostrar el autocompletar
            ver_div_autocompletar(); ?>
		</th> 
		<td width="5%" nowrap>
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    		<tr>
		        <td><?php //////////////////////////////////////////////////////////////
			if ($cfg_searchproductcombo == 1) {?>    
                <?=$item_title?>
                <select name='item_list' onChange=\"updateScanItemField()\";  class="forma_select_1">
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
				}?>
                    </select>
                    
                    
            <?php } else {

            	$strItem = '';?>
   
    

    <input style="padding:5px;" type="text"  class="cajas_22"size="45" autofocus="autofocus" placeholder="Digite Descripcion del Producto" value="<?=$strItem?>" id="inputString" name="inputString" onKeyUp="lookup(this.value);" onBlur="fill();" onClick="seleccionar_campo(this.id);js_active_item_favorite();" autocomplete= 'off' />
	
            <?php }?> </td>
         <td>
         	<input type="text" style="text-align:center;margin-left:2px;padding:5px;"  class="cajas_22 cl_cant_valor" size="3" maxlength="3" value="1" id="cant_item_form" name="cant_item_form" autocomplete= 'off' onkeyup="validarSiNumero('cant_item_form')" onchange="validarSiNumero('cant_item_form')" onclick="js_abrir_cal('cant_item_form');" />
         </td>
        <th style="vertical-align: middle; text-align: center;  padding-left:4px; padding-right:1px;" width="5%">
         <?=$ObjDeco->CuadroLabels('Costo$','sin_nombre','derecha','')?>
        </th>
        <th width="40px;" style=" !important; text-align:right; padding-left:8px;"align="right" id="d_to_pre" bordercolor="#003366" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th style="vertical-align: middle; text-align: center; padding-left:4px; padding-right:1px;" width="5%">
         <?=$ObjDeco->CuadroLabels('Inv','sin_nombre','derecha','')?>
         </th>
        <th rel="tipsy_sincro_inv" title="Sincornizado<br>Nuevo Invetario De la Sucursal" style="width:50px !important; text-align:center; padding-left:7px; padding-right:7px;" align="center" id="d_to_inv" bordercolor="#003366" bgcolor="#FFFFFF">&nbsp;</th>
        <script>jQuery('th[rel=tipsy_sincro_inv]').tipsy({gravity: 'n' ,trigger: 'manual',html:true,fade: true});</script>
      </tr>
    </table>
			  </td>                  
              <td>
              <input type='submit' value='ADD ITEM' name='consitem' id='consitem' disabled='true'  class="display_naranja_max" >
             <!-- <button  name='consitem' id='consitem' disabled='true'  class="display_naranja_max">ADICIONAR<BR>PRODUCTO</button>-->
              </td>
              <td> <?PHp 

              	if(DF_MOSTRAR_BOTON_LIMIAR_AUTOCOMPLETE===true){
              
              		?><input type='button' value='Limpiar' name='clearfields' id='clearfields'  onclick='ClearField();' class="display_naranja"  ><?PHp 

              }?>
              <button onClick=javascript:cancelsale();  class="display_naranja_max" type="button"><?=$lang->cancelsaleall?></button>
              <!--<input type="button" value="< ?=$lang->cancelsaleall?>/n sdsdsds" onClick=javascript:cancelsale();  class="display_naranja_max"  />-->
               </td>			
            </tr>                     
            <tr style="display:none">
                <td colspan="7" ><div id="pregg"></div></td>
            </tr>
<!-- Yaruro 09102013 -->

    <tr style="display:none"> <?php if($tipo_vta=='2'){ ?>  	
    	<td width="10%" nowrap><?=$ObjDeco->CuadroLabels('CENTRO DE COSTO','modo','derecha','')?></td> <? } ?>      
            <!--<th style="vertical-align: middle; text-align: center; background-color: #A73535; " width="5%" nowrap><strong>Modo</strong></th>
                <select name='tipo_disp' onChange="cambiartipo_disp()" id="tipo_disp"  style="width:70px;" class="forma_select_1 cajas_22">
                -->
                <td width="5%" nowrap>
                       
                            <select id="tipo_disp" name='tipo_disp'  style="width:70px;<?=($tipo_vta=='1')?"display:none":""?>"  class="forma_select_1 cajas_22">    
                                <? if($tipo_disp == '3'||$sale_id=='') {
                                 $Seleccion = ''; if ($tipo_disp == '3') {	echo $Seleccion = 'selected';}?>
                                <option value='3' <?=$Seleccion?> ><b>EVENTO</b></option><?}?>
                            <?  if($tipo_disp == '2'||$sale_id=='') {
                            $Seleccionb = '';if ($tipo_disp == '2') { echo $Seleccionb = 'selected';}?>
                            	<option value='2' <?=$Seleccionb?>><b>DISPENS</b></option><?}?>
                            
                            </select>
		</td>
      </tr>     
      </table>
   </form>
<? }?>


<div id="dialog" title="Tabla Numeros" style="display:none;widht:450px !important;">
  <p><?PHp func_numero_para_pago();?></p>
</div>
 
 

</td>
</tr>
<tr>
<td valign="top">
   <form name='add_sale' action='addsale.php' method='POST' onsubmit='return checkvalue()'>
        <div id="itemssales"  style="overflow:scroll;  overflow-x:hidden; width:auto; height:280;"> <!--height:360;-->
<table border='0'  cellspacing='0' cellpadding='2' align='center' class="tablesorter" bgcolor='<?=$table_bg?>' width="100%">
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
             <thead>
            <tr>
          
            <? if ($tipo_vta == '2') {?>    
                <th nowrap><?=$lang->typeVta?></th> <?php }?>            
                <th nowrap><?=$lang->itemID?></th>
                <th nowrap><?=$lang->itemName?></th>
            	<th nowrap><?=$lang->pvc?></th>
              <!--<th nowrap>< ?=$lang->porcdesto?></th>
          	<th nowrap>< ?=$lang->vlrdsto?></th>
            	<th nowrap>< ?=$lang->vlrcondsto?></th>-->
            	<th nowrap><?=$lang->porciva?></th>
            	<th nowrap><?=$lang->vlriva?></th>
            	<th nowrap><?=$lang->pvp?></th>
            	<th nowrap style="display:<?PHp echo DF_COL_FRACCION;?>"><?php 

            	if ($tipo_vta == '2') {
            			echo $lang->disp.'&nbsp;&nbsp;&nbsp;'.$lang->formu.'(P)'; 
            			 }
				?>&nbsp;&nbsp;<?=$lang->cant;?>&nbsp;&nbsp;&nbsp;<?=$lang->fraccion?>
				</th>
        		<th nowrap  style="display:<?PHp echo DF_COL_UNIDAD_VENTA;?>"><?=$lang->past?></th>
            	<th nowrap><?=$lang->vlrtot?></th>
            	<th nowrap><?=$lang->cancel?></th>
            </tr>
            </thead>
            <input type="hidden" name="sale_id" id="sale_id" value="<?=$sale_id?>"/>
        <?php //


		if ($sale_id != '' and $item != '') {
			$itipo = 1;
			if ($tipo_vta == '2') {
                            
                            if($tipo_disp=='2'){
                                if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {

					$sql_1="select 
								pos_items.id
								,pos_items.tax_percent
								,pos_itemconvenio.price_vta as unit_price
								,pos_items.pack
								,pos_items.buy_price
								,pos_items.tax_percent 
							FROM 
								pos_items
								, pos_itemconvenio
								,pos_pacientes 
							WHERE 
								pos_items.item_number = '".$item."' 
								and pos_items.active = 1 
								and pos_itemconvenio.estado = 1 
								and pos_items.id = pos_itemconvenio.items_id 
								AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid 
								and pos_pacientes.id = '$customer_list'
							";
					
					$rc_positems = mysql_query($sql_1,$conn_2);
                                //defino el valor del itipo
                                $num_rows = mysql_num_rows($rc_positems);
				if ($num_rows > 0) {
					if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
						$itipo = 2;
					}/* else {
						$itipo = 3;
					}*/
				}//numnrows>0
                                        
				}//condicional del paciente
                             
                            }//sila formula es por Dispensacion  
                            else if($tipo_disp=='3'){
                                $sql_2="select 
                                				pos_items.id
                                				,pos_items.tax_percent
                                				,pos_itemconvenio.price_evento as unit_price
                                				,pos_items.pack,pos_items.buy_price
                                				,pos_items.tax_percent
                                		FROM 
                                				pos_items
                                				, pos_itemconvenio
                                				,pos_pacientes 
                                		WHERE 
                                				pos_items.item_number = '".$item."' 
                                				and pos_items.active = 1 
                                				and pos_itemconvenio.estado = 1 
                                				and pos_items.id = pos_itemconvenio.items_id 
                                				AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid 
                                				and pos_pacientes.id = '$customer_list'";
					//echo $sql_2;die;
					$rc_positems = mysql_query($sql_2,$conn_2);
                            $num_rows = mysql_num_rows($rc_positems);
				if ($num_rows > 0) {
					
						$itipo = 3;
					
                                
                             }
                            }
                            
                              /* se comenta por lo 
				if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
					$sql_1="select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_vta as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".
					$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
					
					$rc_positems = mysql_query($sql_1,$conn_2);
				} else {
					$sql_2="select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_evento as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".
						$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
					//echo $sql_2;die;
					$rc_positems = mysql_query($sql_2,$conn_2);
						
				}
				$num_rows = mysql_num_rows($rc_positems);
				if ($num_rows > 0) {
					if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
						$itipo = 2;
					} else {
						$itipo = 3;
					}
				}*/
				//else{
				if (DISTRI_VTA == 1) {
                                     // die("entro");

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
                        //Insertar Pos_sales_items

			

			$field_names = array(
								'sale_id'
								,'item_id'
								,'quantity_purchased'
								,'item_unit_price'
								,'item_buy_price'
								,'item_tax_percent'
								,'item_total_tax'
								,'item_total_cost'
								,'unit_sale'
								,'sale_frac'
								,'tipo'
								,'porcen_dcto'
								,'value_dcto'
								,'qtyrecetada'
								,'entrydate'
							);

				$field_data = array(
									$sale_id
									,$positems['id']
									,$v_cant_pru
									,$temp_price2
									,$positems['buy_price']
									,$positems['tax_percent']
									,$valimp
									,($temp_price2 + $valimp)
									,1
									,$positems['pack']
									,$itipo
									,$temp_discount
									,$valdsto
									,0
									,date('Y-m-d H:i:s')
								);
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
                                    
                                    
					if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
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
						if ($row_item['qtyrecetada'] >= 0) {
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
						if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
							$tipoVenta = '<span style="font-size: 13px; cursor:pointer" id="tipoDisp'.$k.
								'" onclick="cambioDisp('.$k.','.$row_item['tipo'].')"><strong>'.$srtEvent.
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
            <tr style="color: #015B7E;">
            <input type="hidden" value="<?=$itipo_Vta?>" name="itipovta[<?=$k?>]" id="itipovta<?=$k?>" />
			<? if ($canc == 1)
					$readon = 'readonly';
				else
					$readon = '';
				if ($tipo_vta == '2') {?>
	<td align='center' nowrap style="text-align: right;color: #015B7E;  font-weight: bold;"><?=$tipoVenta?></td>                    
                    <?php }?>    
	<td align='center' nowrap style="text-align: right;color: #015B7E;  font-weight: bold;"><?=$temp_item_code?></td>
	<td  align='left'  style="color: #015B7E; height:20px;width:350px !important;"><?=utf8_decode($resto);?></td>
	<td align='center' nowrap>
    	<input type=text name='price<?=$k?>'  class="cajas_22 fondo_dollar_active"style='text-align:right' readonly value='<?=$temp_sindsto2?>' size='6'>
        <input type="hidden" name="temp_discount" id="temp_discount" value="<?=$temp_discount?>" />
        <input type="hidden" name="valdsto" id="valdsto" value="<?=$valdsto?>" />
        <input type="hidden" name='price<?=$k?>'  class="cajas_22 "id='pricedcto<?=$k?>' readonly style='text-align:right' value='<?= number_format($temp_price2,0,'','');?>' size='6'>
    </td>
	<!--<td nowrap style="text-align: center;color: #015B7E;  font-weight: bold;">
    	< ?=$temp_discount?>< ?=$lang->sigporc?>
    </td>
	<td nowrap style="text-align: center;color: #015B7E;  font-weight: bold;">
    	< ?= number_format($valdsto,0,'','');?>
   </td>
	<td nowrap  style="text-align: center;">
    	
    </td>-->
	<td nowrap style="text-align: center;" style="display:<?PHp echo DF_COL_FRACCION;?>">
    	<input type=text name='tax<?=$k?>' style='text-align:center; width: 25px;'  readonly  value='<?=$temp_tax?>' size='5'>
    </td>
	<td nowrap style="text-align: center;">
    	<input type=text name='valimp<?=$k?>' class="cajas_22" id='valimp<?=$k?>' style='text-align:center; width: 35px;'  readonly  value='<?=$valimp2?>' size='6'>
    </td>
	<td align='center' nowrap  style="text-align: center;">
    	<input type=text name='price<?=$k?>' class="cajas_22 fondo_dollar_active" readonly style='text-align:right' value='<?=$temp_pricepub2?>' size='6'>
    </td>
	<td nowrap  style="text-align: center;display:<?PHp echo DF_COL_FRACCION;?>" >                
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

<input type=text name='dispo<?=$k?>' id='dispo[<?=$k?>]' class="cajas_22" readonly  style='text-align:center; width: 35px;' value='<?= number_format($inveQty,0,'','');?>' size='6'>

<input type=text name='orden<?=$k?>' id='orden[<?=$k?>]' class="cajas_22" style='text-align:center; width: 35px;  background-color:#FFFFD8';  value='<?= number_format($row_item['qtyrecetada'],0,'','');?>' size='7' <?=$disableFormu?>  onchange='validFormulada(<?=$k?>)'> (<?= number_format($temp_quantityB,'2',',','')?>)
<? } else {
					if ($tipo_vta == '2') {?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }?>
	<input type="hidden" name='dispo<?=$k?>' id='dispo[<?=$k?>]' <?=$readon?>  style='text-align:center; width: 35px;' value='<?= number_format($inveQty,0,'','');?>' size='6'>
    <input type="hidden" name='orden<?=$k?>' id='orden[<?=$k?>]' value='0'><?php }
?>                
                
	<input type=text name='quantity<?=$k?>' id='qty[<?=$k?>]' <?=$readon?> onChange="validQtyInv(this.value,<?=$k?>,'<?=$temp_quantityB?>')" style='text-align:center; width: 25px;' value='<?= number_format($temp_quantity,0,'','');?>' class="cajas_22" size='3' <?=$readOnlyqty?> >
(<?=$temp_pack?>)
</td>

	<td nowrap align='center'style="display:<?PHp echo DF_COL_UNIDAD_VENTA;?>">
					<input type='hidden' name='pack<?=$k?>' id='pack[<?=$k?>]' value='<?=$temp_pack?>'/> 
                    <select name='past<?=$k?>' id='past[<?=$k?>]' onChange="updateitemsale(<?=$k?>)"  class="forma_select_1" style="width:50px;">
                        <option value="1"
            <?php if (!(strcmp("1",$temp_packing))) {
					echo $selected = "selected=\"selected\"";
				}?>
                        >Unidad</option>
            <?php if ($temp_pack != 1)?>
                        <option value="2"     <?php 
					if (!(strcmp("2",$temp_packing))) {
						echo $selected = "selected=\"selected\"";
					}
?>
                        >Frac</option>
                    </select>
	</td>

	<td   align='center' nowrap>
		<font color='#015B7E'>
			<b><?=$cfg_currency_symbol.number_format($vlrtot,0)?></b>
		</font>
				<input type='hidden' name='temp_pricepub2<?=$k?>' id='pvpfin[<?=$k?>]' value='<?=$temp_price2?>'/>
				<input type='hidden' name='preciocompra<?=$k?>' id='preciocompra[<?=$k?>]' value='<?=$preciocompra?>'/>
	</td>
                <?php //			  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>
	if ($row_item['toWS']) {?>
                <input type='hidden' name='item_id<?=$k?>' id='item_id[<?=$k?>]' value='<?=$temp_item_id?>'>
				<input type='hidden' name='idpossalesitems<?=$k?>' id='idpossalesitems[<?=$k?>]' value='<?=$idpossalesitems?>'>
				<input type='hidden' name='<?=$k?>' value='<?=$k?>'>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?=$k?>" />
                 <td align="center">FORMU</td>
                 <?php } else {
					if ($canc == 0) {?>
                <input type='hidden' name='item_id<?=$k?>' id='item_id[<?=$k?>]' value='<?=$temp_item_id?>'>
				<input type='hidden' name='idpossalesitems<?=$k?>' id='idpossalesitems[<?=$k?>]' value='<?=$idpossalesitems?>'>
				<input type='hidden' name='<?=$k?>' value='<?=$k?>'>
				<td align='center'><a href=javascript:void(0)  class=InvUpText ><font color="#FFFFFF"></font></a>
                <img src="../images/cancel.png" border="0" title="<?=$lang->cancel?>"   onClick=javascript:cancelitemsale(<?=$k?>);  style="cursor:pointer"/>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?=$k?>" />
	<? } else {?>
				<td colspan="2" align="center" nowrap>
                <input type="hidden" value="0" name="ItemOn" id="ItemOn<?=$k?>" />
                <font color="white">A N U L A D O</font></td>
				
				<? }
				}?>
                <input type='hidden' name='showitem<?=$k?>' id='showitem<?=$k?>' value='<?=$showitem?>' />
				</td>
            </tr>
			<?
				if ($can == 1) {
					//echo '<tr><td>dsds</td><td>'.$k.'</td></tr>';

				}
				
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
?><input id="total_productos_pedidos" type="<?php echo HIDDEN;?>" value="<?php echo $k;?>"><?
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
                <th colspan="<?=$numcolTotal?>" style="text-align: right;"><?=$lang->totDis?></th>
				<th style="text-align: right;"><b><?= number_format($tot_temp_sindstoD,0)?></th>
				<!--<th style="text-align: right;"></th>
                <th style="text-align: right;">< ?= number_format($tot_valdstoD,0)?></th>
				<th style="text-align: right;"> < ?= number_format($tot_temp_priceD,0)?></th>-->
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_valimpD)?> xxxx</th>
                <th style="text-align: right;"><?= number_format($tot_temp_pricepubD)?> yyyy</th>
				<th style="text-align: right;"><?=$qtyProD?></th>
				<th style="text-align: right;"></th>
				<th style="text-align: right;"><?= number_format($tot_rowTotalD)?></th>
				
				<th style="text-align: right;">
	
                </th>
            </tr>
        </thead>
<?php }
?>        
        <thead>
            <tr> 
                <th colspan="<?=$numcolTotal?>" style="text-align: right; font-size:16px;"><?=$lang->tot?></th>
				<th style="text-align: center; font-size:16px;"><b><?= number_format($tot_temp_sindsto,0)?></th>
				<!--<th style="text-align: center; font-size:16px;"></th> 
				<th style="text-align: center; font-size:16px;">3< ?= number_format($tot_valdsto,0)?></th>
				<th style="text-align: center; font-size:16px;">< ?= number_format($tot_temp_price,0)?></th>-->
				<th style="text-align: center; font-size:16px;"></th>
				<th style="text-align: center; font-size:16px;"><?= number_format($tot_valimp)?> </th>
                <th style="text-align: center; font-size:16px;"><?= number_format($tot_temp_pricepub)?> </th>
				<th style="text-align: center; font-size:16px;display:<?PHp echo DF_COL_FRACCION;?>"><?=$qtyPro?></th>
				<th style="text-align: center; font-size:16px;display:<?PHp echo DF_COL_UNIDAD_VENTA;?>">--</th>
				<th style="text-align: center; font-size:16px;"><?= number_format($tot_rowTotal)?></th>
				
				<th style="text-align: right;">
                <input type="hidden" value="<?=$lins?>" name="totLin" id="totLin" />
                <input name="totvta" type="hidden" id="totvta" value="<?=$tot_temp_pricepub?>"/>
            		<input name="tots" type="hidden" id="tots" value="<?=$tot_rowTotal?>"/>
                    <input name="customerid" type="hidden" id="customerid" value="<?=$customer_list?>"/>
                    <input name="devolucionid" type="hidden" id="devolucionid" value="<?=$devolucion?>"/>
		
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
            <table align='left' border=0  width="100%">
            <tr>
                <th style="vertical-align: middle; text-align: center;" class="fondo_fondo">
                <?=$ObjDeco->CuadroLabels($lang->descuento,'sin_nombre','derecha','')?>
				</th>
                <td nowrap>
                <input type="text" name="global_sale_discount" id="global_sale_discount" onChange=" ajaxpage_2('sale_ui.php?actionID=quest&IDLoc='+document.getElementById('global_sale_discount').value,'preg','preg');"  class="cajas_22" size="3">
			<input type="hidden" name="sale_discount" id="sale_discount" value="0" class="cajas_22" />
            
			<input type='button' name='updateQuantity<?=$k?>' disabled='true' id='updqty' value='<?=$lang->update?>'  onclick='retval();' class='display_naranja'>
			<? echo	"Desc: $cfg_currency_symbol$decuent - $descuentporc % </td></tr>";?>


                </td>
			<tr>
                <td colspan="2"><div id="preg"></div>
                </td>
            </tr>
			<tr >
                <th align='left' style="vertical-align: middle; text-align: center;" >
				 <?=$ObjDeco->CuadroLabels('Subtotal,VTA','sin_nombre','derecha','')?>
                </th>
                <td align="center"  class="fondo_fondo">
                    <span style="font-size: 24; color: blue; text-align: center">
                    <strong><?=$cfg_currency_symbol?></strong></span>
                    <strong><span style="font-size: 24; color: blue; text-align: center" id="str_sub_tot"> <?=$finalSubTotal?></span></strong>
                   
                  <input name="subtotalvta" type="hidden" id="stvta" size="6" style="text-align:center" readonly maxlength="8" value="<?=$finalSubTotal?>"   />
                  <input type="hidden" name="sub_tot" id="sub_tot" value="<?=$finalSubTotal?>" />
                </td>
            </tr>
            <tr>
                <th style="vertical-align: middle; text-align: center; ">
				<?=$ObjDeco->CuadroLabels('Impuesto,VTA','sin_nombre','derecha','')?> 
                </th>
                <td class="fondo_fondo">
                <?=$cfg_currency_symbol?>
                <input name="taxtot" type="text" id="taxtot" size="4" style="text-align:center" readonly maxlength="8"  class="cajas_22"value="<?=$finalTax?>"   />
                <input type="hidden" name="imp_tot" id="imp_tot" value="<?=$finalTax?>" />
                </td>
            </tr>
			<tr>
                <th style="vertical-align: middle; text-align: center;">
				<?=$ObjDeco->CuadroLabels($lang->descuento,'sin_nombre','derecha','')?> 
                </th>
                <td class="fondo_fondo">
                <?=$cfg_currency_symbol?>
             <input name="descuentshow" type="text" class="cajas_22" id="descuentshow" size="4" style="text-align:center" readonly maxlength="8" value="<?= number_format($descuent)?>"/>
                <input type="hidden" name="descuent" id="descuent" value="0" />
                <input type="hidden" name="descuentporc" id="descuentporc" value="0" /><span id="showdescporc">&nbsp;&nbsp;</span>
			
                </td>
            </tr>
            <tr>
                <th style="vertical-align: middle; text-align: center; ">
				<?=$ObjDeco->CuadroLabels($lang->saleTotalCost,'sin_nombre','derecha','')?> 
                </th>
                <td align="center" class="fondo_fondo">
                <span style="font-size: 24; color: blue; text-align: center" >
                <strong><?=$cfg_currency_symbol?></strong></span><strong>
                <span style="font-size: 24; color: blue; text-align: center" id="str_saleTotalCost"><?=$tot_rowTotal?></span></strong>
                <input name="saleTotalCost" type="hidden" id="saleTotalCost" size="6" style="text-align:center" readonly maxlength="6" value="<?=$tot_rowTotal?>"/>
                </td>
            </tr>
			<tr>
                <th style="vertical-align: middle; text-align: center; ">
                <?=$ObjDeco->CuadroLabels($lang->vrtot,'sin_nombre','derecha','')?>
                </th>
                <td  class="fondo_fondo">    
                    <input type=text name='amountpay' id='amountpay' readonly style='text-align:right' class="cajas_22 fondo_dollar_active"   value='' size='8'>
                </td>    
            <tr>
	<th style="vertical-align: middle; text-align: center;">
	<?=$ObjDeco->CuadroLabels($lang->amtChange,'sin_nombre','derecha','')?></th>
	<td  class="fondo_fondo">
	<input type=text name='changep' id='changep' readonly style='text-align:right'   value='' size='8' class="cajas_22 fondo_dollar_active">
	<input type=hidden name='j' id='j'   value='$k'><input type=hidden name='cliente' id='cliente' value=''>
    <input type='button' id='addsale' value='<?= $lang->addSale?>' onclick='asig();'  class="display_naranja" style="padding:5px;padding-top:15px; padding-bottom:25px">
    <input type=hidden name='totalvta' id='totalvta'   value='$totalvta'>
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
				$paymethod_id[] 	= $row['id'];
				$paymethod_name[] 	= $row['name'];
				$paymethod_change[] = $row['change'];
				$paymethod_desabi[] = $row['desabilitado'];
				//	$brands_total[$row_paymethod['id']]=0;

			}

			//////////////////////////////////////////

?>
	<table align="center" border="0" class="fondo_fondo" width="99%">
	<tr>
		<th style="vertical-align: middle; text-align: center; " width="5%" nowrap><div align="center"><strong><font color='white'>
        <?=$ObjDeco->CuadroLabels_puntas_vino($lang->paidWith,'sin_nombre','centro','')?></font></strong></div></th>
		<th style="vertical-align: middle; text-align: center; " width="5%" nowrap><div align="center"><strong><font color='white'>
		<?=$ObjDeco->CuadroLabels_puntas_vino($lang->amount,'sin_nombre','centro','')?></font></strong></div></th>
		<th style="vertical-align: middle; text-align: center; display:<?PHp echo DF_MEDIO_PAGO_COL_DOCUMENTO;?> " width="5%" nowrap>
			<div align="center"><strong><font color='white'>
			<?=$ObjDeco->CuadroLabels_puntas_vino($lang->doc_num,'sin_nombre','centro','')?></font></strong></div>
		</th>

        <th style="vertical-align: middle; text-align: center; display:<?PHp echo DF_MEDIO_PAGO_COL_ENTIDAD;?>" width="5%" nowrap><div align="center"><strong><font color='white'>
		<?=$ObjDeco->CuadroLabels_puntas_vino($lang->entity,'sin_nombre','centro','')?></font></strong></div></th>
		<th style="vertical-align: middle; text-align: center; display:<?PHp echo DF_MEDIO_PAGO_COL_AUTORIZA;?>  " width="5%" nowrap><div align="center"><strong><font color='white'>
		<?=$ObjDeco->CuadroLabels_puntas_vino($lang->auth_no,'sin_nombre','centro','')?></font></strong></div></th>
			</tr>


<? 




for ($k = 0; $k < count($paymethod_id); $k++) {

				$id 		= $paymethod_id[$k];
				$name 		= $paymethod_name[$k];
				$change 	= $paymethod_change[$k];
				$v_desabili = $paymethod_desabi[$k];

			 	$v_readonly	= ($v_desabili==1)?'readonly':' ';
			 	$v_class_des= ($v_desabili==1)?'cajas_22_des fondo_dollar_negro':' cajas_22 fondo_dollar_active';


?>  
				<tr>
				<th style="vertical-align: middle; text-align: center; " width="5%" nowrap>
	                <?=$ObjDeco->CuadroLabels_carbon($name,'sin_nombre','centro','')?>
					<? echo "<input type=hidden name='paymethodid[$k]'   value='$id' size='8'>
					<input type=hidden name='change[$k]' id='change[$k]'   value='$change' size='8'>
					<input type=hidden name='paymethodname[$k]' id='paymethodname[$k]'   value='$name' size='8'>";?>
				</th>
				
				<td>
					<input onclick="js_abrir_cal('amount[<?PHp echo $k;?>]');" <?PHp echo $v_readonly;?> style="padding:5px;text-align:right;padding-right:10px !important;" type=text name='amount[<?PHp echo $k;?>]' id='amount[<?PHp echo $k;?>]'   value=''  onblur='cambamount(this);'  onchange='cambamount(this);' onkeyup='cambamount(this);'  class='<?PHp echo $v_class_des?> '>
				</td>
				<? if ($change == 1) {?>
					<td style="display:<?PHp echo DF_MEDIO_PAGO_COL_DOCUMENTO;?>"><? echo "<input type=text name='doc_num[$k]' id='doc_num[$k]'   value='' size='8' class='cajas_22'>";?></td>
					<td style=" display:<?PHp echo DF_MEDIO_PAGO_COL_ENTIDAD;?>"><select name="<? echo "entity$k";?>" id="<? echo "entity[$k]";?>" style="width:100px;"  class="forma_select_1">	<option value="0">Elija</option>
					<? $rc_detailp = mysql_query('select id, name  from pos_pay_methoddetail  where paymethodid = '.$id.' and cancel = 0',$conn_2);
					while ($rowdet = mysql_fetch_assoc($rc_detailp)) {?>
						<option value="<?=$rowdet["id"]?>"><?=$rowdet["name"]?></option><? }?>
					</select></td>
					<td style="display:<?PHp echo DF_MEDIO_PAGO_COL_AUTORIZA;?>"><? echo "<input type=text name='auth_num[$k]' id='auth_num[$k]'  class='cajas_22'  value='' size='8'><input type='hidden' name='k' id='k' value='$k' />
				<input type='hidden' name='m' id='m' value='$k' />";
?>
					</td>
					
					<? }?> 
				</tr>
				<? } echo "<input type='hidden' name='nummp' id='nummp' value='$k' />";?>
			<tr>
			<th style="vertical-align: middle; text-align: center; " width="5%" nowrap>
            <?=$ObjDeco->CuadroLabels_carbon($lang->saleComment,'sin_nombre','centro','')?>
            </th>
			<td colspan="4" ><? echo
			"<input type='text' name='comment' id='comment' style='width:99%'  class='cajas_22'/>";?></td>
			<input type='hidden' name='claveok' id="claveok" value='0'>	</tr>
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
		<td><input type="text" name="username" id="username"  class="cajas_22"/></td>
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
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
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
		$algtext = 'style="text-align:center"';?>
        </table><table>
		<tr bgcolor="<?=$bgcol?>">
		<td colspan="6" align="center"><b><?=$lang->posologia?></b></td>
		</tr>
		<tr bgcolor="<?=$bgcol?>">
		<td rowspan="2" align="center"><b><?=$lang->medicamento?></b></td>
		<td colspan="3" align="center"><b><?=$lang->dosis?></b></td>
		<td rowspan="2" align="center"><b><?=$lang->quantity?></b></td>
		</tr>
		<tr bgcolor="<?=$bgcol?>" >
		<td align="center"><b><?=$lang->tomar?></b></td>
		<td align="center"><b><?=$lang->cada?></b></td>
		<td align="center"><b><?=$lang->durante?></b></td>
		</tr>
		<? $rc_itemssales = mysql_query('select * from pos_sales_items where sale_id= '.
		$saleID.'',$conn_2);
		$b = 0;

		while ($row = mysql_fetch_assoc($rc_itemssales)) {
			$rc_infoitem = mysql_query(' select item_number, item_name, cronico from pos_items where id ='.
				$row['item_id'].'',$conn_2);
			$row_item = mysql_fetch_assoc($rc_infoitem);
			if ($row_item['cronico'] == 1) // 1 producto cronico

			{?>
				<tr bgcolor="<?=$bgcol?>" >
				<td align="center"><?=$row_item['item_name']?></td>
				<td align="center"> <input type="hidden" name="itemid[<?=$b?>]" id="itemid[<?=$b?>]" value="<?=$row['item_id']?>" />
				<input type="hidden" name="itemdescription[<?=$b?>]" id="itemdescription[<?=$b?>]" value="<?=$row_item['item_name']?>" />
				<input type="text" name="toma[<?= $b?>]" size="2" id="toma[<?= $b?>]" <?=$algtext?> class="cajas_22"/><br>
				<select name="selecttoma[<?= $b?>]" id="selecttoma[<?= $b?>]"  class="forma_select_1">
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
				<td align="center"><input type="text" name="cada[<?=$b?>]" size="2" id="cada[<?=$b?>]" <?=$algtext?>  class="cajas_22"/><br>
				<select name="selectcada[<?=$b?>]" id="selectcada[<?=$b?>]"  class="forma_select_1">
				<option value="0">Elige...</option>
				<option value="1">Hora(s)</option>
				<option value="2">Dia(s)</option>
				<option value="3">Mes(es)</option>
				</select>
				</td>
				<td align="center"><input type="text" name="durante[<?=$b?>]" size="2" id="durante[<?=$b?>]" <?=$algtext?> class="cajas_22"/><br>
				<select name="selectdurante[<?=$b?>]" id="selectdurante[<?=$b?>]"  class="forma_select_1">
				<option value="0">Elige...</option>
				<option value="1">Hora(s)</option>
				<option value="2">Dia(s)</option>
				<option value="3">Mes(es)</option>
				</select></td>
				<td align="center"><input type="text" name="quantity[<?=$b?>]" size="2" id="quantity[<?=$b?>]" <?=$algtext?> class="cajas_22" /></td>
				</tr>
				<? $b++;
			}
		}
	} // if($act != 1)

?><input type="hidden" name="b" id="b" value="<?=$b
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
                window.opener.document.getElementById('customerDoc_list').value = <?=$account_number?>;
                window.opener.searchCustomer(<?=$account_number?>,4);                
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
            window.opener.document.getElementById('customerDoc_list').value = <?=$account_number?>;
            window.opener.searchCustomer(<?=$account_number?>,4);
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

<select name="customer_list" id="customer_list"  class="forma_select_1">
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
	<td><? echo $lang->username?>:</td>
	<td><input type="text" name="username" id="usernameadmon" size="15" class="cajas_22" /></td>
	</tr>
	<tr>
	<td><? echo $lang->password?>:</td>
	<td><input type="password" name="clave" id="claveadmon" size="15" /></td>
	</tr>
	<tr>
	<td colspan="2">
	<div align="center">
	<input type="submit" name="button" id="button" value="Enviar" onClick="return Validaradmon(2);" >
	</div></td>
	</tr>
	</table>

	<? }

if ($actionID == 'ListItemTable') {
	$table_bg 		= $display->sale_bg;
	$items_table 	= "$cfg_tableprefix".'items';
	$almacen_pac 	= $dbf->idToField('pos_pacientes','almacenid',$customer_list);


//echo 'customer_list='.$customer_list.', num_formu='.$num_formu.',tipo_vta= '.$tipo_vta;?>
<table border='0'  cellspacing='0' cellpadding='2' align='center' class="tablesorter" bgcolor='<?=$table_bg?>' width="100%">
        <?php //
	if ($tipo_vta == '2') {
		$sqlTvta = " AND tipo_vta = 2";
		if ($customer_list) {
			$sqlTvta .= " AND customer_id = '$customer_list' AND formula = '$numFormula'";
		}
	} else {
		$sqlTvta = ' AND tipo_vta = 1';
	}
	
	$rc_saleopen = mysql_query('select id  from pos_sales where sold_by = '.$userId.' and status = 0  '.$sqlTvta,$conn_2);
	$saleopen = mysql_fetch_assoc($rc_saleopen);
	if ($saleopen['id'] != '')
		$sale_id = $saleopen['id'];
	else
		$sale_id = '';
	//    if ($sale_id == '')
	//        exit;

?>    

<thead><tr>
<? if ($tipo_vta == '2') {?>    
	<th nowrap><?=$lang->typeVta?></th>
<?php }?>             
	<th><?=$lang->itemID?></th>
	<th><?=$lang->itemName?></th>
	<th><?=$lang->pvc?></th>
        <!-- Yaruro 09-10-2013 Cambio
        <th>< ?=$lang->porcdesto?></th>
    	<th nowrap>< ?=$lang->vlrdsto?></th>
	
	<th>< ?=$lang->vlrcondsto?></th> -->
	<th><?=$lang->porciva?></th>
	<th><?=$lang->vlriva?></th>
	<th style="display:<?PHp echo DF_COL_FRACCION;?>"><?=$lang->pvp?></th>
	<th nowrap><?php if ($tipo_vta == '2') {
		?><?=$lang->disp?>&nbsp;&nbsp;&nbsp;<?=$lang->formu?> (P) <?php }?>&nbsp;&nbsp;&nbsp;<?=$lang->cant;?>&nbsp;&nbsp;&nbsp;<?=$lang->fraccion?>
	</th>

	<th  style="display:<?PHp echo DF_COL_UNIDAD_VENTA;?>"><?=$lang->past?></th>

	<th><?=$lang->vlrtot?></th>
	<th><?=$lang->cancel?></th>
</tr>
</thead>
        <?php //

	if ($sale_id != '' and $item != '') {
		if ($tipo_vta == '2') {
			if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
				$SQLp="select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_vta as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '".$customer_list."'";
				$rc_positems = mysql_query($SQLp,$conn_2);
			
			} else {
				$SQLp="select pos_items.id,pos_items.tax_percent,pos_itemconvenio.price_evento as unit_price,pos_items.pack,pos_items.buy_price,pos_items.tax_percent FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.item_number = '".$item."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '".$customer_list."'";
				$rc_positems = mysql_query($SQLp,$conn_2);
			}
		} else {
			$rc_positems = mysql_query('select * from pos_items where item_number = '.$item.'',$conn_2);
		}
		$positems = mysql_fetch_assoc($rc_positems);
		$temp_item_tax = $positems['tax_percent'] / 100 * $positems['unit_price'];
		$costtot_item = $positems['unit_price'];
		$salesdetail_table = $cfg_tableprefix.'sales_items';
		$field_names = array(	'sale_id',
								'item_id',
								'quantity_purchased',
								'item_unit_price',
								'item_buy_price',
								'item_tax_percent',
								'item_total_tax',
								'item_total_cost',
								'unit_sale',
								'sale_frac'
							);
		$field_data = array($sale_id,$positems['id'],1,$positems['unit_price'],$positems['buy_price'],
			$positems['tax_percent'],$temp_item_tax,$costtot_item,1,$positems['pack']);
		$dbf->insert($field_names,$field_data,$salesdetail_table,false);

	}

	$query = "select * from pos_sales_items where sale_id = ".$sale_id." order by id desc";
	//echo "select * from pos_sales_items where sale_id = ".$sale_id."";
	$result_posslaesitem = mysql_query($query);
	$k = 0;
?>
        <input type="hidden" name="sale_id" id="sale_id" value="<?=$sale_id?>"/>
        <tbody>
        <?php 
		//echo $SQLp.'//// '.$query;
		
		$lins = 0;
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
			if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
				$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_vta as unit_price, pos_items.pack, pos_items.quantity, pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".$row_item['item_id']."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";
			} else {
				$sql = "SELECT pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_evento as unit_price, pos_items.pack, pos_items.quantity, pos_itemconvenio.price_evento FROM pos_items, pos_itemconvenio,pos_pacientes WHERE pos_items.id = '".$row_item['item_id']."' and pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and pos_pacientes.id = '$customer_list'";

}
			$result = mysql_query($sql,$conn_2);
			$num_rows = mysql_num_rows($result);
			$srtEvent = 'Disp.';
			if ($num_rows > 0) {
				$saleopen = mysql_fetch_assoc($result);
				if ($row_item['qtyrecetada'] >= 0) {
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
				if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
					$tipoVenta = '<span style="font-size: 13px;cursor:pointer" id="tipoDisp'.$k.'" onclick="cambioDisp('.$k.','.$row_item['tipo'].')"><strong>'.$srtEvent.'</strong></span>';
				} else {
					
					$tipoVenta = '<span style="font-size: 13px;cursor:pointer" id="tipoDisp'.$k.'" ><strong>'.$srtEvent.'</strong></span>';
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
<tr style="background-color: #015B7E;">
		<input type="hidden" value="<?=$itipo_Vta?>" name="itipovta[<?=$k?>]" id="itipovta<?=$k?>" />
		<? 
		#if ($canc == 1)	 'readonly';else $readon = '';
		$readon =($canc == 1)?'readonly':'';

		if ($tipo_vta == '2') {?>
                <td align='center' nowrap style="text-align: right;color: #015B7E;  font-weight: bold;"><?=$tipoVenta?></td><?php 
            }
?>      
			<td align='center' nowrap style="text-align: right;color: #015B7E;  font-weight: bold;"><?=$temp_item_code?></td>
			<td align='left' nowrap style="text-align: right;color: #015B7E; height:20px;"><?=$resto?></td>
				<input type="hidden" name='price<?=$k?>' style='text-align:center' readonly value='<?=$temp_sindsto2?>' size='6' class="cajas_22">
				<!--
                                <td align='center' nowrap></td>
				<td nowrap style="text-align: center;color: #015B7E;  font-weight: bold;">0 < ?=$lang->sigporc?></td>
				<td nowrap style="text-align: center;color: #015B7E;  font-weight: bold;">< ?=number_format($valdsto,0,'','');?></td>-->
				
			<td nowrap style="text-align: center;">
          		<input type=text name='price<?=$k?>' readonly  class="cajas_22 fondo_dollar_active"style='text-align:right' id='pricedcto<?=$k?>' value='<?= number_format($temp_price2,0,'','');?>' size='6'>
            </td>
			<td nowrap   style="text-align: center;">
                <input type=text id="tax<?=$k?>" name='tax<?=$k?>' class="cajas_22" style='text-align:center;width: 25px;'  readonly  value='<?=$temp_tax?>' size='5'>
            </td>
			<td nowrap  style="text-align: center;">
                <input type=text id="valimp<?=$k?>" name='valimp<?=$k?>' style='text-align:center;width: 35px;' class="cajas_22"  readonly  value='<?=$valimp2?>' size='6'>
			</td>
			<td nowrap style="text-align: center;">
                <input type=text name='price<?=$k?>' readonly style='text-align:right'  class="cajas_22 fondo_dollar_active"value='<?=$temp_pricepub2?>' size='6'>
            </td>
	<td nowrap  style="text-align: center; display:<?PHp echo DF_COL_FRACCION;?>">

					<?PHp if ($tipo_vta == '2' && $itipo_Vta == '2') {

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
					<input type=text name='dispo<?=$k?>' id='dispo[<?=$k?>]' readonly   class="cajas_22"style='text-align:center; width: 35px;' value='<?= number_format($inveQty,0,'','');?>' size='6'>

					<input type=text name='orden<?=$k?>' id='orden[<?=$k?>]'  class="cajas_22"style='text-align:center; width: 35px; background-color:#FFFFD8' value='<?= number_format($formu_quantity,0,'','');?>' size='7' <?=$disableFormu?> onchange='validFormulada(<?=$k?>,<?=$temp_quantity?>)'> (<?= number_format($temp_quantityB,'2',',','')?>)
					<? } else {
								if ($tipo_vta == '2') {?>

					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php }?>

					<input type="hidden" name='dispo<?=$k?>' id='dispo[<?=$k?>]' <?=$readon?>  style='text-align:center; width: 35px;' value='<?= number_format($inveQty,0,'','');?>' size='6'>
					<input type="hidden" name='orden<?=$k?>' id='orden[<?=$k?>]' value='0'><?php }?>
					                
					<input type='text' name='quantity<?=$k?>' id='qty[<?=$k?>]' onchange="validQtyInv(this.value,<?=$k?>,'<?=$temp_quantityB?>')"  <?=$readon?>  style='text-align:center; width: 25px;' value='<?= number_format($temp_quantity,0,'','');?>' size='3' onchange="updateitemsale(<?=$k?>)"> (<?=$temp_pack?>)
</td>

<td nowrap align='center'style="display:<?PHp echo DF_COL_UNIDAD_VENTA;?>">
	<input type='hidden' name='pack<?=$k?>' id='pack[<?=$k?>]' value='<?=$temp_pack?>'/> 
			<select name='past<?=$k?>' id='past[<?=$k?>]' onChange="updateitemsale(<?=$k?>)"style="width:50px;">
				<option value="1"
            <?php if (!(strcmp("1",$temp_packing))) {echo $selected = "selected=\"selected\"";}?>
                        >Unidad</option>
                        
           <?php if ($temp_pack != 1)?>
                        <option value="2"
            <?php 
			if (!(strcmp("2",$temp_packing))) {	echo $selected = "selected=\"selected\"";}?>
                        >Frac</option>
                    </select>
			</td>
			<td align='center' nowrap><font color='#015B7E'><b><?=$cfg_currency_symbol.number_format($vlrtot,0)?></b></font>
				<input type='hidden' name='temp_pricepub2<?=$k?>' id='pvpfin[<?=$k?>]' value='<?=$temp_price2?>'/>
				<input type='hidden' name='preciocompra<?=$k?>' id='preciocompra[<?=$k?>]' value='<?=$preciocompra?>'/>
				</td>
                <?php //			  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>
		if ($row_item['toWS']) {?>
                <input type='hidden' name='item_id<?=$k?>' id='item_id[<?=$k?>]' value='<?=$temp_item_id?>'>
                <input type='hidden' name='idpossalesitems<?=$k?>' id='idpossalesitems[<?=$k?>]' value='<?=$idpossalesitems?>'>
				<input type='hidden' name='<?=$k?>' value='<?=$k?>'>
			<td align="center">FORMU</td>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?=$k?>" />
				<?php } else {		if ($canc == 0) {?>
                <input type='hidden' name='item_id<?=$k?>' id='item_id[<?=$k?>]' value='<?=$temp_item_id?>'>
				<input type='hidden' name='idpossalesitems<?=$k?>' id='idpossalesitems[<?=$k?>]' value='<?=$idpossalesitems?>'>
				<input type='hidden' name='<?=$k?>' value='<?=$k?>'>
			<td align='center'><a href=javascript:void(0)  class=InvUpText ><font color="#FFFFFF"></font></a>
                <img src="../images/cancel.png" border="0" title="<?=$lang->cancel?>"   onClick=javascript:cancelitemsale(<?=$k?>);  style="cursor:pointer"/>
                <input type="hidden" value="1" name="ItemOn" id="ItemOn<?=$k?>" />
				
					<? } else {?>
			<td colspan="2" align="center" nowrap>
                <input type="hidden" value="0" name="ItemOn" id="ItemOn<?=$k?>" />
                <font color="white">A N U L A D O</font>
			</td>
				
				<? }
		}
?>
                <input type='hidden' name='showitem<?=$k?>' id='showitem<?=$k?>' value='<?=$showitem?>' />
				</td>
            </tr>
			<? 
		if ($can == 1) {
			//echo '<tr><td>dsds</td><td>'.$k.'</td></tr>';

		}
		
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
?><input id="total_productos_pedidos" type="<?php echo HIDDEN;?>" value="<?php echo $k;?>"><?
	$rc_tax = mysql_query('select 
								pos_tax_rates.tax_rates_id  
								, pos_tax_rates.tax_rate 
							from 
								pos_tax_class
								, pos_tax_rates 
							where 
								pos_tax_rates.tax_class_id = pos_tax_class.tax_class_id 
								and pos_tax_class.tax_class_id = 1'
						,$conn_2
						);
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
                <th colspan="<?=$numcolTotal?>" style="text-align: right; font-size:16px"><?=$lang->totDis?> </th>
				<th style="text-align: center; font-size:16px;"><b><?= number_format($tot_temp_sindstoD,0)?> </th>
				<!--Yaruro 09102013
                                <th style="text-align: center; font-size:16px;"></th>
				<th style="text-align: center; font-size:16px;">< ?= number_format($tot_valdstoD,0)?> </th>
				<th style="text-align: center; font-size:16px;">< ?= number_format($tot_temp_priceD,0)?> </th>-->
				<th style="text-align: center; font-size:16px;"></th>
				<th style="text-align: center; font-size:16px;"><?= number_format($tot_valimpD)?></th>
                <th style="text-align: center; font-size:16px;"><?= number_format($tot_temp_pricepubD)?></th>
				<th style="text-align: center; font-size:16px;">&nbsp;&nbsp;<?=$qtyProD?></th>
				<th style="text-align: center; font-size:16px;"></th>
				<th style="text-align: center; font-size:16px;"><?= number_format($tot_rowTotalD)?></th>
				
				<th style="text-align: right;">	
                </th>
            </tr>
        </thead>
<?php }
?>        
        <thead>
            <tr> 
                <th colspan="<?=$numcolTotal?>" style="text-align: right; font-size:16px;"><?=$lang->tot?></th>
				<th style="text-align: center; font-size:16px;"><b><?= number_format($tot_temp_sindsto,0)?></th>
				<!-- Yaruro 09102013 Cambio se comenta por peticion del clientes.
                                <th style="text-align: center;"></th>
				<th style="text-align: center; font-size:16px;">< ?= number_format($tot_valdsto,0)?></th>
				<th style="text-align: center; font-size:16px;">< ?= number_format($tot_temp_price,0)?></th>-->
				<th style="text-align: center;"></th>
				<th style="text-align: center; font-size:16px;"><?= number_format($tot_valimp)?></th>
				<th style="text-align: center; font-size:16px;"><?= number_format($tot_temp_pricepub)?></th>
				<th style="text-align: center; font-size:16px;">&nbsp;&nbsp;<?=$qtyPro?></th>
				<th style="text-align: center;"></th>
				<th style="text-align: center; font-size:16px;"><?= number_format($tot_rowTotal)?></th>

				<th style="text-align: right;">
                <input type="hidden" value="<?=$lins?>" name="totLin" id="totLin" />
                <input name="totvta" type="hidden" id="totvta" value="<?=$tot_temp_pricepub?>"/>
            		<input name="tots" type="hidden" id="tots" value="<?=$tot_rowTotal?>"/>
                    <input name="customerid" type="hidden" id="customerid" value="<?=$customer_list?>"/>
                    <input name="devolucionid" type="hidden" id="devolucionid" value="<?=$devolucion?>"/>
		
                </th>
            </tr>
        </thead>
		<? 
	$aa 				= $finalSubTotal;
	$finalSubTotal 		= $tot_rowTotal;
	$finalTax 			= number_format($finalTax,0,'','');
	$totalvta 			= $tot_rowTotal;
	$finalTotal 		= number_format($finalTotal,0,'','');
?>
        </table>
<?php exit;
}

if ($actionID == 'modifiItem') {
	$items_table = "$cfg_tableprefix".'items';
	if ($tipo_vta == '2' && $_REQUEST['qtyreceta'] >= 0) {
		$almacen_pac = $dbf->idToField('pos_pacientes','almacenid',$customer_list);
		if ($almacen_pac == $cfg_locationid || $almacen_pac == '999' || $almacen_pac!='') {
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
			//if ($_POST['tipoDisp'] == '3') {
                        if ($_POST['tipo_disp'] == '3') {    
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
function ver_div_autocompletar()
{
	?><div class="suggestionsBox" id="suggestions" style="display: none;" >
                        <div align="center"><img src="../imagenes/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" /></div>
                        <div class="suggestionList" id="autoSuggestionsList"  style="overflow:scroll;  overflow-x:hidden; width:600; height:200;" onClick="updateScanItem(1,1);">
		                 <?PHp //include('rpc_new.php');?>
                        </div>
                    </div>
<script>
function js_active_item_favorite()
	{

		jQuery('#suggestions').show('slow');

	}

function lookup(inputString) {



    <?php if ($tipo_vta == '2') {?>
        if(!document.getElementById('customer_list').value){
            alert('Seleccione un Paciente para Realizar la busqueda');
    document.getElementById('item').value = '';
    document.getElementById('inputString').value = '';
    document.getElementById('item_search2').value = '';
            return;   
        }
    <?php }?>
    
	if(inputString.length == 0) {
		// Hide the suggestion box.
		$('#suggestions').hide();
	} else {
	if(inputString.length ><?PHp echo DF_MINIMO_LETRA_AUTOCOMPLETE_ITEM;?>){	
	
	 jQuery("#inputString").addClass("fondo_carga");
	 
		$.post("rpc_new.php", 
			{	queryString: ""+inputString+"",
				tipo_vta: document.getElementById('tipo_vta').value,
				customer_list : document.getElementById('customer_list').value
			}, 
				
		function(data){
			if(data.length >0) {
				$('#suggestions').show();
				$('#autoSuggestionsList').html(data);
				 jQuery("#inputString").removeClass("fondo_carga");
				
			}
		});
		}
	}
} // lookup

function fill(thisValue,precio,unidad) {
	$('#inputString').val(thisValue);
	
	setTimeout("$('#suggestions').hide();", 200);
	jQuery('#d_to_pre').html(precio);
	jQuery('#d_to_inv').html(unidad);
		
	if(thisValue){	
		var ff	=thisValue.split("::");
		var plu	=ff[0];
	sincronizar_inventario(plu,'<?php echo LOCATION_ID;?>');
	}
}

</script>				
					
					<?php
	}



function fc_tipo_venta($tipo_venta)	
	{
?> <select name='tipo_vta' onChange="formSubmit()" id="tipo_vta"  style="width:55px;" class="forma_select_1 cajas_22">
                            <? $Seleccion = ''; if ($tipo_vta == '1') {	echo $Seleccion = 'selected';}?>
                            	<option value='1' <?=$Seleccion?> >Venta</option>
                            <? $Seleccionb = '';if ($tipo_vta == '2') { echo $Seleccionb = 'selected';}?>
                            	<option value='2' <?=$Seleccionb?>>Dispensaci&oacute;n</option>
                            </select><?PHp

	}


function func_numero_para_pago()
	{

		?>
		<table  align="center">
		<tr>
			<td class="cl_billete_cop" onclick="js_add_monedo(1000)" valign="middle" ><div class="all_billete cuadro_1000"><img src="../images/ico/billete_1000.png" alt="Billete Mil Pesos"></div></td>
			<td onclick="js_add_monedo(1)" valign="middle" ><div class="boton_numero"><p>1</p></div></td>
			<td onclick="js_add_monedo(2)" valign="middle" ><div class="boton_numero"><p>2</p></div></td>
			<td onclick="js_add_monedo(3)" valign="middle" ><div class="boton_numero"><p>3</p></div></td>
		</tr>
		<tr>
			<td class="cl_billete_cop" onclick="js_add_monedo(2000)" valign="middle" ><div class="all_billete cuadro_2000"><img src="../images/ico/billete_2000.png" alt="Billete Dos Mil Pesos"></div></td>
			<td onclick="js_add_monedo(4)" valign="middle" ><div class="boton_numero"><p>4</p></div></td>
			<td onclick="js_add_monedo(5)" valign="middle" ><div class="boton_numero"><p>5</p></div></td>
			<td onclick="js_add_monedo(6)" valign="middle" ><div class="boton_numero"><p>6</p></div></td>
		</tr>
		<tr>
			<td class="cl_billete_cop" onclick="js_add_monedo(5000)" valign="middle" ><div class="all_billete cuadro_5000"><img src="../images/ico/billete_5000.png" alt="Billete Cinco Mil Pesos"></div></td>
			<td onclick="js_add_monedo(7)" valign="middle" ><div class="boton_numero"><p>7</p></div></td>
			<td onclick="js_add_monedo(8)" valign="middle" ><div class="boton_numero"><p>8</p></div></td>
			<td onclick="js_add_monedo(9)" valign="middle" ><div class="boton_numero"><p>9</p></div></td>
		</tr>
		<tr>
			<td class="cl_billete_cop" onclick="js_add_monedo(10000)" valign="middle" ><div class="all_billete cuadro_10000"><img src="../images/ico/billete_10000.png" alt="Billete Diez Mil Pesos"></div></td>
			<td class="cl_billete_cop" onclick="js_add_monedo(50000)" valign="middle" ><div class="all_billete cuadro_50000"><img src="../images/ico/billete_50000.png" alt="Billete Cincuenta Mil Pesos"></div></td>
			<td onclick="js_add_monedo('cero')" valign="middle" ><div class="boton_numero"><p>0</p></div></td>
			<td onclick="js_add_monedo('prev')" valign="middle" ><div class="boton_numero"><img src="../images/ico/prev_caja.png" alt="Borrar Ultima Accion"></div></td>
		</tr>
		</table>
		<?PHp
	}





?>
