<?PHp

class reporte_view
{

public function ini_panel_reporte_view()
	{

		global $lang;
						#----------------------------------------------------------------------------------------
						#	FUNCIONES GENERALES
							Fjvm_cargar::incluir_archivo('classes/stylos_new.class.php');		
							Fjvm_cargar::bundler_ext([
														
														'bootstrap'
														,'jquery'
													]);

						#----------------------------------------------------------------------------------------

			reporte_view::print_cab_index();


			$a_link_1 	=[
							'link'			=>[
													$b=0=>[
															'link'		=>'?jvm=reporte/ini_reporte_venta_horaria.jvm'
															,'nombre'	=>'Venta X Hora'
														],
													++$b=>[
															'link'		=>'reports/form.php?report='.$lang->allItemsReport
															,'nombre'	=>$lang->allItemsReport
														],
													++$b=>[
															'link'		=>'reports/form.php?report='.$lang->allEmployeesReport
															,'nombre'	=>$lang->allEmployeesReport
														],
													++$b=>[
															'link'		=>'reports/reporte_vta_x_cate_dia.controlador.php'
															,'nombre'	=>'Reporte Venta Categoria Dia'
														],
												
												]
							,'boton_type'	=>'warning'
						];
			$a_link_2 	=[
							'link'			=>[
													$b=0=>[
															'link'		=>'reports/form.php?report='.$lang->customerReport
															,'nombre'	=>$lang->customerReport
														],
													++$b=>[
															'link'		=>'reports/form.php?report='.$lang->itemDispReport
															,'nombre'	=>$lang->itemReport
														],
													++$b=>[
															'link'		=>'reports/form.php?report='.$lang->employeeReport
															,'nombre'	=>$lang->employeeReport
														],
												
												]
							,'boton_type'	=>'danger'
						];


			$a_link_3 	=[
							'link'			=>[
													$b=0=>[
															'link'		=>'daily.php'
															,'nombre'	=>$lang->dailyReport
														],
													++$b=>[
															'link'		=>'daily_operador.php'
															,'nombre'	=>'REPORTE DIARIO DE VENTAS POR OPERADOR'
														],
													++$b=>[
															'link'		=>'productos_hora.php'
															,'nombre'	=>'REPORTE PRODUCTOS POR HORA'
														],
													++$b=>[
															'link'		=>'form.php?report='.$lang->dateRangeReport
															,'nombre'	=>$lang->dateRangeReport
														],
													++$b=>[
															'link'		=>'form.php?report='.$lang->profitReport
															,'nombre'	=>$lang->profitReport
														],

													++$b=>[
															'link'		=>'endday.php'
															,'nombre'	=>$lang->closedailyreport
														],


													++$b=>[
															'link'		=>'vta_consolidadas.php'
															,'nombre'	=>$lang->vtas_consolid
														],
													++$b=>[
															'link'		=>'Disp_consolidadas.php'
															,'nombre'	=>$lang->Disp_consolid
														],
												
												]
							,'boton_type'	=>'success'
						];



		?>

	<div class="row">
		<div class="col-xs-0 col-sm-0 col-md-1"></div>
		<div class="col-xs-10 col-sm-5 col-md-3"><?PHp reporte_view::bt_general($a_link_1);?></div>
		<div class="col-xs-10 col-sm-5 col-md-3"><?PHp reporte_view::bt_general($a_link_2);?></div>
		<div class="col-xs-10 col-sm-5 col-md-3"><?PHp reporte_view::bt_general($a_link_3);?></div>
		<div class="col-xs-0 col-sm-0 col-md-1"></div>
	</div>



		<?PHP

	}
/*
#################################################################################################
##########################################################---------------------------------########
########################################################-----------------------------------########
#####################################################--------------------------------------########
#################################################------------------------------------------########
##############################################---------------------------------------------########
###########################################------------------------------------------------########
#######################################----------------------------------------------------########
###################################--------------------------------------------------------########
######################################-----------------------------------------------------########
###########################################------------------------------------------------########
##############################################---------------------------------------------########
#################################################------------------------------------------########
####################################################---------------------------------------########
###################################################################################################
*/  
public function bt_general($vector)
	{

		$a_total_link 	=count($vector['link']);

		?><div class="btn-group-vertical" style="width:100%; ">

		<?PHp for ($i=0; $i < $a_total_link; $i++) { ?>
<a href="<?PHp echo $vector['link'][$i]['link'];?>" class="btn btn-<?PHp echo $vector['boton_type']?> btn-large"><i class="icon-white icon-th"></i> <?PHp echo $vector['link'][$i]['nombre'];?></a>
		<?PHp }?>
</div><br><br><br>
		<?PHp
	}
/*
#################################################################################################
##########################################################---------------------------------########
########################################################-----------------------------------########
#####################################################--------------------------------------########
#################################################------------------------------------------########
##############################################---------------------------------------------########
###########################################------------------------------------------------########
#######################################----------------------------------------------------########
###################################--------------------------------------------------------########
######################################-----------------------------------------------------########
###########################################------------------------------------------------########
##############################################---------------------------------------------########
#################################################------------------------------------------########
####################################################---------------------------------------########
###################################################################################################
*/  
public function ini_reporte_venta_horaria_view($a_fechas,$a_color)
	{
#echo '<pre>';
#print_r($a_fechas);
						#----------------------------------------------------------------------------------------
						#	FUNCIONES GENERALES
							Fjvm_cargar::incluir_archivo('classes/stylos_new.class.php');
							reporte_js::ini_reporte_venta_horaria_js($a_fechas[0]['fecha_hoy']);
							Fjvm_cargar::bundler_ext([
														
														'bootstrap'
														,'jquery'
													]);

						#----------------------------------------------------------------------------------------



				#----------------------------------------------------------------------------------------
				#	IMPRIMO LA TABLA POR HORA SEGUN CATEGORIA
							reporte_view::view_tabla_reporte_hora($a_fechas);
				#----------------------------------------------------------------------------------------

				#----------------------------------------------------------------------------------------
				#	AHRORA IMPRIMO LA GRAFICA
							reporte_view::view_grafico_reporte($a_fechas,$a_color);
				#----------------------------------------------------------------------------------------


		?><script>
			
			setTimeout('js_recargar();',20000);

			function js_recargar()
			{

					location.href='?jvm=reporte/ini_reporte_venta_horaria.jvm&date=<?PHp echo $a_fechas[0]['fecha_hoy'];?>';

			}
		</script><?PHp

}


/*
#################################################################################################
##########################################################---------------------------------########
########################################################-----------------------------------########
#####################################################--------------------------------------########
#################################################------------------------------------------########
##############################################---------------------------------------------########
###########################################------------------------------------------------########
#######################################----------------------------------------------------########
###################################--------------------------------------------------------########
######################################-----------------------------------------------------########
###########################################------------------------------------------------########
##############################################---------------------------------------------########
#################################################------------------------------------------########
####################################################---------------------------------------########
###################################################################################################
*/  
/**
 * tabla para ver la venta por hora
 * @param  array $a_fechas esta todos o valores que se necesitan
 * @return [type]           [description]
 */
public function view_tabla_reporte_hora($a_fechas)
	{
				$text_und =reporte_view::text_und();
				#----------------------------------------------------------------------------------------
				#	OBTENGO EL TOTAL DE LAS CATEGORIAS
							$a_total_categoria 	=count($a_fechas[0]['venta_category']);
							$a_total_hora 		=count($a_fechas);
				#----------------------------------------------------------------------------------------
?>
<img border="0" src="images/menubar/reports.png" width="55" height="55" valign='top'>
    <font color='#005B7F' size='4'>&nbsp;<b>Venta Horaria</b></font><br>
      <br>
      <p>
          		Fecha:<?PHp Fjvm_jquery::calendario([
          												'nombre'	=>'c_fecha'
          												,'value'	=>$a_fechas[0]['fecha_hoy']
          												,'onchange'	=>'js_cambiar_fecha()'

          											]);?>
          </p>

          <p> <font face="Verdana" size="2"> Este Informe Podra Ver el Comportamiento de la venta hora a hora de un dia en especifico</font></p>
          
			<table class="table table-hover">
			<tbody>
			<tr>
			  <!-- Aplicadas en las filas -->
			  <th  class="active">Hora Inicial<br>Hora Final</th>
			 <?PHp for ($j=0; $j < $a_total_categoria; $j++) { 
			 	$v_nombre_categoria 	=$a_fechas[0]['venta_category'][$j]['nombre_categoria'];
			 ?><th  class="active" style="text-align:center"><?PHp echo $v_nombre_categoria;?></th><?PHp
			 }?>
			 <th style="text-align:center;background-color:#CCC">TOTAL</th>
			</tr>
			</tbody>		  
			  <?PHp for ($i=0; $i < $a_total_hora; $i++) {

			  		$v_nombre_fecha 	=$a_fechas[$i]['nombre'];

			  	?> 	  	
			  <tr>
			    <th class="active" style="text-align:center"><?PHp echo $v_nombre_fecha;?></th>
			<?PHp 

				$sum_gran_total=0;
				$sum_gran_total_cant=0;
			
			for ($j=0; $j < $a_total_categoria; $j++) { 

							  			$class 				=$j==0?'danger':($j==1?'success':($j==2?'warning':($j==3?'danger':($j==4?'active':'success') )));

							  $sum_gran_total 				+=$valor_gran_total 			=$a_fechas[$i]['venta_category'][$j][0]['gran_total'];
							  $valor_gran_total_format 		=$valor_gran_total>0?'$ '.number_format($valor_gran_total):'--';
							  $sum_vect[$j]					+=$valor_gran_total;
							  $sum_gran_total_cant 			+=$valor_gran_total_cant 		=$a_fechas[$i]['venta_category'][$j][0]['cantidad_total'];
							  $valor_gran_total_cant_format =$valor_gran_total_cant>0?number_format($valor_gran_total_cant).$text_und:'--';
							  $sum_vect_cant[$j]			+=$valor_gran_total_cant;

				?>

			    <td class="<?PHp echo $class;?>" style="text-align:right"><?PHp echo $valor_gran_total_format;?><br><?PHp echo $valor_gran_total_cant_format?></td>
			   <?PHp }?>
			   <th  style="text-align:right;background-color:#CCC"><?PHp echo '$ '.number_format($sum_gran_total )?><br><?PHp echo number_format($sum_gran_total_cant).$text_und?> </th>
			  </tr>
			  <?PHp }?>
			 <tr>
			 	<td style="text-align:right;background-color:#CCC">TOTAL</td>
			 <?PHp for ($j=0; $j < $a_total_categoria; $j++) { 
			 	
			 	$total_dias 		+=$sum_gran_total_col 		=$sum_vect[$j];
			 	$total_dias_cant 	+=$sum_gran_total_col_cant 	=$sum_vect_cant[$j];

			 ?><th  style="text-align:right;background-color:#CCC"><?PHp echo '$ '.number_format($sum_gran_total_col ).'<br>'.$sum_gran_total_col_cant.$text_und?></th><?PHp
			 }?>
			 <th style="text-align:right;background-color:#CCC"><?PHp echo '$ '.number_format($total_dias).'<br>'.$total_dias_cant.$text_und?></th>
			 </tr>
			</table>

<?PHp
	}
/*
#################################################################################################
##########################################################---------------------------------########
########################################################-----------------------------------########
#####################################################--------------------------------------########
#################################################------------------------------------------########
##############################################---------------------------------------------########
###########################################------------------------------------------------########
#######################################----------------------------------------------------########
###################################--------------------------------------------------------########
######################################-----------------------------------------------------########
###########################################------------------------------------------------########
##############################################---------------------------------------------########
#################################################------------------------------------------########
####################################################---------------------------------------########
###################################################################################################
*/  
public function text_und()
{

	return '<span style="font-size:9px;"> Und</span>';
}

/*
#################################################################################################
##########################################################---------------------------------########
########################################################-----------------------------------########
#####################################################--------------------------------------########
#################################################------------------------------------------########
##############################################---------------------------------------------########
###########################################------------------------------------------------########
#######################################----------------------------------------------------########
###################################--------------------------------------------------------########
######################################-----------------------------------------------------########
###########################################------------------------------------------------########
##############################################---------------------------------------------########
#################################################------------------------------------------########
####################################################---------------------------------------########
###################################################################################################
*/  
public function view_grafico_reporte($a_fechas,$a_color)
{

							$a_total_categoria 	=count($a_fechas[0]['venta_category']);
							$a_total_hora 		=count($a_fechas);

?>
<script type="text/javascript" src="js/graph/amcharts/amcharts.js"></script>
<script type="text/javascript" src="js/graph/amcharts/serial.js"></script>
<script type="text/javascript" src="js/graph/amcharts/none.js"></script>
<script>
	
	var chartData = generateChartData();

var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "none",
    "pathToImages": "http://www.amcharts.com/lib/3/images/",
    "legend": {
        "useGraphSettings": true
    },
    "dataProvider": chartData,
    "valueAxes": [{
        "id":"v1",
        "axisColor": "#FF6600",
        "axisThickness": 2,
        "gridAlpha": 0,
        "axisAlpha": 1,
        "position": "left"
    }, {
        "id":"v2",
        "axisColor": "#FCD202",
        "axisThickness": 2,
        "gridAlpha": 0,
        "axisAlpha": 1,
        "position": "right"
    }, {
        "id":"v3",
        "axisColor": "#B0DE09",
        "axisThickness": 2,
        "gridAlpha": 0,
        "offset": 50,
        "axisAlpha": 1,
        "position": "left"
    }],
    "graphs": [


    				<?PHp for ($i=0; $i < $a_total_categoria; $i++) { 
    						
			 					$v_id_categoria 		=$a_fechas[0]['venta_category'][$i]['id_categoria'];
			 					$v_nombre_categoria 	=$a_fechas[0]['venta_category'][$i]['nombre_categoria'];

    						echo $i>0?',':'';
    							?>{
								        "valueAxis": "v<?PHp echo $i;?>",
								        "lineColor": "<?Php echo $a_color[$i]?>",
								        "bullet": "round",
								        "bulletBorderThickness": 1,
								        "hideBulletsCount": 30,
								        "title": "<?PHp echo $v_nombre_categoria;?>",
								        "valueField": "visits_<?PHp echo $i;?>",
										"fillAlphas": 0
								    }<?PHp 


    				}?>
								   /* {
								        "valueAxis": "v1",
								        "lineColor": "#FF6600",
								        "bullet": "round",
								        "bulletBorderThickness": 1,
								        "hideBulletsCount": 30,
								        "title": "red line",
								        "valueField": "visits",
										"fillAlphas": 0
								    }, {
								        "valueAxis": "v2",
								        "lineColor": "#FCD202",
								        "bullet": "square",
								        "bulletBorderThickness": 1,
								        "hideBulletsCount": 30,
								        "title": "yellow line",
								        "valueField": "hits",
										"fillAlphas": 0
								    }, {
								        "valueAxis": "v3",
								        "lineColor": "#B0DE09",
								        "bullet": "triangleUp",
								        "bulletBorderThickness": 1,
								        "hideBulletsCount": 30,
								        "title": "green line",
								        "valueField": "views",
										"fillAlphas": 0
								    }*/


    ],
    "chartScrollbar": {},
    "chartCursor": {
        "cursorPosition": "mouse"
    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": false,
        "axisColor": "#DADADA",
        "minorGridEnabled": true
    }
});

chart.addListener("dataUpdated", zoomChart);
zoomChart();


// generate some random data, quite different range
function generateChartData() {

    var chartData = [];
    var firstDate = new Date();
    firstDate.setDate(firstDate.getDate() - 100);

<?PHp for ($i=0; $i < $a_total_hora; $i++) {

			  		$v_nombre_fecha 	=$a_fechas[$i]['fech_ini'];
			  		$v_venta_category 	=$a_fechas[$i]['venta_category'][0][0]['gran_total'];
			  		$v_venta_category	=$v_venta_category>0?$v_venta_category:0;

	?>

   // for (var i = 0; i < 100; i++) {
        // we create date objects here. In your data, you can have date strings
        // and then set format of your dates using chart.dataDateFormat property,
        // however when possible, use date objects, as this will speed up chart rendering.
        //var newDate = new Date(firstDate);
        //newDate.setDate(newDate.getDate() + i);
        //newDate.setDate(newDate.getDate() + <?PHp echo $i?>);

       // var visits 	= Math.round(Math.random() * 40) + 100;
        var visits 	=<?PHp echo $v_venta_category;?>;
        var hits 	= Math.round(Math.random() * 80) + 500;
        var views 	= Math.round(Math.random() * 6000);

        chartData.push({
			            date 	: '<?PHp echo $v_nombre_fecha;?>',

			            <?PHp for($j=0; $j < $a_total_categoria; $j++) { 
    						
			 					$v_id_categoria 	=$a_fechas[$i]['venta_category'][$j]['id_categoria'];
			 					$v_gran_total 		=$a_fechas[$i]['venta_category'][$j][0]['gran_total']>0?$a_fechas[$i]['venta_category'][$j][0]['gran_total']:0;

			 						echo 'visits_'.$j.':'.$v_gran_total.' ';

    						echo (($a_total_categoria-1))==$j ?'':',';
    							}
    							?>

			           /* visits 	: visits,
			            hits 	: hits,
			            views 	: views*/
        });

   <?PHp }?>
    //po}// for()



    return chartData;
}

function zoomChart(){
    chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
}

</script>
<style type="text/css" media="screen">
	#chartdiv {
	width	: 100%;
	height	: 500px;
}		
</style>
<div id="chartdiv"></div>	

<?PHp


}
/*
#################################################################################################
##########################################################---------------------------------########
########################################################-----------------------------------########
#####################################################--------------------------------------########
#################################################------------------------------------------########
##############################################---------------------------------------------########
###########################################------------------------------------------------########
#######################################----------------------------------------------------########
###################################--------------------------------------------------------########
######################################-----------------------------------------------------########
###########################################------------------------------------------------########
##############################################---------------------------------------------########
#################################################------------------------------------------########
####################################################---------------------------------------########
###################################################################################################
*/  
public function print_cab_index()
	{
		global $lang;

		?>
<img border="0" src="images/menubar/reports.png" width="55" height="55" valign='top'>
    <font color='#005B7F' size='4'>&nbsp;<b><?=$lang->reports?></b></font><br>
      <br>
      <font face="Verdana" size="2"><?=$lang->reportsWelcomeMessage?></font>
<hr>
		<?PHp
	}
}








