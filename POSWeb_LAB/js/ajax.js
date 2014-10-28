//  Vamos a presuponer que el usuario es una persona inteligente...
var isIE = false;
//  Creamos una variable para el objeto XMLHttpRequest
var req;
//  Creamos una funcion para cargar los datos en nuestro objeto.
//  Logicamente, antes tenemos que crear el objeto.
//  Vease que la sintaxis varia dependiendo de si usamos un navegador decente
//  o Internet Explorer
function cargaXML(url) {
    //  Primero vamos a ver si la URL es una URL :)
    if(url==''){
        return;
    }
    //  Usuario inteligente...
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send(null);
    //  ...y usuario de Internet Explorer Windows
    } else if (window.ActiveXObject) {
        isIE = true;
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processReqChange;
            req.open("GET", url, true);
            req.send();
        }
    }
}
//open('GET','index.html',TRUE,'','');


function processReqChange(){
    //    Referencia a nuestro DIV con ID unica:
    var detalles = document.getElementById("detalles");
    //    Si se ha completado la carga de datos, los mostramos en el DIV...
    if(req.readyState == 4){
        detalles.innerHTML = req.responseText;
    } else {
        //    ...en caso contrario, le diremos al usuario que los estamos cargando:
        detalles.innerHTML = '<div align="center"><img src="images/load_ajax.gif"><br><span style="font-family:Verdana, Arial, Helvetica, sans-serif">JVMCompany</span></div> ';
    }
}


/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/**********************************************************************************************/
/*******************************OTRA FUNCION****************************************************/

var isIE_2 = false;
//  Creamos una variable para el objeto XMLHttpRequest
var req_2;
//  Creamos una funcion para cargar los datos en nuestro objeto.
//  Logicamente, antes tenemos que crear el objeto.
//  Vease que la sintaxis varia dependiendo de si usamos un navegador decente
//  o Internet Explorer
function cargaXML_2(url) {
    //  Primero vamos a ver si la URL es una URL :)
    if(url==''){
        return;
    }
    //  Usuario inteligente...
    if (window.XMLHttpRequest) {
        req_2 = new XMLHttpRequest();
        req_2.onreadystatechange = processReqChange_2;
        req_2.open("GET", url, true);
        req_2.send(null);
    //  ...y usuario de Internet Explorer Windows
    } else if (window.ActiveXObject) {
        isIE_2 = true;
        req_2 = new ActiveXObject("Microsoft.XMLHTTP");
        if (req_2) {
            req_2.onreadystatechange = processReqChange_2;
            req_2.open("GET", url, true);
            req_2.send();
        }
    }
}
//open('GET','index.html',TRUE,'','');


function processReqChange_2(){
    //    Referencia a nuestro DIV con ID unica:
    var detalles_2 = document.getElementById("detalles_2");
    //    Si se ha completado la carga de datos, los mostramos en el DIV...
    if(req_2.readyState == 4){
        detalles_2.innerHTML = req_2.responseText;
    } else {
        //    ...en caso contrario, le diremos al usuario que los estamos cargando:
        detalles_2.innerHTML = '<div align="center"><img src="../images/load_ajax.gif"><br><span style="font-family:Verdana, Arial, Helvetica, sans-serif">JVMCompany</span></div> ';
    }
}

/******************************************************************/

function ajaxpage_2(url, containerid,containerid_2){
var page_request = false
if (window.XMLHttpRequest) // if Mozilla, Safari etc
page_request = new XMLHttpRequest()
else if (window.ActiveXObject){ // if IE

try {
page_request = new ActiveXObject("Msxml2.XMLHTTP")
} 
catch (e){
try{
page_request = new ActiveXObject("Microsoft.XMLHTTP")
}
catch (e){}
}
}
else
return false
var capaContenedora = document.getElementById(containerid_2);

//funcion para el efecto onreanchange


page_request.onreadystatechange=function(){
			if(page_request.readyState == 4){	
				capaContenedora.innerHTML = '';
				ArboLoadpage_2(page_request, containerid);
				}else
					{
							capaContenedora.innerHTML = '<img src="class/images/load_min.gif" border=0 height=10 width=10 >';	
							//capaContenedora.innerHTML = '<div id="carga_sobre"></div>';	
					}
}


page_request.open('GET', url, true)
page_request.send(null)
}
function ArboLoadpage_2(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(containerid).innerHTML=page_request.responseText
//containerid.innerHTML="SoLoska.net Cargando.............";
}


