<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset=iso-8859-1?/>
<title>Principal</title>
<link href="index.css" rel="stylesheet" type="text/css"/>
<script src="ajax/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
</head>
<body>
<div id="cuerpo">
<b class="rtop"><b class="r1?></b><b class="r2?></b><b class="r3?></b><b class="r4?></b></b>
<table>
<tr>
<td>
<img src="images/alum.png" alt="Alumn@s" />
</td>
<td>
<input type="text" id="autorelleno" name="texto_auto"/>
<span id="spinner" style="display: none">
</span>
<div id="lista_opciones" class="autorelleno">
</div>
<script>
new Ajax.Autocompleter("autorelleno", "lista_opciones", "lista.php", {method: "post", paramName: "value", minChars: 1, indicator: "spinner"});
</script>
</td>
<td>
Búsqueda de Alumn@s por nombre
</td>
</tr>
</table>
<b class="rbottom"><b class="r4?></b><b class="r3?></b><b class="r2?></b><b class="r1?></b></b>
</div>
</body>
</html>