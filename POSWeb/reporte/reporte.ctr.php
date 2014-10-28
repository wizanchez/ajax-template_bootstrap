<?PHp


					#----------------------------------------------------------------------------------------
					#	librerias framework
							Fjvm_cargar::fjvm_importar_libreria([
																	'jquery'
																]);
					#----------------------------------------------------------------------------------------


class reporte_ctr{


public function ini_panel_reporte_ctr()
	{


			reporte_view::ini_panel_reporte_view();

	}


public function ini_reporte_venta_horaria_ctr()
	{
		global $a_request;

						#----------------------------------------------------------------------------------------
						#	FUNCION PARA OBTENER LAS VENTAS DEL DIA
							$a_fechas	=reporte::get_obtener_venta_dia($a_request['date']);
							$a_color 	=reporte::get_color();
						#----------------------------------------------------------------------------------------

#echo '<pre>';
#print_r($a_fechas);
			reporte_view::ini_reporte_venta_horaria_view($a_fechas,$a_color);

	}


}