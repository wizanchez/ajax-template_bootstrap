<?PHp
										define(TABLA_POS_ITEMS,'pos_items');
										define(TABLA_POS_ITEMS_SALES,'pos_sales');
										define(TABLA_POS_ITEMS_SALES_ITEMS,'pos_sales_items');


class reporte
{


public function get_obtener_venta_dia($a_fecha_hoy)
	{


					#----------------------------------------------------------------------------------------
					#	VERIFICO SI VIENE CON FECHA
						$a_fecha_hoy 	=$a_fecha_hoy?$a_fecha_hoy:date('Y-m-d');
					#----------------------------------------------------------------------------------------
				#----------------------------------------------------------------------------------------
				#	OBTENGO LAS CATEGORIAS
						$a_categoria 	=reporte::get_categoria($val='',$type='');
						$total_categoria=count($a_categoria);
				#----------------------------------------------------------------------------------------
					#----------------------------------------------------------------------------------------
					#	OBTENER FUNCION DE LAS HORAS
						$a_fecha 		=reporte::get_horas_dia();
						$total_fechas	=count($a_fecha);
					#----------------------------------------------------------------------------------------

				for ($i=0; $i < $total_fechas; ++$i) { 
					

							$v_hora_ini		=$a_fecha_hoy.' '.$a_fecha[$i]['fech_ini'];	
							$v_hora_fin		=$a_fecha_hoy.' '.$a_fecha[$i]['fech_fin'];	


								for ($j=0; $j < $total_categoria; $j++) { 
									
									$cat_id 		=$a_categoria[$j]['category_id'];
									$cat_nombre 	=$a_categoria[$j]['nombre'];

													#----------------------------------------------------------------------------------------
													#	OBTENGO LAVENTA POR CATEGORIA
												$a_fecha[$i]['venta_category'][$j] 	=reporte::get_venta([
																													'fecha_ini'			=>$v_hora_ini
																													,'fecha_fin'		=>$v_hora_fin
																													,'categoria_id'		=>$cat_id
																												]
																												,'venta_x_categoria_x_hora'
																											);
												$a_fecha[$i]['venta_category'][$j]['nombre_categoria']	=$cat_nombre;
												$a_fecha[$i]['venta_category'][$j]['id_categoria']		=$cat_id;
													#----------------------------------------------------------------------------------------

								}





				}

				$a_fecha[0]['fecha_hoy']	=$a_fecha_hoy;

		return $a_fecha;
	}


public function get_horas_dia()
	{


		return [
					$b=0=>[
								'id'		=>1
								,'nombre'	=>'07:00:00 a 07:59:59'
								,'fech_ini'	=>'07:00:00'
								,'fech_fin'	=>'07:59:59'

						],
					++$b=>[
								'id'		=>2
								,'nombre'	=>'08:00:00 a 08:59:59'
								,'fech_ini'	=>'08:00:00'
								,'fech_fin'	=>'08:59:59'

						],
					++$b=>[
								'id'		=>3
								,'nombre'	=>'09:00:00 a 09:59:59'
								,'fech_ini'	=>'09:00:00'
								,'fech_fin'	=>'09:59:59'

						],
					++$b=>[
								'id'		=>4
								,'nombre'	=>'10:00:00 a 10:59:59'
								,'fech_ini'	=>'10:00:00'
								,'fech_fin'	=>'10:59:59'

						],
					++$b=>[
								'id'		=>5
								,'nombre'	=>'11:00:00 a 11:59:59'
								,'fech_ini'	=>'11:00:00'
								,'fech_fin'	=>'11:59:59'

						],
					++$b=>[
								'id'		=>6
								,'nombre'	=>'12:00:00 a 12:59:59'
								,'fech_ini'	=>'12:00:00'
								,'fech_fin'	=>'12:59:59'

						],
					++$b=>[
								'id'		=>8
								,'nombre'	=>'13:00:00 a 13:59:59'
								,'fech_ini'	=>'13:00:00'
								,'fech_fin'	=>'13:59:59'

						],
					++$b=>[
								'id'		=>9
								,'nombre'	=>'14:00:00 a 14:59:59'
								,'fech_ini'	=>'14:00:00'
								,'fech_fin'	=>'14:59:59'

						],
					++$b=>[
								'id'		=>10
								,'nombre'	=>'15:00:00 a 15:59:59'
								,'fech_ini'	=>'15:00:00'
								,'fech_fin'	=>'15:59:59'

						],
					++$b=>[
								'id'		=>11
								,'nombre'	=>'16:00:00 a 16:59:59'
								,'fech_ini'	=>'16:00:00'
								,'fech_fin'	=>'16:59:59'

						],
					++$b=>[
								'id'		=>12
								,'nombre'	=>'17:00:00 a 17:59:59'
								,'fech_ini'	=>'17:00:00'
								,'fech_fin'	=>'17:59:59'

						],
					++$b=>[
								'id'		=>13
								,'nombre'	=>'18:00:00 a 18:59:59'
								,'fech_ini'	=>'18:00:00'
								,'fech_fin'	=>'18:59:59'

						],
					++$b=>[
								'id'		=>14
								,'nombre'	=>'19:00:00 a 19:59:59'
								,'fech_ini'	=>'19:00:00'
								,'fech_fin'	=>'19:59:59'

						],
					++$b=>[
								'id'		=>15
								,'nombre'	=>'20:00:00 a 20:59:59'
								,'fech_ini'	=>'20:00:00'
								,'fech_fin'	=>'20:59:59'

						],
					++$b=>[
								'id'		=>16
								,'nombre'	=>'21:00:00 a 21:59:59'
								,'fech_ini'	=>'21:00:00'
								,'fech_fin'	=>'21:59:59'

						],
				];

	}

public function get_categoria($val,$type)
	{


							$sql['datos']	='
												id 			AS category_id
												,category 	AS nombre
												,catnumber
											';		
							$sql['tabla']	='
												pos_categories
											';		
							$sql['donde']	=' 
												id>0
												'.$VALING.'
											';			
							return  Fjvm_consulta::query_consulta($sql,$ver_consulta='');


	}


public function get_venta($val,$type)
	{

		switch ($type) {
			case 'venta_x_categoria_x_hora':
				
									$VALING 	='	AND cab_det.entrydate BETWEEN "'.$val['fecha_ini'].'" AND "'.$val['fecha_fin'].'"
													AND it.category_id="'.$val['categoria_id'].'"
										';
				break;
			
			default:
				# code...
				break;
		}

							$sql['datos']	='
												 SUM(cab_det.quantity_purchased) AS cantidad_total 
												,SUM(cab_det.item_unit_price*cab_det.quantity_purchased) AS gran_total 
											';		
							$sql['tabla']	=TABLA_POS_ITEMS_SALES.' 		AS cab JOIN 
											'.TABLA_POS_ITEMS_SALES_ITEMS.' AS cab_det 
												ON cab.id=cab_det.sale_id 	JOIN 
											'.TABLA_POS_ITEMS.'				AS it 
												ON it.id=cab_det.item_id  
											';		
							$sql['donde']	=' cab.bodega_id="'.LOCATION_ID.'" 
												AND cab.status="1" 
												
												'.$VALING.'

											';			
							return	Fjvm_consulta::query_consulta($sql,$ver_consulta='');




	}


public function get_color()
	{


		return ['#000000','red','#CCFF33','#002EB8','#E6FF66','#29DBFF','#FF33FF','#001A33'];
	}

}#class reporte























