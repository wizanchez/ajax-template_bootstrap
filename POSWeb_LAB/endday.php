<form name="endday" method="post" action="">
<table>
   <tr>
          <td width="174" height="22"   class="table_2" align="right">Fecha Generacion:</td>
          <td width="280"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td background="images/fondo_menu.jpg">&nbsp;&nbsp;
                  <input  class="cajas" type="text" name="begindate" id="begindate" size="11" maxlength="15" readonly="readonly" value="<? echo date("Y-m-d");?>"/></td>
            </tr>
          </table></td>
        </tr>
   <tr>
     <td colspan="2">&nbsp;</td>
   </tr>
  <tr>
    <td colspan="2"><label>
      <input type="submit" name="generar" id="generar" value="Generar Fin de Dia">
    </label></td>
  </tr>
</table>
</form>
