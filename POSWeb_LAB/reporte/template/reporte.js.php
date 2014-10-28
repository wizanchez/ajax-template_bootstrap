<?PHp

class reporte_js
{

public function ini_reporte_venta_horaria_js($fecha_hoy)
	{



		?><script>
	
		var fecha_hoy 	='<?PHp echo $fecha_hoy;?>';

		function js_cambiar_fecha()
		{

			var fech 	=jQuery('#c_fecha').val();

			var cong 	=confirm('Seguro desea Cambiar la fecha del Informe?');

			if(cong){

				location.href="?jvm=<?PHp echo $_REQUEST['jvm'];?>&date="+fech;
			}

				jQuery('#c_fecha').val(fecha_hoy);

		}

		</script><?PHp
	}




}