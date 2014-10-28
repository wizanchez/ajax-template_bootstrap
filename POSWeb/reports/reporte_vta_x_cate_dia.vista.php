<?
class reporte_vta_x_cate_diaVista{
	public function formularioInicial(){
        $anoIni=date('Y');
        $mesIni=date('m');
        $fechaIni=$anoIni.'-'.$mesIni.'-01';
		?>
		<script>
		$(function() {
			$.datepicker.setDefaults({ dateFormat: "yy-mm-dd"});
			$( "#datepickerInicial" ).datepicker();
			$( "#datepickerFinal" ).datepicker();
		});
		</script>
		<form action="reporte_vta_x_cate_dia.controlador.php">
		<input type="hidden" value="generar" id="controlador" name="controlador">
		<br>
		<table align="center" id="myTable" class="ui-widget">
			<tr class="ui-widget-header">
				<td align="center">Fecha Inicial:</td>
				<td align="center"><input type="text" id="datepickerInicial" name="datepickerInicial" value="<? echo $fechaIni; ?>"></td>
			</tr>
            <tr class="ui-widget-header">
				<td align="center">Fecha Final:</td>
				<td align="center"><input type="text" id="datepickerFinal" name="datepickerFinal" value="<? echo date('Y-m-d');?>"></td>
			</tr>
			<tr>
				<td align="center"  colspan="2"><br></td>
			</tr>
			<tr>
				<td align="center"  colspan="2"><input type="submit" value="Generar" /></td>
			</tr>
			<tr>
				<td align="center"  colspan="2"><br></td>
			</tr>
		</table>
		</form>
		<?
	}
	public function formularioFinal($datos){
		$cantidad=count($datos);
		?>
		<table align="center" style="font-size:15px">
        	<tr align="center"  class="ui-widget-header">
            	<td align="center" colspan="2">Fecha</td>
                <td align="center" colspan="2">Baguette</td>
                <td align="center" colspan="2">BLANDITO</td>
                <td align="center" colspan="2">HOJALDRE</td>
                <td align="center" colspan="2">BOLLERIA</td>
                <td align="center" colspan="2">TIPICOS</td>
                <td align="center" colspan="2">SANDWICH</td>
                <td align="center" colspan="2">PIZZA</td>
                <td align="center" colspan="2">PASTELERIA</td>
                <td align="center" colspan="2">BEBIDAS</td>
                <td align="center" colspan="2">TOTAL DIA</td>
            </tr>
            <tr align="center"  class="ui-widget-header">
            	<td align="center">Fecha</td>
                <td align="center">Dia</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
		<td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
                <td align="center">Cant</td>
                <td align="center">Venta</td>
            </tr>
		<?
		for($i=0;$i<$cantidad;++$i){
			$subtotalCantidad=$datos[$i]['cantidad1']+$datos[$i]['cantidad2']+$datos[$i]['cantidad3']+$datos[$i]['cantidad4']+$datos[$i]['cantidad5']+$datos[$i]['cantidad6']+$datos[$i]['cantidad7']+$datos[$i]['cantidad8']+$datos[$i]['cantidad9'];
			$subtotalVenta=$datos[$i]['venta1']+$datos[$i]['venta2']+$datos[$i]['venta3']+$datos[$i]['venta4']+$datos[$i]['venta5']+$datos[$i]['venta6']+$datos[$i]['venta7']+$datos[$i]['venta8']+$datos[$i]['venta9'];
			?>
			<tr align="right">
            	<td>
                    <a href="../?jvm=reporte/ini_reporte_venta_horaria.jvm&date=<? echo $datos[$i]['fecha']; ?>"><? echo $datos[$i]['fecha']; ?></a>
                </td>
                <td align="center"><? echo $datos[$i]['dia']; ?></td>
                <td><? echo number_format($datos[$i]['cantidad1'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta1'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad2'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta2'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad3'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta3'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad4'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta4'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad5'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta5'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad6'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta6'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad7'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta7'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad8'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta8'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['cantidad9'],0,'.','.'); ?></td>
                <td><? echo number_format($datos[$i]['venta9'],0,'.','.'); ?></td>
                <td><? echo number_format($subtotalCantidad,0,'.','.'); ?></td>
                <td><? echo number_format($subtotalVenta,0,'.','.'); ?></td>
            </tr>
			<?
			$totalCantidad1+=$datos[$i]['cantidad1'];
			$totalCantidad2+=$datos[$i]['cantidad2'];
			$totalCantidad3+=$datos[$i]['cantidad3'];
			$totalCantidad4+=$datos[$i]['cantidad4'];
			$totalCantidad5+=$datos[$i]['cantidad5'];
			$totalCantidad6+=$datos[$i]['cantidad6'];
			$totalCantidad7+=$datos[$i]['cantidad7'];
			$totalCantidad8+=$datos[$i]['cantidad8'];
			$totalCantidad9+=$datos[$i]['cantidad9'];
			$totalCantidad+=$subtotalCantidad;
			
			$totalVenta1+=$datos[$i]['venta1'];
			$totalVenta2+=$datos[$i]['venta2'];
			$totalVenta3+=$datos[$i]['venta3'];
			$totalVenta4+=$datos[$i]['venta4'];
			$totalVenta5+=$datos[$i]['venta5'];
			$totalVenta6+=$datos[$i]['venta6'];
			$totalVenta7+=$datos[$i]['venta7'];
			$totalVenta8+=$datos[$i]['venta8'];
			$totalVenta9+=$datos[$i]['venta9'];
			$totalVenta+=$subtotalVenta;
		}
		?>
			<tr  align="right"  class="ui-widget-header">
            	<td colspan="2"  align="center">Totales</td>
                <td><? echo number_format($totalCantidad1,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta1,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad2,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta2,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad3,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta3,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad4,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta4,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad5,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta5,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad6,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta6,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad7,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta7,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad8,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta8,0,'.','.'); ?></td>
                <td><? echo number_format($totalCantidad9,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta9,0,'.','.'); ?></td>

                <td><? echo number_format($totalCantidad,0,'.','.'); ?></td>
                <td><? echo number_format($totalVenta,0,'.','.'); ?></td>
            </tr>
        </table>
		<?
	}
}
?>