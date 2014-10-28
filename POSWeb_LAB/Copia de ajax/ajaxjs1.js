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

function updateScanItem(cadena,c){
	ajax=nuevoAjax();
	var a = document.getElementById("inputString").value; 
	ajax.onreadystatechange = procesarinfo1;
	ajax.open("GET","../ajaxcampos1.php?cadena="+a+"&c="+c,true);
	ajax.send(null);
}

function procesarinfo1(){
	//var cantidades = document.getElementById("cantidades"); 
	
	if(ajax.readyState != 4){
			//document.getElementById("camposing").innerHTML = '<div align="center"><img src="./images/load_ajax.gif" ><br />JVM Cargando....</div>'	
		}
	
	if( ajax.readyState == 4){
		//cantidades.innerHTML = ajax.responseText;
		xmlDoc=ajax.responseXML;
	    var cantiv = xmlDoc.getElementsByTagName("cantinv")[0].childNodes[0].nodeValue;
		
		if(xmlDoc.getElementsByTagName("cantinv")[0].childNodes[0].nodeValue != 0 && xmlDoc.getElementsByTagName("price")[0].childNodes[0].nodeValue != 0 && xmlDoc.getElementsByTagName("cost")[0].childNodes[0].nodeValue != 0)
		  {
		    document.getElementById("item").value=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue;
			document.getElementById("item_search2").value=xmlDoc.getElementsByTagName("barcnumb")[0].childNodes[0].nodeValue;
			document.getElementById("consitem").disabled = false;
		  }
		else 
		    {
			  document.getElementById("item").value=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue;
			document.getElementById("item_search2").value=xmlDoc.getElementsByTagName("barcnumb")[0].childNodes[0].nodeValue;
			document.getElementById("consitem").disabled = false;
		
			}
  	} 
}

function Validarsuperv(b,c){ 
	
	ajax=nuevoAjax();
	ajax.onreadystatechange = valsup;
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
						 alert("Usuario o Contraseņa incorrectos");
						 document.getElementById("username").value = '';
						 document.getElementById("clave").value = '';
						 document.getElementById("updqty").disabled = true;
						 return false;
					   }
					   if(xmlDoc.getElementsByTagName("valsuperv")[0].childNodes[0].nodeValue == 3)
					   {
						 alert("El Usuario no es Supervisor");
						 document.getElementById("username").value = '';
						 document.getElementById("clave").value = '';
						 document.getElementById("username").focus();
 						 document.getElementById("updqty").disabled = true;
						 
						 return false;
					   } 
					    if(xmlDoc.getElementsByTagName("valsuperv")[0].childNodes[0].nodeValue == 2)
					   {
						 document.getElementById("updqty").disabled = false;
						 document.getElementById("sale_discount").value =  document.getElementById("global_sale_discount").value; 
						 
						 
					   } 
				   }
			    }
                

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ReCalcSubTotal(a,b,c,d,e,f,g,h){ 
	
	ajax=nuevoAjax();
	ajax.onreadystatechange = ReCalcSubTotalRes;
	ajax.open("GET","../ajaxcampos1.php?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f+"&g="+g+"&h="+h,true);
	ajax.send(null);
}

function ReCalcSubTotalRes()
		        {
		         if(ajax.readyState != 4)
				   {
			        //document.getElementById("camposing").innerHTML = '<div align="center"><img src="./images/load_ajax.gif" ><br />JVM Cargando....</div>'	
		           }
		 	     if( ajax.readyState == 4)
		 	       {
		 	         xmlDoc=ajax.responseXML;
				
					    document.getElementById("stvta").value = xmlDoc.getElementsByTagName("subtot")[0].childNodes[0].nodeValue;
						 document.getElementById("saleTotalCost").value = xmlDoc.getElementsByTagName("subtot")[0].childNodes[0].nodeValue;
						
					   
				   }
			    }
                
///////////  validar al administrador del punto de venta

function Validaradmon(c){ 
	
	ajax=nuevoAjax();
	ajax.onreadystatechange = valad;
	if( document.getElementById("usernameadmon").value == '') { alert('Digite el usuario'); document.getElementById("usernameadmon").focus();  return false; } 
	if( document.getElementById("claveadmon").value == '') { alert('Digite la contraseņa'); document.getElementById("claveadmon").focus();  return false; } 
	var a= document.getElementById("usernameadmon").value;
	var b= document.getElementById("claveadmon").value;
	ajax.open("GET","../ajaxvalsup.php?a="+a+"&b="+b+"&c="+c,true);
	ajax.send(null);
}

function valad()
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
						 alert("Usuario o Contraseņa incorrectos");
						 document.getElementById("usernameadmon").value = '';
						 document.getElementById("claveadmon").value = '';
						
						 return false;
					   }
					    if(xmlDoc.getElementsByTagName("valsuperv")[0].childNodes[0].nodeValue == 2)
					   {
						 
						 
						 
					   } 
				   }
			    }