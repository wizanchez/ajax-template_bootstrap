<?php session_start(); 


include ("../classes/Decoracion.php");
include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");
include ("../Connections/conexion.php");

$Tex=new Decoracion();


$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
?>
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" src="../js/generales.js"></script>
<script src="../js/mootools.js"></script>
<script src="../js/timespinner.js"></script>

<link href="../css/pos.css" rel="stylesheet" type="text/css" />

<!--CALENDARIO-->
<link type="text/css" rel="stylesheet" href="../css/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../js/dhtmlgoodies_calendar.js?random=20060118"></script>

<script>
function Sucursal(sucur)
{
//->ESTA FUNCION ME HACE LA RECARGA DESDE EL SELECT DE sucursal Y LO ENVIA POR AJAX PARA VALIDR SI HAY TERMINALES Y USUARIOS
ajaxpage_2('asignaciondecaja.php?actionID=VIEWSUCURSAL&BogID='+document.getElementById("sucursal").value,'terminalDiv','CargaSucur');

//->ESTA FUNCION ME HACE LA RECARGA DESDE EL SELECT DE USUARIOS Y LO ENVIA POR AJAX PARA VALIDR SI HAY TERMINALES Y USUARIOS
ajaxpage_2('asignaciondecaja.php?actionID=VIEWCAJERO&BogID='+document.getElementById("sucursal").value,'CajeroDiv','CargaSucur');

}

function Asignar()
{
var Total=document.getElementById("BOTONDIV");

//*/->VALIDAMOS QUE LLEVE VALOR EL CAMPO DE BASE
if(document.getElementById('TERMINAL').value =='-1')
		{
			alert('ESCOGA UNA TERMINAL');
			return false;
		}
		if(document.getElementById('CAJEROS').value =='-1')
			{
				alert('ESCOGA UN CAJERO');
				return false;
			}

if(document.getElementById('base').value <1)
		{
				alert('POR FAVOR DIGITE LA BASE');
				return false;
		}
if(document.getElementById('hora').value >=document.getElementById('hora_2').value)
		{
				alert('LA HORA DE INICIO NO PUEDE SER MAYOR O IGUAL  A LA HORA FINAL');
				return false;
		}
		else
			{
							var answer = confirm("SEGURO DESEA ASIGNAR ?")
					//->ES PORQUE VAN A ASIGNAR Y LOS VALORERES SON VERDADEROS
								if (answer){
								//alert('SE GUARDO EXITOSAMENTE');
	ajaxpage_2('asignaciondecaja.php?actionID=ASIGNAR&BogID='+document.getElementById("sucursal").value+'&TermId='+document.getElementById("TERMINAL").value+'&CAJEROS='+document.getElementById("CAJEROS").value+'&base='+document.getElementById("base").value+'&hora='+document.getElementById("hora").value+'&hora_2='+document.getElementById("hora_2").value+'&fecha='+document.getElementById("fecha").value,'asignarDIV','asignarDIV');
	
							//->AHORA ELIMINO EL BOTON PARA QUE NO VUELVAN A GUARDAR
								Total.innerHTML = '';
							
								}							
							return false;
		}
}
function MasUser()
{
//->COLOCO EL BOTON DE NUEVO
var Total=document.getElementById("BOTONDIV");
Total.innerHTML = '<input type="submit" class="botonGeneral" name="button" id="button" value="Asignar" onclick="return Asignar();" />';

var Totalg=document.getElementById("asignarDIV");
Totalg.innerHTML = '';


}
</script>
<boby>
<? if(!$actionID)
{
?>
<!--INIZIALIZO LAS ETIKETAS DEL FORMULARIO 
name=NOMBRE DEL FORMULARIO A ENVIAR
method=NOMBRE DEL METODO A ENVIAR SI ES POR GET , POST-->
<?=$userid?>
 <form name="forms">    
     <div align="center"><?=$Tex->BarraTitulo('','ASIGNACION DE CAJA','f_contratoDdIV','center')?>
   </div>
  <table width="400" border="0" align="center"  cellpadding="0" cellspacing="0">
     <tr>
      <td ><div  id="asignarDIV"></div></td>
      </tr>
    <tr>
      <td width="500"><? //$query="bhjj";
	  $var=mysql_query('SELECT * FROM pos_inventorylocation',$dbf->conn);
		//->es el wihle que RECORRE LA CONSULTA DE LA TABLA pos_inventorylocation PERO REGISTRO POR REGISTRO
				while($row=mysql_fetch_assoc($var))
					{
							  $var_2=mysql_query('SELECT * FROM pos_company WHERE id="'.$row['companyid'].'"',$dbf->conn);
								$row_2=mysql_fetch_assoc($var_2);
					   $sucur.=' <option value="'.$row['id'].'">'.$row_2['companyname'].'</option>';
					}
	  $SUCURLL='<span id="CargaSucur"></span><select name="sucursal" id="sucursal" onchange="Sucursal();" class="cajas">
        <option value="-1" selected="selected">Escoge..</option>
		'.$sucur.'
		</select>';
	  
	  $Tex->BarraTitulo('Sucursal',$SUCURLL,'hhh') ?></td>
    </tr>
    <tr>
      <td><div id="terminalDiv"><?=Terminales($Bodegas)?></div></td>
    </tr>
    <tr>
      <td><div id="CajeroDiv"><?=Cajeros($BogID)?> </div></td>
    </tr>
    <tr>
      <td><?
	  $fech='
	  <input  style="text-align:center" type="text" name="fecha" on   id="fecha" class="cajas" readonly  value="'.date('Y-m-d').'">
      <input type="button" value="." onClick="displayCalendar(document.forms[0].fecha,\'yyyy-mm-dd\',this)" class="b_calendar"><div id="debug"></div>
	  ';
	  
	  
	  $Tex->BarraTitulo('Fecha',$fech,'f_contratoDIV')?></td>
    </tr>
    <tr>
      <td><?=$Tex->BarraTitulo('Valor Base','<input name="base" type="text" class="cajas" id="base" onchange="validarint(this)" size="12" maxlength="8" value="'.$cfg_start_balance.'" style="text-align:center"/> ','f_contratoDIV')?></td>
    </tr>
    <tr>
      <td><?=$Tex->BarraTitulo('Hora Inicio','<input type="text" name="hora" id="hora" size="15" style="text-align:center" class="cajas" />','f_contratoDdIV')?></td>
    </tr>
    <tr>
      <td>
    <?=$Tex->BarraTitulo('Hora Final','<input type="text" name="hora_2"  size="15"	 id="hora_2" style="text-align:center" class="cajas"  />','f_contratoDdIV')?>      <input type="hidden" name="message" id="message" size="30"/>
    <!--<input type="hidden" name="increhoras" id="increhoras" value="<? echo $cfg_turnjournal;?>"/>-->
    <input type="hidden" name="actionID"  value="paso_2"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><?=$Tex->BarraTitulo('','<input type="submit" class="botonGeneral" name="button" id="button" value="Asignar" onclick="return Asignar();" />','BOTONDIV','center')?>  </td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<? 
}else{
//->ACA ENTRA POR FALSO SIGNIFICA QUE HAY ALGUUNA ACCION DENTRO DEL ARCHIVO
//->AHORA CON EL SWITHC MIRO QUE TIPO DE ACCION HIZO EL USUARIO
switch($actionID)
{
case 'VIEWSUCURSAL'://->ACA MUESTRO LAS TERMINALES DISPONIBLES PARA LE BODEGA QUE ME ENVIAN CON LA VARIABLE $BogID
						//echo $BogID.'ss//';
						Terminales($BogID);
						break;
case 'VIEWCAJERO'://->ACA MUESTRO Los cajero DISPONIBLES PARA LE BODEGA QUE ME ENVIAN CON LA VARIABLE $BogID
						//echo $BogID.'ss//';
						Cajeros($BogID);
						break;

case 'ASIGNAR'://->ACA GUARDO Y ASIGNO AL CAJERO Y A LA TERMINAL
						//echo $BogID.'ss//';
						Asigna($BogID, $TermId, $actionID,$CAJEROS,$base,$hora,$hora_2,$fecha);
						break;

}

?>
<? }?>
<?

function Asigna($BogID, $TermId, $actionID,$CAJEROS,$base,$hora,$hora_2,$fecha)
{global $conn_2;
$Tex=new Decoracion();

//echo 'action '.$actionID.'<br>';
//echo 'bodega '.$BogID.'<br>';
//echo 'CAJEROS '.$CAJEROS.'<br>';
//->AHORA VAMOS ACTUALIZAR EN LA TABLA DE USER
$q = "UPDATE pos_users SET status='".$TermId."' WHERE id=".$CAJEROS;
// ejecutando el query
mysql_query($q, $conn_2) or die ("problema con query pos_users");

//->AHORA ACTUALIZAMOS LA TABLA DE TERMINALES
$q = "UPDATE pos_terminal SET user_id='".$CAJEROS."', status=1 , base='".$base."',time='".$hora."',end_time='".$hora_2."', date='".$fecha."'  WHERE id=".$TermId;
// ejecutando el query
mysql_query($q, $conn_2) or die ("problema con query pos_terminal");

//->AHORA HAGO UN QUERY PAR TRAER MI USUARIO
 $Firs=mysql_query('SELECT first_name,last_name 
			  					FROM pos_users WHERE id="'.$CAJEROS.'" ',$conn_2);
				//->es el wihle que RECORRE LA CONSULTA DE LA TABLA pos_inventorylocation PERO REGISTRO POR REGISTRO
			$ko=mysql_fetch_assoc($Firs); 
			$Nombre=$ko['first_name'].' '.$ko['last_name'];
				
//->AHORA HAGO UN QUERY PAR TRAER MI TERMINAL
 $Firs=mysql_query('SELECT terminal_number 
			  					FROM pos_terminal WHERE id="'.$TermId.'" ',$conn_2);
				//->es el wihle que RECORRE LA CONSULTA DE LA TABLA pos_inventorylocation PERO REGISTRO POR REGISTRO
			$ko=mysql_fetch_assoc($Firs); 
			$termna=$ko['terminal_number'];				


?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#E6EFF7"><div align="center">
      <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><?=$Tex->BarraTitulo('','SE ASIGNO SATISFACTORIAMENTE','div','center')?></td>
        </tr>
        <tr>
          <td><?=$Tex->BarraTitulo('TERMINAL::'.$termna,$Nombre,'div','center')?></td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#E6EFF7" align="right"><a href="javascript:void(0)" onclick="MasUser();">Agregar Mas Terminales</a></td>
  </tr>
</table>
<?
}

//->FUNCION PARA SABER EL NUMERO DE TERMINALES QUE HAY EN ESA BODEGA
function Terminales($BogID)
	{
	  global $conn_2;
	  $Tex=new Decoracion();
		//$query="bhjj";
//->SI LA VARIALE DE BOGID VIENE DESOCUPADA
//->MOSTRAMOS EL MENSAJE ESCOGE PRIMERO BODEGA
if($BogID)
{	
			  $var=mysql_query('SELECT ter.terminal_number AS ternum,ter.location_id, ter.id AS terid 
			  					FROM pos_terminal AS ter 
								WHERE  ter.location_id="'.$BogID.'" AND ter.status=0',$conn_2);
				//->es el wihle que RECORRE LA CONSULTA DE LA TABLA pos_inventorylocation PERO REGISTRO POR REGISTRO
			$number=mysql_num_rows($var); 
			if($number){	
				while($row=mysql_fetch_assoc($var))
					{
						
					   $OPC.='<option value="'.$row['terid'].'">Terminal::'.$row['ternum'].'</option>';
					}
				 }else
					{$OPC.='<option value="-1" selected>NO HAY CAJAS DISPONIBLES</option>';}

}else//->POS ACA ES PORQUE NO HAY BODEGA CON QUE COMPRARA
	{
	$OPC.='<option value="-1">ESCOGE UNA SUCURSAL</option>';
	}


$SELECCION='<select name="TERMINAL" id="TERMINAL" class="cajas">
      <option  value="-1" selected >Escoge..</option>
	   '.$OPC.'
	  </select>';
	  
 
 
 
 $Tex->BarraTitulo('Terminal',$SELECCION,'88');
 
 
 
 
 }//->FUNCTION

function Cajeros($BogID)
{
global $conn_2;
$Tex=new Decoracion();
		//$query="bhjj";
//->SI LA VARIALE DE BOGID VIENE DESOCUPADA
//->MOSTRAMOS EL MENSAJE ESCOGE PRIMERO BODEGA
if($BogID)
{	
			  $var=mysql_query('SELECT first_name,last_name,id 
			  					FROM pos_users  
								WHERE  location_id="'.$BogID.'" AND profileid=1 AND status=0',$conn_2);
										 //echo 'SELECT first_name,last_name,id FROM
										 //pos_users  WHERE  location_id="'.$BogID.'" AND profileid='.CAJEROID.' AND status=0';
				//->es el wihle que RECORRE LA CONSULTA DE LA TABLA pos_inventorylocation PERO REGISTRO POR REGISTRO
			$number=mysql_num_rows($var); 
			if($number){	
				while($row=mysql_fetch_assoc($var))
					{
						
					   $OPC.='<option value="'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
					 }
				 }else
					{$OPC.='<option value="-1" selected>NO HAY USUARIOS DISPONIBLES</option>';}

}else//->POS ACA ES PORQUE NO HAY BODEGA CON QUE COMPRARA
	{
	$OPC.='<option value="-1">ESCOGE UNA SUCURSAL</option>';
	}


$selec='<select name="CAJEROS" id="CAJEROS" class="cajas">
      <option  value="-1" selected >Escoge..</option>  
			'.$OPC.'
		</select>';
$Tex->BarraTitulo('Cajero',$selec,'88');
}

?>

<script>

$('message').addEvent('alarm', function(val){
	var m = val.time % 60;
	var h = (val.time - m) / 60;
	this.value = "'" + val.who +"' fire event at " + h + ":" + m;
});

var spinner1 = new TimeSpinner($('hora'));
var spinner1_2 = new TimeSpinner($('hora_2'));

var spinner2 = new TimeSpinner($('example2'), 
	{increment: 10, range: { low:840, high:1080 }, delay:400}, 900 );

var mdate = new Date();
mdate.setHours( 15 );
mdate.setMinutes( 0 );
var spinner3 = new TimeSpinner($('example3'), 
	{increment: 10, range: { low:840, high:1080 }, delay:400, alarm:[930, 1020],
	'doAlarm':function(val) { $('message').fireEvent('alarm',val,0); }},mdate);

</script>
</body>