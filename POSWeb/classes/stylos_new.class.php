<?
//if($userid!=196){
 //->MIRAMOS SI EL USUARIO DESICIDIO CAMBIA EL COLOR 

if($CamColorSession=='TRUE')
{//echo 'entro';
	CambiarSessionColor($COLORSESSION);
}
//} //->AHORA MIRAMOS SI QUIERE CAMBIAR EL FONDO 
if($CamColorSessionFondo=='TRUE')
{//echo 'entro';
	CambiarSessionColorFondo($COLORSESSIONFONDO);
}

//->EMPEzAMOS A SESSIONAR LOS COLORES DEL USARIO DE FONDO
 $COLORSESSIONUSERFONDO=ColorFondoUSER($FOL);

//->EMPESAMOS A SESSIONAR LOS COLORES DEL USARIO
 $COLORSESSIONUSER=ColorUSER($FOL);
$SQL='SELECT *  FROM  stylosdinamicos  WHERE color="'.$COLORSESSIONUSER.'"';	
//					if($BG = &$conn->Execute($SQL)===false){echo 'Error SQL!!!{'.$SQL.'}';exit;}

//echo $userid;
				if($userid==196)
				{
				//echo 'SELECT *  FROM  stylosdinamicos  WHERE color="'.$COLORSESSIONUSER.'"';
					//echo $_SESSION["StyleColor"];
					//echo $COLORSESSIONUSERFONDO;
				}	

$N_style['PestBorderColor'] 		=$BG->fields['PestBorderColor'];
$N_style['N_PesBorderColorbg']		=$BG->fields['N_PesBorderColorbg'];
$N_style['N_PesBorderColortx']		=$BG->fields['N_PesBorderColortx'];
$N_style['PestBorderText']			=$BG->fields['PestBorderText'];
$N_style['BodyColor']				=$BG->fields['BodyColor'];
//#2D485A
///////////////////////////////////////////////stylos de las barras menu

$N_style['FondoSobreBarraMenu']=$BG->fields['FondoSobreBarraMenu'];
?>

<style>

.forma_select_1{ 
color: #036; 
background: #FFFFFF; 
border: 1px solid #543229; 
	-moz-border-radius-topleft:2px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomleft:2px; /* -webkit-border-top-right-radius arriba derecha*/
	-moz-border-radius-topright:2px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomright:2px; /* -webkit-border-top-right-radius arriba derecha*/

} 

.cajas_22 {
	-moz-border-radius: 1px;
	-webkit-border-radius: 2px;
	font-family:Tahoma, Geneva, sans-serif;
	font-size: 15px;
	
	color: #033;
	background-color: #FFF;
	border: 1px solid  #036;	
}
.cajas_22:hover {
	border: 1px solid   #FF3;	
}
.cajas_22_des {
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	font-family:Tahoma, Geneva, sans-serif;
	font-size: 15px;
	
	color: #033;
	background-color: #CCC;
	border: 1px solid  #036;	
}
<!--CSS PARA LINKS INICIO-->
.contentRightSep {
    background: url("images/right_content_sep.gif") no-repeat scroll center bottom transparent;
    padding-bottom: 5px;
    padding-top: 10px;
}

.popScripts {
    background: none repeat scroll 0 0 #F2F7F9;
    border: 1px solid #91AFC4;
    float: left;
    width: 400px;
}
.popScripts_pe {
    background: none repeat scroll 0 0 #F2F7F9;
    border: 1px solid #91AFC4;
    float: left;
    width: 80px;
}
.EfectoZoom A:link {text-decoration: none}
.EfectoZoom A:visited {text-decoration: none}
.EfectoZoom A:active {text-decoration: none}
.EfectoZoom A:hover {font-size:20; font-weight:bold; color: #CCC;}


.popScriptLink {
    background: url("images/bullet.gif") no-repeat scroll 4px 9px transparent ;
    border-bottom: 1px solid #E5E5E5;
    color: #666666;
    font-size: 12px;
    padding: 8px 8px 8px 20px;
	height:13px;
	font-family:Tahoma, Geneva, sans-serif;
}
<!--CSS PARA LINKS FIN-->

.fondo{
	border: 0px solid #8796A8;
	background-image: url(<? echo URL_RAIZ_FONDO?>images/fondo_total_azul_claro_blanco.png);
	background-repeat: repeat-x;
	background-color:#E7EEF8;
	height:10px;
}

body{
	border: 0px solid #8796A8 !important;
	background-image: url(<? echo URL_RAIZ_FONDO?>images/fondo_total_azul_claro_blanco.png);
	background-repeat: repeat-x !important;
	background-color:#E7EEF8 !important;
	height:10px;

	}
.Borde_x{
	border: 1px solid #009;
	/*background-image: url(../images/display_azul.png);
	background-repeat: repeat-x;
	height:26px;
	background: #1e5799;  Old browsers */
background: -moz-linear-gradient(top,  #1e5799 0%, #2989d8 50%, #207cca 51%, #7db9e8 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#1e5799), color-stop(50%,#2989d8), color-stop(51%,#207cca), color-stop(100%,#7db9e8)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* IE10+ */
background: linear-gradient(to bottom,  #1e5799 0%,#2989d8 50%,#207cca 51%,#7db9e8 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */
height:20px;
	padding-top:8px;
-moz-border-radius-topleft: 9px;
-webkit-border-top-left-radius: 9px;
 border-top-left-radius: 9px;
-moz-border-radius-bottomleft: 9px;
-webkit-border-bottom-left-radius: 9px;
border-bottom-left-radius: 9px;	
	
}
.Borde_punta{
	border: 1px solid #009;
	background-image: url(../images/display_azul.png);
	background-repeat: repeat-x;
	height:16px;
	padding-top:8px;
}
.Borde_punta_vino{
	border: 1px solid #CA270D;
	background-image: url(../images/cuadro_vino.png);
	background-repeat: repeat-x;
	height:16px;
	padding-top:8px;
	-moz-border-radius-topleft:2px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomleft:2px; /* -webkit-border-top-right-radius arriba derecha*/
	-moz-border-radius-topright:2px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomright:2px; /* -webkit-border-top-right-radius arriba derecha*/
	
	
}
.fondo_dollar_active{

	background-image: url(../images/ico/currency_blue_dollar.png);
	background-repeat: no-repeat;
}

.fondo_dollar_negro{

	background-image: url(../images/ico/currency_blue_dollar_negro.png);
	background-repeat: no-repeat;
}


.fondo_carbon{
	border: 0px solid #8796A8;
	/*background-image: url(../images/fondo_total.png);
	background-repeat: repeat-x;
	*/
background: #b5bdc8; /* Old browsers */
background: -moz-linear-gradient(top,  #b5bdc8 0%, #828c95 36%, #28343b 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b5bdc8), color-stop(36%,#828c95), color-stop(100%,#28343b)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* IE10+ */
background: linear-gradient(to bottom,  #b5bdc8 0%,#828c95 36%,#28343b 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=0 ); /* IE6-9 */
height:26px;

-moz-border-radius-topleft: 9px;
-webkit-border-top-left-radius: 9px;
 border-top-left-radius: 9px;
-moz-border-radius-bottomleft: 9px;
-webkit-border-bottom-left-radius: 9px;
border-bottom-left-radius: 9px;	
}

.display_naranja{
		cursor:pointer;
	border: 2px solid #006;
	
	/*background-image: url(../images/display_naranja.png);
	background-repeat: repeat-x;

	background: #f6e6b4; /* Old browsers */
	background: -moz-linear-gradient(top,  #f6e6b4 0%, #ed9017 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6e6b4), color-stop(100%,#ed9017)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #f6e6b4 0%,#ed9017 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #f6e6b4 0%,#ed9017 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #f6e6b4 0%,#ed9017 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #f6e6b4 0%,#ed9017 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6e6b4', endColorstr='#ed9017',GradientType=0 ); /* IE6-9 */

	height:23px;
	-moz-border-radius-topleft:4px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomleft:4px; /* -webkit-border-top-right-radius arriba derecha*/
	-moz-border-radius-topright:4px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomright:4px; /* -webkit-border-top-right-radius arriba derecha*/
	-webkit-border-radius: 15px;
	-moz-border-radius: 15px;
	border-radius: 15px;
}

.display_naranja_max{
		cursor:pointer;
	border: 2px solid #006;
	
	/*background-image: url(../images/display_naranja.png);
	background-repeat: repeat-x;

	background: #f6e6b4; /* Old browsers */
	background: -moz-linear-gradient(top,  #f6e6b4 0%, #ed9017 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f6e6b4), color-stop(100%,#ed9017)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #f6e6b4 0%,#ed9017 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #f6e6b4 0%,#ed9017 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #f6e6b4 0%,#ed9017 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #f6e6b4 0%,#ed9017 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6e6b4', endColorstr='#ed9017',GradientType=0 ); /* IE6-9 */

	height:43px;
	-moz-border-radius-topleft:4px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomleft:4px; /* -webkit-border-top-right-radius arriba derecha*/
	-moz-border-radius-topright:4px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomright:4px; /* -webkit-border-top-right-radius arriba derecha*/
	-webkit-border-radius: 15px;
	-moz-border-radius: 15px;
	border-radius: 15px;
}


.display_naranja:hover {
   	border: 2px solid #006;
    background: url(../images/display_naranja_inverso.png) no-repeat top left;
	background-repeat: repeat-x;
    padding: 2px 6px;
	color: #333
	
}

.TexTitulo_label {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #FFF;
	padding-left: 5px;
	padding-top: 4px;
}

.fondo_fondo{
	border: 0px solid #8796A8;
	background-image: url(../images/fondo_total_azul_claro_blanco.png);
	background-repeat: repeat-x;
	height:10px;
}


.FondoBarra{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: #000;
	text-decoration: none;
	background-color: #FFF;
	background-image: url(../images/fondo_barra_azul.png);
	background-repeat: repeat-x;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #B3B6B0;
	border-right-color: #7A8180;
	border-bottom-color: #7A8180;
	border-left-color: #7A8180;
	cursor:pointer;
	margin:3px;
	padding-bottom:3px;
	padding-top:3px;
	padding-left:4px;
	padding-right:2px;
	-moz-border-radius-topleft:4px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomleft:4px; /* -webkit-border-top-right-radius arriba derecha*/
	}

.TexTilulodos{
	
	background:#778a98;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	}

/********************FUNCION PARA  LAS VENTANA EN AJAX FONDO NEGRO ESTE CSS ES PARTE DE css/dhtmlwindows.css SOLO ES LA BARRA TITULO******/
.drag-handle{ /*CSS for Drag Handle*/
	padding: 1px;
	text-indent: 3px;
	background-color: <?=$N_style['cajasborder']?>;
	color: DEBD8E;
	cursor: move;
	overflow: hidden;
	width: auto;
filter:progid:DXImageTransform.Microsoft.alpha(opacity=100);
	-moz-opacity: 1;
	opacity: 1;
	background-image: url(../images/cal_fondo.gif);
	background-repeat:  repeat-x;
	font-family: Arial;
	font-size: 14px;
	font-weight: bold;
	-moz-border-radius-topleft:8px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-topright:8px; /* -webkit-border-top-right-radius arriba derecha*/
}
#dhtmltooltip{
position: absolute;
left: -300px;
width: 150px;
border: 1px solid <?=$N_style['cajasborder']?>;
padding: 2px;
background-color: <?=$N_style['BodyColor']?>;
visibility: hidden;
z-index: 100;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

/*PARA LOS INPUT TEX*/
<?
$N_style['cajastx']=$BG->fields['cajastx'];
$N_style['cajasborder']=$BG->fields['cajasborder'];
$N_style['cajasBg']=$BG->fields['cajasBg'];
?>
.cajas {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	font-family: Tahoma;
	font-size: 9px;
	font-weight: bold;
	color: <?=$N_style['cajastx']?>;
	background-color: <?=$N_style['cajasBg']?>;
	border: 1px solid <?=$N_style['cajasborder']?>;	
}
.cajas_obli {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	font-family: Tahoma;
	font-size: 9px;
	font-weight: bold;
	color: <?=$N_style['cajastx']?>;
	background-color: #FF0;
	border: 1px solid <?=$N_style['cajasborder']?>;	
}

.cajas_inactiva {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	font-family: Tahoma;
	font-size: 9px;
	font-weight: bold;
	color: <?=$N_style['cajastx']?>;
	background-color: #000;
	border: 1px solid <?=$N_style['cajasborder']?>;	
}
.cajas_rojo {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	font-family: Tahoma;
	font-size: 9px;
	font-weight: bold;
	color: <?=$N_style['cajastx']?>;
	background-color: #666;
	border: 1px solid <?=$N_style['cajasborder']?>;	
}
.cajas_2_Sobre{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #000000;
	font-weight: bold;
	text-decoration: none;
	background-color: #FFFF99;
	border: 1px solid #8DB2E3;
		-moz-border-radius: 3px;
	-webkit-border-radius: 3px;

}

<?

?>
.BotonGeneral {
	/*-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	font-family: Tahoma;
	font-size: 10px;
	font-weight: bold;
	height:22px;
	color: #000;
	/*background-image: url(images_design/FondoBoton.png);*/
	/*background-repeat:   repeat-x;
	border: 2px solid < ?=$N_style['cajasborder']?>;
	text-transform: uppercase;
	/*background-color: < ?=$N_style['cajasborder']?>;*/
	-moz-border-radius: 5px;
	-webkit-border-radius:5px;
	font-family: Tahoma;
	font-size: 10px;
	font-weight: bold;
	height:44px;
	color: #000!important;
	background-image: url(images_design/FondoBoton.png);
	background-repeat:   repeat-x;
	border: 1px solid #F90;
	text-transform: uppercase;
	background-color: #FC0;
	cursor:pointer;
}


/****************ESTYLO PARA LOS BORDES DE LA PESTANA*/
.N_PesBorder
{
	
	border: 1px solid <?=$N_style['PestBorderColor']?>;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
/*******8ESTILO DE LOS BRDES GENERALS GRANDES*/
.BorderPesGrandes
{
border: 1px solid <?=$N_style['PestBorderColor']?>;
-moz-border-radius-topleft:8px; /* -webkit-border-top-left-radius arriba izquierda*/
-moz-border-radius-topright:8px; /* -webkit-border-top-right-radius arriba derecha*/

}
/***********************COLOR DE FONDO DE LA PESTANA Y TEXTO*/
.N_PesBorderColor
{
	background-color: <?=$N_style['N_PesBorderColorbg']?>;
	font-family: Tahoma;
	font-size: 9px;
	font-weight: bold;
	color: <?=$N_style['N_PesBorderColortx']?>;
	text-decoration: none;
	height:25px;
	word-spacing: -2px;
}

/****************ESTYLO PARA LOS EL TEXTO DE LA PESTANA*/

.N_PesText {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 8px;
	color: <?=$N_style['PestBorderColor']?>;
	font-weight: bold;
	text-transform: uppercase;
}
/****************ESTYLO PARA LOS EL TEXTO DE LA PESTANA QUE ESTAN OUT*/
<?
$N_style['N_PesBorderBG']=$BG->fields['N_PesBorderBG'];
$N_style['N_PesBordertex']=$BG->fields['N_PesBordertex'];
?>
.N_PesBorder_2
{
	
	background-color: <?=$N_style['N_PesBorderBG']?>;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: normal;
	color: <?=$N_style['N_PesBordertex']?>;
	text-decoration: none;
	height:20px;
}
.N_PesBorder_2_Border
{
border: 1px solid <?=$N_style['N_PesBorderBG']?>;
-moz-border-radius-topleft:5px; /* -webkit-border-top-left-radius arriba izquierda*/
-moz-border-radius-topright:5px; /* -webkit-border-top-right-radius arriba derecha*/

}
.N_PesBorder_2Tx
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: normal;
	color: <?=$N_style['N_PesBordertex']?>;
	text-decoration: none;
}
<?
$N_style['N_PesBordertexhover']=$BG->fields['N_PesBordertexhover'];

?>
.N_PesBorder_2Tx:hover
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: normal;
	color: <?=$N_style['N_PesBordertexhover']?>;
	text-decoration: none;
}
<?
$N_style['sencilloTx']=$BG->fields['sencilloTx'];
$N_style['sencilloTxhover']=$BG->fields['sencilloTxhover'];
?>
.sencillo {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
	text-transform: capitalize;
	color: <?=$N_style['sencilloTx']?>;
}
.sencillo:hover {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
	text-transform: capitalize;
	color: <?=$N_style['sencilloTxhover']?>;
}

/*****************8PARA LOS CUADROS GENERALES Y ENTRO CONTENIDOS*/
<?
$N_style['FondotextosBG']=$BG->fields['FondotextosBG'];
$N_style['FondotextosBorder']=$BG->fields['FondotextosBorder'];
$N_style['FondotextosTx']=$BG->fields['FondotextosTx'];
?>
.FondotextosNotas{
	-moz-border-radius: 7px;
	-ms-border-radius: 7px;
	-webkit-border-radius: 7px;
	font-family: "Arial Black", Gadget, sans-serif;
	font-weight: bold;
	height:22px;
	text-decoration: none;
	background-repeat:  repeat-x;
	background-color: <?=$N_style['FondotextosBG']?>;
	border: 1px solid <?=$N_style['FondotextosBorder']?>;
	font-size: 11px;
	color: <?=$N_style['FondotextosTx']?>;
	font-style:italic;
	
}



.Fondotextos{
	-moz-border-radius: 7px;
	-ms-border-radius: 7px;
	-webkit-border-radius: 7px;
	font-family: Tahoma;
	font-weight: bold;
	height:22px;
	text-decoration: none;
	background-repeat:  repeat-x;
	background-color: <?=$N_style['FondotextosBG']?>;
	border: 1px solid <?=$N_style['FondotextosBorder']?>;
	font-size: 10px;
	color: <?=$N_style['FondotextosTx']?>;
	
}
.Fondotextos_2{
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	font-family: Tahoma;
	font-weight: bold;
	height:22px;
	text-decoration: none;
	background-repeat:  repeat-x;
	background-color: #FFC;
	border: 1px solid <?=$N_style['FondotextosBorder']?>;
	font-size: 10px;
	color: <?=$N_style['FondotextosTx']?>;
}
.Fondotextos_3{
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	font-family: Tahoma;
	font-weight: bold;
	height:22px;
	text-decoration: none;
	background-repeat:  repeat-x;
	background-color: #FFC;
	border: 1px solid <?=$N_style['FondotextosBorder']?>;
	font-size: 10px;
	color: <?=$N_style['FondotextosTx']?>;
	background:url(images_design/fondobarraSobre.png);
}



/*************PARA LAS CLASES DE TITULOS EN LA PARTE IZQUIERDA****/
.InvTituloIzqui
	{
	background-image: url(images_design/InvTituloizqui_<?=$COLORSESSIONUSER?>.png);
	background-repeat: no-repeat;
	height: 25px;
	width: 10px;
	background-position: left;
	}
/*************PARA LAS CLASES DE TITULOS EN LA PARTE CENTRO FONDO****/

.InvTitulofondo
	{
	background-image: url(images_design/InvTitulo_<?=$COLORSESSIONUSER?>.png);
	background-repeat:  repeat-x;	
	background-position: left;
	}
/*************PARA LAS CLASES DE TITULOS EN LA PARTE DERECHO FONDO****/
.InvTituloDer
	{
	background-image: url(images_design/InvTituloDer_<?=$COLORSESSIONUSER?>.png);
	background-repeat: no-repeat;
	height: 25px;
	width: 10px;
	background-position: right;
	}
/*************PARA LAS CLASES DE TITULOS EN LA PARTE PARA TEXTO FONDO****/
<?
$N_style['TituloInvTx']=$BG->fields['TituloInvTx'];
?>	
.TituloInv {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	text-transform: capitalize;
	color: <?=$N_style['TituloInvTx']?>;
	text-decoration: none;
}
/****************OPCIONES DE MENU PEQUENHO**********************/
<?
$N_style['FondoSobre_2Bg']=$BG->fields['FondoSobre_2Bg'];
?>
.FondoSobre_2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	border: 1px solid <?=$N_style['FondotextosBorder']?>;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	background-color: <?=$N_style['FondoSobre_2Bg']?>;
	background-image: url(../aastylos/fodo_degrade_cuadro.png);
	background-repeat:  repeat-x;
	
}
<?
$N_style['FondoSobreFechaBG']=$BG->fields['FondoSobreFechaBG'];
?>
.FondoSobreFecha {
	border: 1px solid <?=$N_style['FondotextosBorder']?>;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	background-color: <?=$N_style['FondoSobreFechaBG']?>;
	background-image: url(../aastylos/fodo_degrade_cuadro.png);
	background-repeat:  repeat-x;
	color: #000000;
	text-decoration: none;
}
.N_MenuColor{
	display:none;
	position: absolute;
	width:auto;
	-moz-opacity:.9;
	z-index: 2;

/*	opacity:.10;*/
	/*filter:alpha(opacity=10);*/
	  }
.NtextoOpcColor{
	font-family: Tahoma;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
	padding-left: 5px;
}
.NBorederColorOPC
{
	border: 1px solid <?=$N_style['FondotextosBorder']?>;
	-moz-border-radius: 8px;
	-webkit-border-radius: 8px;
	white-space:30px;
	height:50px;
	width:50px;
	background-image: url(../aastylos/fodo_degrade_cuadro.png);
	background-repeat:  repeat-x;

}
.CuadroSobre
	{
	background-image: url(images_design/fondobarraSobre.png);
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #7893CF;
	border-bottom-color: #7893CF;
	}
	/*<!--PARA TODO SOBREADO-->*/
.CuadroSobreTodo 
	{
	background-image: url(images_design/fondobarraSobre.png);
	border: 1px solid #7893CF;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;

	}
.CuadroSobreDer
	{
	background-image: url(images_design/fondobarraSobre.png);
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #7893CF;
	border-bottom-color: #7893CF;
	border-right-width: 1px;
	border-right-style: solid;
	border-right-color: #7893CF;
	-moz-border-radius-topright:8px; /* -webkit-border-top-right-radius arriba derecha*/
	-moz-border-radius-bottomright:8px; /* -webkit-border-top-right-radius arriba derecha*/

	}
.CuadroSobreIzq
{
	background-image: url(images_design/fondobarraSobre.png);
	border-top-width: 1px;
	border-bottom-width: 1px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #7893CF;
	border-bottom-color: #7893CF;
	border-left-width: 1px;
	border-left-style: solid;
	border-left-color: #7893CF;
	-moz-border-radius-topleft:8px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-bottomleft:8px; /* -webkit-border-top-left-radius arriba izquierda*/

	}

.BorderTemplate_2{
	-moz-border-radius: 12px;
	-webkit-border-radius: 12px;
	/*border: 1px solid #bbd8fb;*/
	padding: 10px;
	background-image: url(images_design/fondocuadro.png);
	
}
.FondoTitutlosINVTOTAL{
	background:url(images_design/fondobarraSobre.png);
	margin-top: 1px;
	margin-bottom: 1px;
	/*height:40px; */
	font-size:11px;
	
	}
.TITULOSPEstTOTAL{
	height:50px; 
	font-family:Tahoma, Geneva, sans-serif; 
	font-size:11px;
	font-weight: bold;	
	color:#666;
	-moz-border-radius-topleft:10px; 
	-moz-border-radius-topright:10px; 
	padding-top:8px;  
	cursor:move;
	}
.TexList {
	cursor:pointer;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
	color: #333;
	text-decoration: none;
	padding-left: 0px;
	font-weight: normal;
}
/*CLASE UTILIZADA EN LA FICHA PRODUCTO*/
.BorderConte{
	-moz-border-radius-bottomright:6px; /* -webkit-border-top-left-radius arriba izquierda*/
	-moz-border-radius-topright:6px; /* -webkit-border-top-right-radius arriba derecha*/
	background-color: #FFF;
	
}

.MSSBorder {	border: 1px solid #8796A8;
	background-image: url(images_design/fondotitulo.png);
	background-repeat: repeat-x;
	height:15px;
}
.TexTitulo {	cursor:pointer;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding-left: 5px;
	padding-top: 1px;
}
.b_calendar{
	font-family: Tahoma;
	font-size: 10px;
	font-weight: normal;
	text-transform: none;
	text-decoration: none;
	background-image: url(images/calendario.png);
	background-repeat: repeat-x;
	border: thin none #E9F2FA;
	background-position: center center;
	height: 16px;
	width: 15px;
}

 </style>
<?
function ColorUSER($FOL)
		{  //global $LANG;
			//->SI TIENE LA SSESSION ACTIVA 
				if(isset($_SESSION['StyleColor']))
				{ 
				return $LANG=$_SESSION["StyleColor"];
				}else
					{//->SI ENTRA POR ACA ES PORQUE NO TIENE NINGUNA SESSION DE IDIOMA Y LE MANDAMOS ESPANHOL
						#session_register('StyleColor');
				 		return $_SESSION["StyleColor"]='azul';
						//return	$LANG='azul';
					}
				
				
		}
function ColorFondoUSER($FOL)
		{  //global $LANG;
			//->SI TIENE LA SSESSION ACTIVA 
				if(isset($_SESSION['StyleColorFondo']))
				{ 
				return $LANG=$_SESSION["StyleColorFondo"];
				}else
					{//->SI ENTRA POR ACA ES PORQUE NO TIENE NINGUNA SESSION DE IDIOMA Y LE MANDAMOS ESPANHOL
						#session_register('StyleColorFondo');
				 		return $_SESSION["StyleColorFondo"]='fondo_1.png';
						//return	$LANG='azul';
					}
				
				
		}
		
	function CambiarSessionColor($TypeCambio)
	{
	$_SESSION["StyleColor"]=$TypeCambio;
	}
	
	function CambiarSessionColorFondo($TypeCambio)
	{
	$_SESSION["StyleColorFondo"]=$TypeCambio;
	}
?>
<script>
////////////creado por ing luis sanchez garcia 
function CambiarColor(celda,cloro){ 
   celda.style.backgroundColor=cloro
}
////////mas oscuros
function CambiarColor_2(celda_2){ 
   celda_2.style.backgroundColor=""
}//onMouseOver="CambiarColor(this,'#FFFFFF')"  onmouseout="CambiarColor_2(this)"
//->FUNCIONES PARA UTILIZAR LAS CAJAS ACTIVAS
//-> DONDE EL DEFINE DENTRO DE LAS CAJAS SON CAJAS
function CajaSobreiNPUT(ID)
{ //alert(' sdfdsfds=='+ID);
document.getElementById(ID).className='cajas_2_Sobre';
}
function CajaSobreiNPUT_2(ID)
{ //alert(' sdfdsfds=='+ID);
document.getElementById(ID).className='cajas';
}



</script>

<!--FUNCION PARA PASAR LA RESOLUCION A PHP-->
<!--FUNCION PARA PASAR LA RESOLUCION A PHP-->
<script language="javascript">
function SetCookie() {
var width = screen.width;
var height = screen.height;
var res = width + 'x' + height;
document.cookie = 'PHPRes='+res;
location = '<?=$GLOBALS['siteurl'];?>';
}

function CheckResolution(width, height) {
if(width != screen.width && height != screen.height) {
SetCookie();
}
}
</script>
<?
if(isset($_COOKIE['PHPRes']) || !empty($_COOKIE['PHPRes'])) {
$res = explode("x",$_COOKIE['PHPRes']);
 $width = $res[0];
 $height = $res[1];
?>
<script language="javascript">
CheckResolution(<?=$width;?>,<?=$height;?>);
</script>
<?
} else {
?>
<script language="javascript">
SetCookie();
</script>
<?
} 
$ReAlto=$height;
$ReAncho=$width;
define('PANTALLAANCHO',$ReAncho);
define('PANTALLAALTO',$ReAlto);
?>

