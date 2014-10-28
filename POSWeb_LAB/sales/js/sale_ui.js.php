<script>
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

function procesarinfo3(){
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
	
	
	<?PHp if(FACTURAR_CON_TODO_INV_EN_CERO===true){?>
									document.getElementById("item").value 		=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue; 
									document.getElementById("inputString").value=xmlDoc.getElementsByTagName("valor2")[0].childNodes[0].nodeValue; 
									document.getElementById("consitem").disabled = false;                
		<?PHp

	}else{?>
					      var valido = confirm('El Producto no tiene inventario suficiente para ser Dispensado y/o Vendido\nDesea Agregarlo?');
			              if(valido){
									document.getElementById("item").value 		=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue; 
									document.getElementById("inputString").value=xmlDoc.getElementsByTagName("valor2")[0].childNodes[0].nodeValue; 
									document.getElementById("consitem").disabled = false;                
			              }else{  
			             
			              ClearField();
			              return false;
			             
			              	}
	<?PHp }?>	           

            }  else {
			document.getElementById("item").value=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue; 
			document.getElementById("inputString").value=xmlDoc.getElementsByTagName("valor2")[0].childNodes[0].nodeValue; 
			document.getElementById("consitem").disabled = false;
			}
		   }
  	} 
}	


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

	<?PHp if(FACTURAR_CON_TODO_INV_EN_CERO===true){
	?>        		
					document.getElementById("item").value=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue;
        			document.getElementById("item_search2").value=xmlDoc.getElementsByTagName("barcnumb")[0].childNodes[0].nodeValue;
        			document.getElementById("consitem").disabled = false;                
	<?PHp	

	}else{?>
		      var valido = confirm('El Producto no tiene inventario suficiente para ser Dispensado y/o Vendido\nDesea Agregarlo?');
              if(valido){
        		    document.getElementById("item").value=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue;
        			document.getElementById("item_search2").value=xmlDoc.getElementsByTagName("barcnumb")[0].childNodes[0].nodeValue;
        			document.getElementById("consitem").disabled = false;                
              }else{
              ClearField();
              return false;
			  document.getElementById("item").value=xmlDoc.getElementsByTagName("valor")[0].childNodes[0].nodeValue;
			document.getElementById("item_search2").value=xmlDoc.getElementsByTagName("barcnumb")[0].childNodes[0].nodeValue;
			document.getElementById("consitem").disabled = false;
		      }
	<?PHp }#if(FACTURAR_CON_TODO_INV_EN_CERO===true){?>	           

			}
  	} 
}

</script>