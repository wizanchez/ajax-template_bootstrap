<?
session_start();
incluirArchivos();
$controlador=$_REQUEST['controlador'];
switch($controlador){
	case'generar':
		$fechaInicial=$_REQUEST['datepickerInicial'];
		$fechaFinal=$_REQUEST['datepickerFinal'];
		$lang= new language();
		$dbf=new db_functions("localhost",'root','80071432',"jvmcompa_posweb_1",'pos',$cfg_theme,$lang);
		$datos=$dbf->ventasCategoriaFecha($fechaInicial,$fechaFinal);
		$vista = new reporte_vta_x_cate_diaVista();
		$vista->formularioFinal($datos);
	break;
	default:
		$vista = new reporte_vta_x_cate_diaVista();
		$vista->formularioInicial();
	break;
}
function incluirArchivos(){
	include ("../settings.php");
	include ("../language/$cfg_language");
	include ("../classes/security_functions.php");
	include ("../classes/display.php");
	include ("../classes/db_functions.php");
	include('reporte_vta_x_cate_dia.vista.php');
	?>
	<link rel="stylesheet" href="../js/jquery/modal/jquery-ui.css">
    <script src="../jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="../jquery_ui/js/jquery-ui-1.8.7.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <link rel="stylesheet" rev="stylesheet" href="../jquery_ui/css/ui-lightness/jquery-ui-1.8.7.custom.css" media="all" />
	<?
}
?>