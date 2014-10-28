// JavaScript Document
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
}
	var ajax;


//////////////////////////////////////////////////// validar que el codigo de barras de venta o de compra no exista 

function Validarsuperv(b,c){ 
	
	ajax=nuevoAjax();
	ajax.onreadystatechange = valsup;
	alert('victor');
	 d = document.getElementById("username").value;
	ajax.open("GET","../ajaxvalsup.php?b="+b+"&c="+c+"&d="+d,true);
	ajax.send(null);
}

function valsup()
		        {
		         if(ajax.readyState != 4)
				   {
			        //document.getElementById("camposing").innerHTML = '<div align="center"><img src="./images/load_ajax.gif" ><br />JVM Cargando....</div>'	
		           }
		 	     if( ajax.readyState == 4)
		 	       {
		 	         xmlDoc=ajax.responseXML;
					 if(xmlDoc.getElementsByTagName("valsuperv")[0].childNodes[0].nodeValue == 0)
					   {
						 alert("Usuario o Contraseña incorrectos");
						 document.getElementById("username").value = '';
						 document.getElementById("clave").value = '';
						 return false;
					   }
					   if(xmlDoc.getElementsByTagName("valsuperv")[0].childNodes[0].nodeValue == 3)
					   {
						 alert("El Usuario no es Supervisor");
						 document.getElementById("username").value = '';
						 document.getElementById("clave").value = '';
						 return false;
					   } 
					    if(xmlDoc.getElementsByTagName("valsuperv")[0].childNodes[0].nodeValue == 2)
					   {
						 document.getElementById("updqty").disabled = false;
						 
					   } 
				   }
			    }
                
