<?

class Decoracion
{
	function BarraTitulo($Titulos,$Conte,$DIV_2,$aling) 
			{
			if(!$aling)$aling='right';
			 
			?>

                                    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <? if($Titulos){?>
        <table width="401"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="39"><img src="../imagenes/titizqui.png" width="39" height="29" /></td>
            <td width="71" background="../imagenes/titicenter.png" ><span class="TITULOSC"><?=$Titulos?> </span></td>
            <td width="7" background="../imagenes/titicenter.png" >&nbsp;</td>
            <td width="15" align="center" background="../imagenes/titicenter.png"><div align="center"><span class="TITULOSC"><img src="../imagenes/titider.png" width="15" height="29" /></span></div></td>
          <td width="239" align="right"> <input type="text" name="textfield" id="textfield" value="                   COMENTARIO" size="37" /></td>
            <td width="30" align="right"><span class="TITULOSC"><img src="../imagenes/titider.png" width="0" height="29" /></span></td>
          </tr>
        </table>
        <? }?>        </td>
      </tr>
      <tr>
        <td><table  border="0" width="100%"  cellspacing="0" cellpadding="0">
          <tr>
            <td width="1%"><img src="../imagenes/titizqui_2.png" width="15" height="29"></td>
            <td  background="../imagenes/titicenter_2.png">
              <table  border="0" align="<?=$aling?>" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><div id="<?=$DIV_2?>" class="SUBTITULOSC"><?=$Conte?></div></td>
                      </tr>
              </table>            </td>
            <td width="1%" align="<?=$aling?>"><img src="../imagenes/titider_2.png" width="15" height="29"></td>
          </tr>
        </table></td>
      </tr>
</table>
			
			<? }
			
			function Titulo($Titulos,$Conte,$DIV_2,$aling) 
			{
			if(!$aling)$aling='right';
			 
			?>

                                    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <? if($Titulos){?>
        <table width="401"  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="39"></td>
            <td width="71"><span><?=$Titulos?> </span></td>
            <td width="7">&nbsp;</td>
            <td width="15" align="center"><div align="center"><span class="TITULOSC"></span></div></td>
          <td width="239" align="right"></td>
            <td width="30" align="right"><span class="TITULOSC"></span></td>
          </tr>
        </table>
        <? }?>        </td>
      </tr>
      <tr>
        <td><table  border="0" width="100%"  cellspacing="0" cellpadding="0">
          <tr>
            <td width="1%"></td>
            <td>
              <table  border="0" align="<?=$aling?>" cellpadding="0" cellspacing="0">
                      <tr>
                        <td bgcolor="#000000"><span class="#FFFFFF"><div id="<?=$DIV_2?>" ><?=$Conte?></div></span></td>
                      </tr>
              </table>            </td>
            <td width="1%" align="<?=$aling?>"></td>
          </tr>
        </table></td>
      </tr>
</table>
			
			<? }
			
			


 }?>
<style type="text/css">
<!--
.TITULOSC {
	color: #cadced;
	font-family: Tahoma;
	font-size: 11px;
	font-weight: bold;
}
.SUBTITULOSC {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #CCCCCC;
}
-->
</style> 
