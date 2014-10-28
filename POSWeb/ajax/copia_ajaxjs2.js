// JavaScript Document

function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
/*  var xmlHttp=null;
  if (window.ActiveXObject) 
    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  else 
    if (window.XMLHttpRequest) 
      xmlHttp = new XMLHttpRequest();
  return xmlHttp;	*/
}
	var ajax;

function procesarinfo2(){
	//var cantidades = document.getElementById("cantidades"); 
	
	if(ajax.readyState != 4){
			//document.getElementById("camposing").innerHTML = '<div align="center"><img src="./images/load_ajax.gif" ><br />JVM Cargando....</div>'	
		}
	
	if( ajax.readyState == 4){
		//cantidades.innerHTML = ajax.responseText;
		xmlDoc=ajax.responseXML;
		if(xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue == 0)
		  {
			//alert("Producto no encontrado");
			document.getElementById("item_search2").value = '';
			document.getElementById("item_search2").focus();
			document.getElementById("item").value = '';
			document.getElementById("inputString").value = '';
			document.getElementById("consitem").disabled = true;
			
		  }
		 else if(xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue == 1)
		  {
			alert("El producto "+xmlDoc.getElementsByTagName("valor2")[0].childNodes[0].nodeValue+" no puede ser facturado.");
			document.getElementById("item_search2").value = '';
			document.getElementById("item_search2").focus();
			document.getElementById("item").value = '';
			document.getElementById("inputString").value = '';
			document.getElementById("consitem").disabled = true;
			
		  } 
	    else
		   {
		      
            if(xmlDoc.getElementsByTagName("valor3")[0].childNodes[0].nodeValue == 0){
		      alert('El Producto no tiene inventario suficiente para ser Dispensado y/o Vendido');
              ClearField();
              return false;
            }  else {
			document.getElementById("item").value=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue; 
			document.getElementById("inputString").value=xmlDoc.getElementsByTagName("valor2")[0].childNodes[0].nodeValue; 
			document.getElementById("consitem").disabled = false;
			}
		   }
  	} 
}