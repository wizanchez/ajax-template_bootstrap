<?PHp

class sincronizar_js
{

public function ini_panel_sincronizar_js()
	{



		?><script>
	
		var fecha_hoy 	='<?PHp echo $fecha_hoy;?>';

	function js_sincronizar(mod, value,type,class_css,div_id)
	{

		
		var explo 	=mod.split('/');

		var total	=explo.length;


		var url  	=total==1?'ws_sincronizar_all.wsc.php':'?jvm='+mod+'.jvm';
		//var data  	=total==1?'':'?jvm='+mod+'.jvm';

				jQuery('#'+div_id+'_div').removeClass('alert alert-success');
				jQuery('#'+div_id+'_div').removeClass('alert alert-info');
				jQuery('#'+div_id+'_div').addClass(class_css);

				jQuery('#'+div_id+'_div').html('Jvm Cargando....  Puede tardar unos minutos');	
			    jQuery.ajax({
								url: url,
								type: 'POST',
								cache: false,
								dataType: 'html',
								error:function(objeto, quepaso, otroobj){
												alert('Error de Conexión, Favor Vuelva a Intentar');
								},
								data: {
									ws_sinronizar_all 	:mod,
									value 				: value,
									type 				:type,
									AJAXX 				:'TRUE'
								},
			                    success: function(data) {
									
									jQuery('#'+div_id+'_div').html(data);
									//alert(data);
									}
							});
		}		

		</script><?PHp
	}




}