<?php
class Fjvm_jquery
{
	
	public function js_modal_main()
	{
	?><link type='text/css' href='js/jquery/modal/css/demo.css' rel='stylesheet' media='screen' /><link type='text/css' href='js/jquery/modal/css/basic.css' rel='stylesheet' media='screen' /><script type='text/javascript' src='js/jquery/modal/js/jquery.simplemodal.js'></script><?php	
	
	}
	public function js_modal_table_ini($nom_class,$ancho='')
	{	
		$ancho	=(!$ancho)?'300px':$ancho;
		?><script>
    	$('.<?php echo $nom_class;?>').click(function (e) {
				$('#<?php echo $nom_class;?>_contenido').modal();
				return false;
		});
    </script><div id="<?php echo $nom_class;?>_contenido" style="width:<?php echo $ancho;?>;display:none; "><?php	
	
	}
	public function js_modal_table_fin()
	{
		?></div><?php
		}


	public function calendario($a_vect)
	{

			$v_nombre 				=$a_vect['nombre'];
			$v_value 				=$a_vect['value'];
			$v_onchange 			=$a_vect['onchange']?' onchange="'.$a_vect['onchange'].'" ':'';

		?><input <?PHp echo $v_onchange;?>type="date" style="text-align:center" id="<?PHp echo $v_nombre;?>"  name="<?PHp echo $v_nombre;?>" value="<?PHp echo $v_value;?>"><script>jQuery.datepicker.setDefaults({ dateFormat: "yy-mm-dd"});
		jQuery( "#<?PHp echo $v_nombre;?>" ).datepicker();</script><?PHp

	}
 		
}
?>