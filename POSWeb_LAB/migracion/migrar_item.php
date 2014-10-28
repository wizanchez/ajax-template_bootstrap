<?php session_start();
			define(FOLDER_RAIZ,'../');
			
																		
																		
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
											#	SINCRONIZAR_WEBSERVICE
						 						define(DF_SINCRONIZAR_WEB_SERVICE, false);	
														
											#----------------------------------------------------------------------------------------							
											#	VALIDACION DE LAS COLUMNAS
						 						define(DF_COL_FRACCION,'none' );	
						 						define(DF_COL_UNIDAD_VENTA, 'none');	
														
											#----------------------------------------------------------------------------------------							
						


echo 'INIZIALIZANDO....<BR>';

define(URL_RAIZ_FONDO,'../');


include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");


$dbf = new db_functions(
							$cfg_server
							,$cfg_username
							,$cfg_password
							,$cfg_database
							,$cfg_tableprefix
							,$cfg_theme
							,$lang
						);





				#----------------------------------------------------------------------------------------
				#	RECORRO LOS PRODUCTOS
					$customer_result = mysql_query("
													SELECT 
															*
													FROM 
															migracion_item
														

													"
													,$dbf->conn
													);

				#----------------------------------------------------------------------------------------								

echo 'TOTAL :'.mysql_num_rows($customer_result).'<BR>';

		while ($row = mysql_fetch_assoc($customer_result)) {

					$v_plu 						=$row['field1'];
					$v_descripcion 				=$row['field2'];
					$v_pvp 						=$row['field13'];


					$SQL_INSER				="INSERT INTO pos_items(
																				item_number
																				,item_name
																				,description 
																				,shortdescription
																				,category_id
																				,buy_price
																				,unit_price
																				,parent_tipo
																				,lastchangedate
																				,ultima_actualizacion_ws
																				,active

																		)VALUES(

																				'".$v_plu."'
																				,'".$v_descripcion."'
																				,'".$v_descripcion."'
																				,'".$v_descripcion."'
																				,'1'
																				,'".$v_pvp."'
																				,'".$v_pvp."'
																				,'".date('Y-m-d H:i:s')."'
																				,'".date('Y-m-d H:i:s')."'
																				,'".date('Y-m-d H:i:s')."'
																				,1

																		)
													";

					$customer_result3 = mysql_query($SQL_INSER,$dbf->conn) or die('ERROR SQL ['.$SQL_INSER.'] <br>'.mysql_errno($dbf->conn) . ": " . mysql_error($dbf->conn));


		}
echo 'exitoso';














