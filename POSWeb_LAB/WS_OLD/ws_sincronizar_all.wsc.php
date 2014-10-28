<?php									

										set_time_limit(10000);
										define(FOLDER_RAIZ,'');
										define(TABLA_POS_ITEMS_SALES,'pos_sales');
										define(TABLA_POS_ITEMS_SALES_ITEMS,'pos_sales_items');
										define(TABLA_POS_ITEMS_ALL,'pos_items');
										define(TABLA_POS_PACIENTES,'pos_pacientes');
										define(MAX_REGISTRO_PACIENTES_WS,'5000');
	#########################################################################################################################################################
	###ENTRA A LA CONECCION
		$style		='FALSE';
		$url_class 	= FOLDER_RAIZ.'ws_productos.wsc.php';
	  		if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}
	#########################################################################################################################################################

if($_REQUEST['AJAXX']!='TRUE'){

define(URL_RAIZ_FONDO,'');
include(URL_RAIZ_FONDO.'classes/stylos_new.class.php'); 

include(URL_RAIZ_FONDO.'classes/TextDecoracion.php'); 
	$ObjDeco=new TextDecoracion();		

}


switch($_REQUEST['ws_sinronizar_all']){
	
	case 'view_info_paciente':{
		
				//ws_sinronizar_all::sincronizar_maestro_productos();	
				$a_pac_info	=ws_sinronizar_all::sincronizar_paciente($_REQUEST['cc_num']);	
				
				
				//echo '<pre>';print_r($a_pac_info);
				
		}break;
	case 'maestro_pacientes':{
		
				//ws_sinronizar_all::sincronizar_maestro_productos();	
				ws_sinronizar_all::sincronizar_maestro_pacientes();	
		
		}break;
		
	case 'enviar_ventas_all':{
				$time_ini	=ws_sinronizar_all::cronometro_inicial();	
				
								ws_sinronizar_all::enviar_todas_ventas();	
				
				$time_fin	=ws_sinronizar_all::cronometro_final($time_ini);
				
				echo 'SE DEMORO '.substr($time_fin,1);
				
		}break;
	
	case 'sincr_new_items':{
						
							switch($_REQUEST['type']){
								
								case 'max':{
												######################################################################################
												## TRAEMOS EL MAXIMO DE PRODUCTOS QUE EXISTE EN LA BASE DE DATOS
													$item_max	=ws_sinronizar_all::max_producto_parent_id();
													
												######################################################################################
												## ahora enivamos a la funcion para que sincronize
																ws_sinronizar_all::sincronizar_maestro_productos($item_max[0]['max_parent_id'],'parent_max');
													
												######################################################################################
											}break;
								}
						echo 'entro';
						
						
					}break;
					
	case 'sincr_new_pacientes':{
						
							switch($_REQUEST['type']){
								
								case 'max':{
												######################################################################################
												## TRAEMOS EL MAXIMO DE PRODUCTOS QUE EXISTE EN LA BASE DE DATOS
													$paciente_max	=ws_sinronizar_all::max_pacientes_parent_id();
													#echo $paciente_max[0]['max_parent_id'];
													#die;
												######################################################################################
												## ahora enivamos a la funcion para que sincronize
																ws_sinronizar_all::sincronizar_maestro_pacientes($paciente_max[0]['max_parent_id'],'parent_max');
													
												######################################################################################
											}break;
								}
						echo 'entro';
						
						
					}break;
                    
                    
   case 'sincr_un_paciente':{
							
							switch($_REQUEST['type']){
								
								case 'max':{
												######################################################################################
												## TRAEMOS EL MAXIMO DE PRODUCTOS QUE EXISTE EN LA BASE DE DATOS
													//$paciente_max	=ws_sinronizar_all::max_pacientes_parent_id();
													//$paciente_max='31560610';
													
												######################################################################################
												## ahora enivamos a la funcion para que sincronize
                                                                   
															$resp=	ws_sinronizar_all::sincronizar_un_paciente($_REQUEST['value']);
													        
                                                            echo 'SE SINCRONIZO EL PACIENTE CON IDENTIFICACION:'.$resp['0']['identificacion'].'<br>';
                                                            echo 'NOMBRES:'.$resp['0']['primer_nombre'].$resp['0']['segundo_nombre'].$resp['0']['primer_apellido'].$resp['0']['primer_apellido'].'<br>';
                                                            echo 'TELEFONO:'.$resp['0']['telefono'].'<br>'; 
                                                            echo 'NUM CARNET:'.$resp['0']['carnet_number'].'<br>';
                                                            echo 'DIRECCION:'.$resp['0']['direccion'].'<br>';
                                                            //print_r($resp);
												######################################################################################
											}break;
								} 
						echo 'Pulse New Sincronizacion para limpiar el Proceso, y continuar con Otro Paciente';
						
						
					}break;                     
                    
                                        
					
					
	case 'menu':{
						//echo date('Y-m-d H:i:s').'sdsd';
							include ("settings.php");
							include("language/$cfg_language");
							include ("classes/db_functions.php");
							include ("classes/security_functions.php");
						ws_sinronizar_all::incluir_js();
						ws_sinronizar_all::ver_menu_sincronizar();
		
		
				}
	
	}


class ws_sinronizar_all{
	
	
	
	
	public function sincronizar_paciente($value)
	{
		##$segundos_ini	=ws_sinronizar_all::cronometro_inicial();
		$ws_url				=URL_WEB_SERVICE_SERVIDOR;
		
		###################################################################################
		## RECORRO LOS PACIENTES LIMITNADO MAXI
											
		$a_info_pacientes		=ws_productos::maestro_pacientes(
																	$ws_url,
																	$value,
																	$tipo='identificacion',
																	LOCATION_ID
																);
		//echo LOCATION_ID;			
		###################################################################################
		# DECODIFICO LOS PACIENTES
									
		$pacientes_list_info		= json_decode($a_info_pacientes['resultado'],true);
		//echo'<pre>';print_r($pacientes_list_info);
		//echo'<pre>';print_r($pacientes_list_info[0]['tipo_subsidio']);
		
			
		#Omar:>Genero la imagen de Subsidio total o Parcial
		switch($pacientes_list_info[0]['tipo_subsidio']){
				case 1:{
					$imagen='sub_total.png';
					}break;
				case 2:{
					$imagen='sub_parcial.png';
					}break;
				default:{	
					$imagen='sub_sin.png';
				}break;
		}

		?>
        <div align="right" >
        <img src="../images/<?=$imagen?>" width="183" height="27" />
        </div>
		<?
		#..................................................
		
										
		##########################################################################
		## SE APROVECHA Y SE ACTULIZA LOS CAMPOS
		ws_sinronizar_all::insertar_paciente($pacientes_list_info,0);
									
		###################################################################################
							
		return $pacientes_list_info;
	}
	
    
    	
	
    public function sincronizar_un_paciente($value)
	{
		##$segundos_ini	=ws_sinronizar_all::cronometro_inicial();
		$ws_url				=URL_WEB_SERVICE_SERVIDOR;
		
		###################################################################################
		## RECORRO LOS PACIENTES LIMITNADO MAXI
											
		$a_info_pacientes		=ws_productos::maestro_pacientes(
																	$ws_url,
																	$value,
																	$tipo='identificacion',
																	LOCATION_ID
																);
		//echo LOCATION_ID;			
		###################################################################################
		# DECODIFICO LOS PACIENTES
									
		$pacientes_list_info		= json_decode($a_info_pacientes['resultado'],true);
		//echo'<pre>';print_r($pacientes_list_info);
        
       // echo count($pacientes_list_info['0']['0']);
        if(!$pacientes_list_info['0']['0']){
            
            echo 'ESte Paciente no Existe en el ERP';
            die;
        }
        
        
        //die;//echo 'Convenio:'.$resp['0']['convenio'].'<br>'; 
        
        if($pacientes_list_info['0']['convenioid']=='0'){
            
            echo 'No se Puede Sincronizar este Paciente, debido Que no tiene Convenio';
            die;
        }
        
        
		//echo'<pre>';print_r($pacientes_list_info[0]['tipo_subsidio']);
		
			
		#Omar:>Genero la imagen de Subsidio total o Parcial
		switch($pacientes_list_info[0]['tipo_subsidio']){
				case 1:{
					$imagen='sub_total.png';
					}break;
				case 2:{
					$imagen='sub_parcial.png';
					}break;
				default:{	
					$imagen='sub_sin.png';
				}break;
		}

		?>
         
		<?
		#..................................................
		
		
        								
		##########################################################################
		## SE APROVECHA Y SE ACTULIZA LOS CAMPOS
		ws_sinronizar_all::insertar_paciente($pacientes_list_info,0);
									
		###################################################################################
							
		return $pacientes_list_info;
	}
	
	public function sincronizar_maestro_pacientes($value)
	{
		$segundos_ini	=ws_sinronizar_all::cronometro_inicial();
		$ws_url				=URL_WEB_SERVICE_SERVIDOR;
			
			###################################################################################
			## TRAIGO EL MAXIMO DEL PARENT_ID PARA PARTIR DE AHY
		$max_parent				=ws_productos::total_pacientes();
		$total_pacientes_pos	=$max_parent[0]['total_pacientes'];	
			
			###################################################################################
			## CONSULTO VIA WEB SERVICE EL MAXIMO DE REGISTROS A TRAER 
			$a_pacientes			=ws_productos::maestro_total_pacientes($ws_url,$value,'all',LOCATION_ID);

			$pacientes_list		= json_decode($a_pacientes['resultado'],true);
		
		echo '<br>total pacientes= '.count($pacientes_list).'<br>';
		//echo '<pre>';print_r($pacientes_list);
		//exit;
			###################################################################################
			## TRAIGO EL TOTAL DE PACIENTES 
				$total_pacientes_pos	=$total_pacientes_pos;
			###################################################################################
			
			###################################################################################
			## TRAIGO EL TOTAL DE PACIENTES 
				$total_pacientes		=$pacientes_list[0]['total_maestro_pacientes'];
			###################################################################################
			
				
			
			###################################################################################
			## averiguo ahora el max de recorrido que tengo que hacerr
				
				$total_recorrido	=($total_pacientes<MAX_REGISTRO_PACIENTES_WS)?$total_pacientes:$total_pacientes/MAX_REGISTRO_PACIENTES_WS;
				//$total_recorrido	=1;
			
			echo 'total recorrido ='. ceil($total_recorrido).'<br>';
			###################################################################################
			## RECORRO LOS PACIENTES LIMITNADO MAXI
			$recorrido_par	=$total_pacientes_pos; 
			for($h=0;$h<ceil($total_recorrido);++$h){
											
					
					$value				=$recorrido_par.'|'.MAX_REGISTRO_PACIENTES_WS.'|0';
					$a_info_pacientes	=ws_productos::maestro_pacientes($ws_url,$value,$tipo='all',LOCATION_ID);
					
											
									###################################################################################
									## DECODIFICO LOS PACIENTES
									$pacientes_list_info		= json_decode($a_info_pacientes['resultado'],true);
										
												for($p=0;$p<count($pacientes_list_info);++$p){
													
														ws_sinronizar_all::insertar_paciente($pacientes_list_info,$p);
													
													}
									###################################################################################
											
					//echo '<pre>';print_r($a_info_pacientes);
		$segundos_fin	=ws_sinronizar_all::cronometro_final($segundos_ini);
					
					echo '<br>*****'.$recorrido_par.'***********************************'.$segundos_fin.'*****<br>';
					
						##################################
						##ahora le aumento el registro ya procesado
						$recorrido_par+=MAX_REGISTRO_PACIENTES_WS;
				
				}
			
		$segundos_fin	=ws_sinronizar_all::cronometro_final($segundos_ini);
		
		echo '<br>total segundos '.number_format($segundos_fin,2).' segundos<br>';
		echo '<br>total segundos '.number_format($segundos_fin/60,2).' minutos ,,, '.$h;
		
		
		
		
		
		}
		
	public function sincronizar_maestro_productos($value,$tipo)
	{	
	$tiempo = microtime();$tiempo = explode(" ", $tiempo);$tiempo = $tiempo[1] + $tiempo[0];$tiempoInicial = $tiempo;
			$ws_url			=URL_WEB_SERVICE_SERVIDOR;
			$a_productos	=ws_productos::maestro_producto($ws_url,$value,$tipo,LOCATION_ID);

			$item_list		= json_decode($a_productos['resultado'],true);
			
			//echo'<br>********************************************************************************************<br>';	
			//echo'<br>*****************************SINCRONIZANDO PRODUCTOS****************************************<br>';	
			//echo'<br>********************************************************************************************<br>';	
			echo '<h1>SINCRONIZANDO PRODUCTOS</h1>';
			
			echo'<br>**-> '.date('H:i:s').' = Obteniendo Resultados del web service '.URL_WEB_ws.'<br>';	
			echo'<br>**-> '.date('H:i:s').' = Resultados Obtenidos en un total de '.count($item_list).' Registros<br>';	
			$insert=0;	 
			$update=0;	 
			for($i=0;$i<count($item_list);++$i){
				
				##############################################################################################
				##	VERIFICO SI EL PRODUCTO NO EXISTE SI NO ES ASI LO INSERTAMOS
					$return	=ws_sinronizar_all::insertar_producto($item_list,$i);
						
						if($return=='insert'){
							++$insert;
							}else{
								++$update;
								}
				##############################################################################################
				}
			echo'<br>**-> '.date('H:i:s').' = <strong>Total Insertados</strong> en Forma Basica  en '.$insert.' <br>';	
			echo'<br>**-> '.date('H:i:s').' = <strong>Total Actualizados</strong> en Forma Basica  en '.$update.' <br>';	
   	$tiempo 	= microtime();$tiempo = explode(" ", $tiempo);
	$tiempo 	= $tiempo[1] + $tiempo[0];
	$tiempoFinal = $tiempo; // Cálculo de la diferencia de tiempo
  	$tiempoTotal = $tiempoFinal - $tiempoInicial;
			echo'<br>********************************************************************************************<br>';	
			echo'<br>**-> '.date('H:i:s').' = <strong>Actualizado</strong> en Forma Basica  en '.number_format($tiempoTotal,2).' segundos <br>';	
			
			
			#echo'<br>********************************************************************************************<br>';	
			#echo'<br>********************************************************************************************<br>';	
			#echo'<br>********************************************************************************************<br>';	
			#echo'<br>***********SINCRONIZANDO LISTAS DE PRECIOS, IMPUESTOS, INVENTARIOS**************************<br>';	
			#echo'<br>********************************************************************************************<br>';	
			echo '<h1>SINCRONIZANDO LISTAS DE PRECIOS, IMPUESTOS, INVENTARIOS</h1>';
			
			for($i=0;$i<count($item_list);++$i){
			
									ws_productos::sincronizarPreciosProductos(
																				$value			=$item_list[$i]['plu'],
																				$tipo			='plu',
																				$bodega_id		=LOCATION_ID,
																				$proveedor_id	='',
																				$incluir_lib	=''
																				);
			
			
			}
   	$tiempo = microtime();$tiempo = explode(" ", $tiempo);$tiempo = $tiempo[1] + $tiempo[0];$tiempoFinal = $tiempo; // Cálculo de la diferencia de tiempo
  	$tiempoTotal = $tiempoFinal - $tiempoInicial;
			echo'<br><br>**-> '.date('H:i:s').' = <strong>Actualizado</strong> en Forma Basica  en '.number_format($tiempoTotal/60,3).' Minutos <br>';	
			
				
				//echo '<pre>';print_r($item_list);
	}
	
	public function insertar_producto($item_list,$ij)
	{
			
			
			$a_sql['datos']			='	id ';
			$a_sql['tabla']			=TABLA_POS_ITEMS_ALL;
			$a_sql['donde']			=' item_number="'.rtrim(ltrim($item_list[$ij]['plu'])).'"';
			//echo $info_pos_items[0]['pos_item_id'];
			$a_info_item_convenio	=AdminConsulta::ejec_consulta($a_sql,'');
			
			
	if(count($a_info_item_convenio)==0){	
		if($item_list[$ij]['catalogo_descripcion']){
			$a_vec['shortdescription']				=strtoupper(rtrim(ltrim(trim($item_list[$ij]['catalogo_descripcion']))));
			$a_vec['description']					=strtoupper(rtrim(ltrim(trim($item_list[$ij]['catalogo_descripcion']))));
			$a_vec['item_name']						=strtoupper(rtrim(ltrim(trim($item_list[$ij]['catalogo_descripcion']))));
			$a_vec['quantity']						=$item_list[$ij]['inventario'];
			$a_vec['active']						='1';
			$a_vec['category_id']					='1';
			$a_vec['pack']							='0';
			$a_vec['buy_price']						=$item_list[$ij]['ultimo_costo'];
			$a_vec['unit_price']					='00';
			$a_vec['total_cost']					='00';
			$a_vec['item_number']					=$item_list[$ij]['plu'];
			$a_vec['parent_id']						=$item_list[$ij]['item_id'];
			$a_vec['parent_tipo']					=date('Y-m-d H:i:s').'ws desde ='.URL_WEB_SERVICE_SERVIDOR.'';
			$a_vec['ultima_actualizacion_ws']		=date('Y-m-d H:i:s');
			
			AdminConsulta::insertar2($a_vec, $tabla=TABLA_POS_ITEMS_ALL, $ver_query='');//ver_consulta
		}
		return 'insert';	
			}else{
				
					$a_vec['shortdescription']				=strtoupper(rtrim(ltrim(trim($item_list[$ij]['catalogo_descripcion']))));
					$a_vec['description']					=strtoupper(rtrim(ltrim(trim($item_list[$ij]['catalogo_descripcion']))));
					$a_vec['item_name']						=strtoupper(rtrim(ltrim(trim($item_list[$ij]['catalogo_descripcion']))));
					$a_vec['quantity']						=$item_list[$ij]['inventario'];
					$a_vec['buy_price']						=$item_list[$ij]['ultimo_costo'];
					$a_vec['ultima_actualizacion_ws']		=date('Y-m-d H:i:s');
					$donde									='id="'.$a_info_item_convenio[0]['id'].'"';
					AdminConsulta::actualizar2($a_vec, $tabla=TABLA_POS_ITEMS_ALL, $donde,$ver_query='');//ver_consulta
				
		return 'update';	
				
				
				}
			
			
			
		}
	
	public function insertar_paciente($pacientes_list_info,$pj)
	{
			
			
			$a_sql['datos']			='	id ';
			$a_sql['tabla']			=TABLA_POS_PACIENTES;
			$a_sql['donde']			=' account_number="'.rtrim(ltrim(trim($pacientes_list_info[$pj]['identificacion']))).'"';
			//echo $info_pos_items[0]['pos_item_id'];
			$a_info_pacientes	=AdminConsulta::ejec_consulta($a_sql,'');
			
		
			$post['first_name']					=strtoupper(rtrim(ltrim(trim($pacientes_list_info[$pj]['primer_nombre']))));
			$post['first_name2']				=strtoupper(rtrim(ltrim(trim($pacientes_list_info[$pj]['segundo_nombre']))));
			$post['last_name']					=strtoupper(rtrim(ltrim(trim($pacientes_list_info[$pj]['primer_apellido']))));
			$post['last_name2']				=strtoupper(rtrim(ltrim(trim($pacientes_list_info[$pj]['segundo_apellido']))));
			$post['street_address']			=strtoupper(rtrim(ltrim(trim($pacientes_list_info[$pj]['direccion']))));
			$post['phone_number']			=$pacientes_list_info[$pj]['telefono'];
			$post['lastchangedate']			=$pacientes_list_info[$pj]['ultima_actualizacion'];
			$post['convenioid']					=$pacientes_list_info[$pj]['convenioid'];
			$post['carnet_number']			=$pacientes_list_info[$pj]['carnet_number'];
			$post['almacenid']					=$pacientes_list_info[$pj]['locationid'];
		
		
			
	if(count($a_info_pacientes)==0){		
			
		if($pacientes_list_info[$pj]['identificacion']){	
			$post['account_number']			=$pacientes_list_info[$pj]['identificacion'];
			$post['parent_tipo']					=date('Y-m-d H:i:s').'ws desde ='.URL_WEB_SERVICE_SERVIDOR.'';
			$post['parent_id']					=$pacientes_list_info[$pj]['paciente_cod_jvm'];
			
			
			AdminConsulta::insertar2($post, $tabla=TABLA_POS_PACIENTES, $ver_query='');//ver_consulta
		}
		return 'insert';	
			}else{
				
			
					$donde					='id="'.$a_info_pacientes[0]['id'].'"';
					AdminConsulta::actualizar2($post, $tabla=TABLA_POS_PACIENTES, $donde,$ver_query='');//ver_consulta
				
		return 'update';	
				
				
				}
			
			
			
		}
	
	
	public function cronometro_inicial()
	{
		
		$tiempo 				= microtime();$tiempo = explode(" ", $tiempo);
		$tiempo 				= $tiempo[1] + $tiempo[0];
		return $tiempoInicial_func 	= $tiempo;
		
		}	
	
	public function cronometro_final($tiempoInicial_func)
	{
			$tiempo 	= microtime();$tiempo = explode(" ", $tiempo);
			$tiempo 	= $tiempo[1] + $tiempo[0];
			$tiempoFinal = $tiempo; // Cálculo de la diferencia de tiempo
			return $tiempoTotal = $tiempoFinal - $tiempoInicial_func;
		
		}	
	
	public function enviar_ticket_venta($sale_id,$cedula,$formula_numero,$vec_cab,$vec_detalle)
	{
			if($vec_cab && $vec_detalle){
		

			#####################################################################################################################
			## REPORTAMOS LAS VENTAS AL ERP VIA WEB SERVICE
			$a_resp= ws_productos::sincronizar_enviar_venta(
															$ws_url			=URL_WEB_SERVICE_SERVIDOR,
															$sale_id,
															$cedula,
															$formula_numero,
															$vec_cab,
															$vec_detalle,
															$bodega_id		=LOCATION_ID,
															$incluir_lib	='TRUE'
													);

			
				
			#####################################################################################################################
			## AHORA REPORTAMOS QCON EL ID DE LA VENTA DE POS SALES
			if($a_resp['pos_sales_id_erp']>0){
				
				
					$post['status_envio']		=$a_resp['pos_sales_id_erp'];
					$donde							='id="'.$sale_id.'"';
					AdminConsulta::actualizar2($post, $tabla=TABLA_POS_ITEMS_SALES, $donde,$ver_query='');//ver_consulta
				
				}	
				
			}
				
			
	}

	public function enviar_todas_ventas()
	{
						$sql['datos']	='*';		
						$sql['tabla']	=TABLA_POS_ITEMS_SALES;		
						$sql['donde']	=' bodega_id="'.LOCATION_ID.'" AND status="1" ';		
						$info_pos_sales	=AdminConsulta::ejec_consulta($sql,$ver_consulta='');
					
					for($i=0;$i<count($info_pos_sales);++$i){
							unset($campos1);
										
										$campos1['id_vta']		 		= $info_pos_sales[$i]['id'];
										$campos1['date']	 			= $info_pos_sales[$i]['date'];
										$campos1['sale_total_cost'] 	= $info_pos_sales[$i]['sale_total_cost'];
										$campos1['sale_sub_total']	 	= $info_pos_sales[$i]['sale_sub_total'];
										$campos1['paid_with']	 		= $info_pos_sales[$i]['paid_with'];
										$campos1['sold_by']				= $info_pos_sales[$i]['sold_by'];
										$campos1['items_purchased'] 	= $info_pos_sales[$i]['items_purchased'];
										$campos1['comment'] 			= $info_pos_sales[$i]['comment'];
										$campos1['changee'] 			= $info_pos_sales[$i]['changee'];
										$campos1['invoicenumber']	 	= $info_pos_sales[$i]['invoicenumber'];
										$campos1['status']	 			= $info_pos_sales[$i]['status'];
										$campos1['descuentporc']		= $info_pos_sales[$i]['descuentporc'];
										$campos1['value_discount']	 	= $info_pos_sales[$i]['value_discount'];
										$campos1['tipo_vta']	 		= $info_pos_sales[$i]['tipo_vta'];
										$campos1['bodega_id']	 		= $info_pos_sales[$i]['bodega_id'];
										
							
							
												$sql['datos']	='*';		
												$sql['tabla']	=TABLA_POS_ITEMS_SALES_ITEMS;		
												$sql['donde']	=' sale_id="'.$info_pos_sales[$i]['id'].'" ';		
												$row_detail		=AdminConsulta::ejec_consulta($sql,$ver_consulta='');
							
									unset($campos2);
									for($k=0;$k<count($row_detail);++$k){
									unset($a_info_item);	
													$a_info_item					=ws_sinronizar_all::item_plu(rtrim(ltrim($row_detail[$k]['item_id'])),'id');
													#########################################################################################################################
													## ACA CREO UN VECTOR PARA ENVIAR VIA WEB SERVICE HABLANDO DEL DETALLE
													$campos2[$k]['value_dcto']	 					= $row_detail[$k]['value_dcto'];
													$campos2[$k]['item_id']							= $row_detail[$k]['item_id'];
													$campos2[$k]['quantity_purchased'] 				= $row_detail[$k]['quantity_purchased'];
													$campos2[$k]['item_unit_price']					= $row_detail[$k]['item_unit_price'];
													$campos2[$k]['item_buy_price']					= $row_detail[$k]['item_buy_price'];
													$campos2[$k]['item_tax_percent']				= $row_detail[$k]['item_tax_percent'];
													$campos2[$k]['item_total_tax']					= $row_detail[$k]['item_total_tax'];
													$campos2[$k]['item_total_cost']					= $row_detail[$k]['item_total_cost'];
													$campos2[$k]['unit_sale']						= $row_detail[$k]['unit_sale'];
													$campos2[$k]['sale_frac']						= $row_detail[$k]['sale_frac'];
													$campos2[$k]['tomadosis']						= $row_detail[$k]['tomadosis'];
													$campos2[$k]['presenttoma']						= $row_detail[$k]['presenttoma'];
													$campos2[$k]['frecuenciadosis']					= $row_detail[$k]['frecuenciadosis'];
													$campos2[$k]['tiempofcia']						= $row_detail[$k]['tiempofcia'];
													$campos2[$k]['duraciondosis']					= $row_detail[$k]['duraciondosis'];
													$campos2[$k]['tiempoduracion']					= $row_detail[$k]['tiempoduracion'];
													$campos2[$k]['qtyrecetada']						= $row_detail[$k]['qtyrecetada'];
													$campos2[$k]['tipo']							= $row_detail[$k]['tipo'];
													$campos2[$k]['porcen_dcto']						= $row_detail[$k]['porcen_dcto'];
													$campos2[$k]['plu_item']						= $a_info_item[0]['plu'];
													#########################################################################################################################
										
										}
									
	#########################################################################################################################
	## ENVIO LA INFORMACION NECESARIA PARA EL WEB SERVICE
														########################################################
														## para saber el id del paciente
														$a_info_paciente	=ws_sinronizar_all::info_paciente($info_pos_sales[$i]['customer_id'],$tipo);
					$campos1= json_encode($campos1);
					$campos2= json_encode($campos2);
					//echo 	'&nbsp;&nbsp;&nbsp;'.$campos1.'<br>';								
					//echo 	$campos2.'<br>';								
			ws_sinronizar_all::enviar_ticket_venta(
													$sale_id		=$info_pos_sales[$i]['id'],
													$cedula			=$a_info_paciente[0]['identificacion'],
													$formula_numero	=$info_pos_sales[$i]['formula'],
													$campos1,
													$campos2
													);
	#########################################################################################################################
						}
	}

	public function info_paciente($val,$tipo)
	{ 			
			
			$a_sql['datos']			='	id 	as paciente_id,
										account_number	as identificacion ';
			$a_sql['tabla']			=TABLA_POS_PACIENTES;
			$a_sql['donde']			=' id="'.$val.'"';
			//echo $info_pos_items[0]['pos_item_id'];
			return					AdminConsulta::ejec_consulta($a_sql,'');
	}
	public function item_plu($value,$tipo)
	{
		
						$sql['datos']	='	id			as pos_item_id,
											item_number	as plu';		
						$sql['tabla']	=TABLA_POS_ITEMS_ALL;		
						$sql['donde']	='id="'.$value.'" ';		
		
						return			AdminConsulta::ejec_consulta($sql,$ver_consulta='');
		
		
 		}
	
	
	
	public function ver_menu_sincronizar()
	{
		?>
 <p>
    <img border="0" src="images/menubar/sincro.png" width="55" height="55" valign="top"><font color="#005B7F" size="4">&nbsp;<b>Sincronizar</b></font></p>
    <p><font face="Verdana" size="2">Sincronize los modulos a su eleccion</font></p>
    
    <table  border="0" cellspacing="0" cellpadding="0" style="font:Verdana, Geneva, sans-serif; size:2;">
          <tr > 
            <td width="300" class="popScripts EfectoZoom popScriptLink">
            <a href="javascript:;" onclick="js_sincronizar('sincr_new_items', 'insert','max');">SINCRONIZAR NUEVOS PRODUCTOS</a></td>
            <td width="500" bgcolor="#CCCCCC" id="sincr_new_items_div">&nbsp;</td>
            <td class="popScripts_pe EfectoZoom popScriptLink" ><div onclick="document.getElementById('sincr_new_items_div').innerHTML=''">cerrar</div></td>
          </tr>
          <tr>
            <td width="300" class="popScripts EfectoZoom popScriptLink">
            <a href="javascript:;" onclick="js_sincronizar('sincr_new_pacientes', 'insert','max');">SINCRONIZAR NUEVOS PACIENTES</a></td>
            <td width="500" bgcolor="#CCCCCC" id="sincr_new_pacientes_div">&nbsp;</td>
            <td class="popScripts_pe EfectoZoom popScriptLink"><div onclick="document.getElementById('sincr_new_pacientes_div').innerHTML=''">cerrar</div></td>
          </tr>
          
          <tr>
            <td width="300" class="popScripts EfectoZoom popScriptLink">
            <a href="javascript:;" onclick="js_sincronizar('sincr_un_paciente',jQuery('#identificacion').val(), 'max');">SINCRONIZAR UN PACIENTE</a></td>
            <td width="500" bgcolor="#CCCCCC" id="sincr_un_paciente_div">Cedula:<input name="identificacion" id="identificacion" onkeypress="return isNumberKey(event)" /></td>
            <td class="popScripts_pe EfectoZoom popScriptLink">  <div  onClick="window.open('ws_sincronizar_all.wsc.php?ws_sinronizar_all=menu','MainFrame')">New Sincronizacion</div></td>
          </tr>  
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>

		
		
		<?php
		}		


	public function incluir_js()
	{
	?>
    <script src="jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="jquery_ui/js/jquery-ui-1.8.7.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script>
	function js_sincronizar(mod, value,type)
	{
		
		
	jQuery('#'+mod+'_div').html('Jvm Cargando....  Puede tardar unos minutos');	
    $.ajax({
					url: "ws_sincronizar_all.wsc.php",
					type: 'POST',
					cache: false,
					dataType: 'html',
					error:function(objeto, quepaso, otroobj){
									alert('Error de Conexión, Favor Vuelva a Intentar');
					},
					data: {
						ws_sinronizar_all:mod,
						value: value,
						type:type
					},
                    success: function(data) {
						
						jQuery('#'+mod+'_div').html(data);
						//alert(data);
						}
				});
		}
    </script>
    
    <SCRIPT language=Javascript>
       
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
 
         return true;
      }
       
   </SCRIPT>
    
	<?php	
		
		}
	public function max_producto_parent_id()
	{
						$sql['datos']	='	MAX(parent_id) as max_parent_id';		
						$sql['tabla']	=TABLA_POS_ITEMS_ALL;		
						$sql['donde']	='id>0 ';		
		
						return			AdminConsulta::ejec_consulta($sql,$ver_consulta='');
		
		}
	public function max_pacientes_parent_id()
	{
						$sql['datos']	='	MAX(parent_id) as max_parent_id';		
						$sql['tabla']	=TABLA_POS_PACIENTES;		
						$sql['donde']	='id>0 ';		
		
						return			AdminConsulta::ejec_consulta($sql,$ver_consulta='');
		
		}

}





?>
