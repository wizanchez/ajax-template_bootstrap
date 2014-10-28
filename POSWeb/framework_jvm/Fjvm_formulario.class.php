<?php
class Fjvm_formulario
{
	
	public function tabla_tr_2($a_general,$a_td)
	{
	?><tr class="TexList"><?php 
    	 for($i=0;$i<count($a_td);++$i){
		?><td><?php 
					
					switch($a_td[$i]['tipo']){
						
						case'titulo'	:{
												Fjvm_formulario::print_titulo($a_td,$i);
										}break;
						
						case'texto'	:{
												Fjvm_formulario::print_texto($a_td,$i);
										}break;
						
						}
		
		?></td><?php
		 }
	?></tr><?php	
		
		
		}
	
	private function print_titulo($a_td,$key)
	{
		TextDecoracion::CuadroTitulos_3($a_td[$key]['texto'],'','','',$a_td[$key]['alinear']);
		
	}

	private function print_texto($a_td,$key)
	{
		switch($a_td[$key]['alinear']){
			case 'derecha'		:{
									$a_td[$key]['alinear']='right';
									}break;
			default				:{
									$a_td[$key]['alinear']='center';
									}break;
			}
		
		?><div align="<?php echo $a_td[$key]['alinear'];?>"><?php echo $a_td[$key]['texto'];?></div><?php
	}


	public function html_menu($a_general)
	{
	?><div class="TexList AC_BOTON_2"><?php
        ?><table  border="0" cellspacing="0" cellpadding="0"><?php
        ?><tr><?php 
		
		for($i=0;$i<count($a_general);++$i){
		
		if($a_general[$i]['val']!='NO'){
			?><td <?=AC_BOTON_2?> id="<?php echo $a_general[$i]['id'];?>"><?php
        		?><span onclick="<?php echo $a_general[$i]['onclick'];?>"><?php
              	$img_url	=(!$a_general[$i]['img'])?'images_design/MoveFolder.png':$a_general[$i]['img'];  
               ?><img height="15" src="<?php echo $img_url;?>"><?php
                	echo $a_general[$i]['titulo'];
				?></span><?php
               
			   if($a_general[$i]['div_val']=='SI'){
				   
              	$a_general[$i]['div_detail']	=(!$a_general[$i]['div_detail'])?'-1':$a_general[$i]['div_detail'];  
				   
			   ?><div id="<?php echo $a_general[$i]['id'].'_cab';?>" class="N_MenuColor BorderTemplate_2"  style="z-index:1; " >
               		<div style=" overflow:auto; height:<?php echo $a_general[$i]['div_alto'];?>; width:<?php echo $a_general[$i]['div_ancho'];?>;" id="<?php echo $a_general[$i]['id'].'_detail';?>" ><?php echo $a_general[$i]['div_detail'];?></div>
                 </div><?Php }
            ?></td><?php
    		?><td>&nbsp;</td><?php
            } 
		}/*if($a_general[$i]['val']!='NO')*/
          ?></tr></table></div><?php
	
		
		
		}

	public function html_ordenar_tabla_js()
	{ 
		/* Description: metodo en JS para ordenar los datos de una tabla
		* @param n/a
		* @return n/a
		* @Creado 28 Sep 2010
		* @autor luis Sanchez
		*/
	?><link rel="stylesheet" href="<?=FOLDER_RAIZ?>css/ordenar/jq.css" type="text/css" media="print, projection, screen" /><link rel="stylesheet" href="<?=FOLDER_RAIZ?>css/ordenar/blue/style.css" type="text/css" id="" media="print, projection, screen" /><script type="text/javascript" src="<?=FOLDER_RAIZ?>js/jquery/ordenar/js/jquery.tablesorter.js"></script><?PHP }
	
	public function html_ordenar_tabla_cabecera($menu, $div = '', $ancho = '') 
	{
		/* Description: metodo para colocar los títulos en una tabla en la sección de cabecera
		* @param: 1. El array con los titulos de la tabla. 2. El nombre (id) de la tabla. 3. El ancho de la tabla (en %). Si es vacio, se asume 100%
		* @return n/a
		* @Creado 28 Sep 2010
		* @autor luis Sanchez
		*/
		/*si no definimos el ancho le colocamos 100%*/
			/*si no definimos el ancho le colocamos 100%*/
			$ancho 		= ($ancho) ? $ancho : '100%'; 
			
			?><table id="<?PHP echo $div; ?>" class="tablesorter" border="0" align="center" cellpadding="0" cellspacing="1" width="<?PHP echo $ancho; ?>"><thead><tr><?PHP 		
				for ($i =0; $i < count($menu); ++$i) { 
						
						$ancho2		=($menu[$i]['ancho'])?'width:'.$menu[$i]['ancho'].';':'';
					
					?><th style="cursor:pointer; <?php echo $ancho2;?>" title="<?php echo $menu[$i]['title'];?>" id="<?php echo $menu[$i]['id'];?>" ><?PHP
							 echo $menu[$i]['nombre']; 
                    ?></th><?PHP 		
			
			} ?></tr></thead><?PHP 	
		}
	
	public function html_ordenar_tabla_fin($div = '') 
	{ 
		/* Description: Invocación del método tablesorter para ordenar los datos de una tabla.
		* @param $div, id para la tabla
		* @return n/a
		* @Creado 28 Sep 2010
		* @autor luis Sanchez
		*/
	?></table><script type="text/javascript">$(function(){$("#<?PHP echo $div; ?>").tablesorter({widgets:['zebra']});});</script><?PHP /*.tablesorter({sortList:[[0,0],[0,0]],widgets:['zebra']});})*/	}
	
	public function tooltips_main()
	{
	?><link rel="stylesheet" href="<?php echo FOLDER_RAIZ;?>js/jquery/tooltips/css/tipsy.css" type="text/css" /><link rel="stylesheet" href="<?php echo FOLDER_RAIZ;?>js/jquery/tooltips/css/tipsy-docs.css" type="text/css" /><script type="text/javascript" src="<?php echo FOLDER_RAIZ;?>js/jquery/tooltips/js/jquery.tipsy.js"></script><?php	
	
	}
	public function tooltips($div, $posicion)
	 {
	/** 
	* @Clase para hacer tooltip
	* @versión: 0.0     
	* @Creado: 24 de Enero 2006
	* @modificado:24 de Enero 2006
	* @autor:wizanchez
	* este archivo funcion con 
						<link rel="stylesheet" href="../js/jquery/tooltips/css/tipsy.css" type="text/css" /> 
						<link rel="stylesheet" href="../js/jquery/tooltips/css/tipsy-docs.css" type="text/css" /> 
						<script type="text/javascript" src="../js/jquery/tooltips/js/jquery.tipsy.js"></script> 	
		
	**/
		switch ($posicion) {
			case 'abajo':
				{
					$pos = '\'n\'';
				}
				break;
			case 'izquierdo':
				{
					$pos = '\'e\'';
				}
				break;
			case 'derecho':
				{
					$pos = '\'w\'';
				}
				break;
			case 'arriba':
				{
					$pos = '\'s\'';
				}
				break;
			case 'arriba_derecho':
				{
					$pos = '\'sw\'';
				}
				break;
			case 'abajo_derecho':
				{
					$pos = '\'nw\'';
				}
				break;
			case 'arriba_izquierdo':
				{
					$pos = '\'se\'';
				}
				break;
			case 'auto_norte_sur':
				{
					$pos = '$.fn.tipsy.autoNS';
				}
				break;
			case 'auto_derecho_izquierdo':
				{
					$pos = '$.fn.tipsy.autoWE';
				}
				break;

		} ?><script>$(function(){$('#<?PHP echo $div; ?>').tipsy({gravity: <?PHP echo $pos; ?>,html:true});});</script><?PHP }
			
	public function calendario_js()
	{
	/* Description: metodo para insertar los js de n calendario
	* @param: n/a
	* @return:n/a
	* @Creado 04 Oct 2010
	* @autor luis Sanchez
	*/
?><link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css?random=20051112" media="screen"><!--CALENDARIO--></LINK><SCRIPT type="text/javascript" src="js/dhtmlgoodies_calendar.js?random=20060118"><!--CALENDARIO--></script><?PHP	
	}
	
	public function calendario_caja($NOMBRE,$fecha_aciva='',$onchange='',$horas='')
	{
	
	/* Description: metodo para insertar los una caja con funcion calendario para eso se necesita incluir promero calendario_js()
	* @param: $NOMBRE, nombre que toma el input
	* @param: $fecha_aciva, fecha que va a tomar por defaul
	* @param: $onchange, si va a tener alguna fecha onchange
	* @param: $horas, si va a tener horas es false o true
	* @return:n/a
	* @Creado 04 Oct 2010
	* @Actualizado 15 Oct 2010
	* @autor luis Sanchez
	* @Cambios: Tamaño de 10 a la caja del calendario (15 Oct 2010), Ln 251
	*/
	//echo "entra...:$NOMBRE,$fecha_aciva,$onchange,$horas";
	?>
	<input style="text-align:center" size = "10" type="text" name="<?PHP echo $NOMBRE;?>" onClick=displayCalendar(document.getElementById("<?PHP echo $NOMBRE;?>"),"yyyy-mm-dd",this) id="<?PHP echo $NOMBRE;?>" class="cajas" readonly value="<?PHP echo $fecha_aciva;?>" onChange="<?PHP echo $onchange;?>"><input type="button" value="." onClick=displayCalendar(document.getElementById("<?PHP echo $NOMBRE;?>"),"yyyy-mm-dd",this) class="b_calendar" style="cursor:pointer; margin-left:2px; margin-right:2px;">
	<?PHP	
	}
	public function html_caja($NOMBRE,$ANCHO='',$aling='',$validacion='',$contenido='',$desabilitado='',$onchan='',$onclick='')
	{
	/* Description: metodo para insertar un caja tipo input.
	* @param: $NOMBRE,nombre del selec
	* @param: $ANCHO,ancho de la caja de texto
	* @param: $aling, aliniacion del texto dado en deracho, inzierdo,centro
	* @param: $NUMERICO,viente si el tipo de validacion
	* @param: $desabilitado,le colocamos al campo un realonly
	* @param: $contenido,si viene lleno el campo
	* @param: $onchan,si tiene un evento onchange
	* @param: $onclick,evento onclick
	* @return:n/a
	* @Creado 01 Oct 2010
	* @autor luis Sanchez
	* coment: tiene que estar el js {js/ajax.js} incluido
	*/
	//##############################################################
	//valido la aliniacion del texto
		switch($aling){
			case 'derecho'		:{$aling='right';}break;
			case 'izquierdo'	:{$aling='left';}break;
			case 'centro'		:{$aling='center';}break;
			default				:{$aling='left';}break;
			}
	//##############################################################
	//ahora ahora validaciones si la tiene
	if($validacion){
		switch($validacion){
			case 'numerico'		:{$valindat='validarentero(this);';}break;
			case 'decimal'		:{$valindat='validarfloat(this);';}break;
			//case 'centro'		:{$aling='center';}break;
			//default				:{$aling='left';}break;
			}
		
		
		}
	//##############################################################
	//si biene desabilidato
		if($desabilitado=='true'){
			$readonly	='readonly="readonly"';
			$fond_color	='#ccc';
		}else{
			$readonly	='';
			$fond_color	='';
			}
			
			
	?><input size="<?PHP echo $ANCHO;?>" class="cajas" <?PHP echo $readonly;?> onchange="<?PHP echo $onchan;?>"  id="<?PHP echo $NOMBRE;?>" nombre="<?PHP echo $NOMBRE;?>" style="text-align:<?PHP echo $aling;?>; background-color:<?PHP echo $fond_color;?>;" onblur="CajaSobreiNPUT_2(this.id);" onfocus="CajaSobreiNPUT(this.id);" onkeyup="<?PHP echo $valindat;?>" value="<?PHP echo $contenido;?>" onclick="SelectTextCampo(this.id);<?Php echo $onclick;?>" /><?PHP
    
	}
	public function html_ocultar_columnas_js(){
		
	?><script type="text/javascript" src="js/jquery/columnas/jquery.cookie.js"></script><script type="text/javascript" src="js/jquery/columnas/jquery.columnmanager.js"></script><?php	
		}	
	
	 		
}
?>