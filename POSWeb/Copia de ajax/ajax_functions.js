// JavaScript Document<script type="text/javascript" >
////funciones para los popos
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=1,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=0,width=1000,height=600,left = 140,top = 262');");
}

function popUp_2(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=1,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=0,width=1000,height=600,left = 140,top = 262');");
}
/*ajax por metodo get */
function creaAjax_2(){
  var objetoAjax=false;
  try {
   /*Para navegadores distintos a internet explorer*/
   objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
   try {
     /*Para explorer*/
     objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
     } 
     catch (E) {
     objetoAjax = false;
   }
  }

  if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
   objetoAjax = new XMLHttpRequest();
  }
  return objetoAjax;
}

/*ajax por metodo get */
function creaAjax(){
  var objetoAjax=false;
  try {
   /*Para navegadores distintos a internet explorer*/
   objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
   try {
     /*Para explorer*/
     objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
     } 
     catch (E) {
     objetoAjax = false;
   }
  }

  if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
   objetoAjax = new XMLHttpRequest();
  }
  return objetoAjax;
}


 function FAjax(url,capa,valores,metodo)
{
   var ajax=creaAjax();
   var detalle = document.getElementById(capa);

/*Creamos y ejecutamos la instancia si el metodo elegido es POST*/
 if(metodo.toUpperCase()=='POST'){
        document.write="hola pepe";
    ajax.open ('POST', url, true);
    ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
                 detalle.innerHTML="<table width=100% border=0 align=center cellpadding=0 cellspacing=0><tr><td><div align=center><img src=images/load_ajax.gif /><br /><span class=subTitulos >JVM Cargando....</span></div></td></tr></table>";
         }
         else if (ajax.readyState==4){
            if(ajax.status==200)
            {
                 document.getElementById(capa).innerHTML=ajax.responseText; 
            }
            else if(ajax.status==404)
                 {

                     detalle.innerHTML = "Por favor cargar la Pagina.... NO TERMINO EL PROCEDIMIENTO";
                 }
             else
                 {
                     detalle.innerHTML = "Error: ".ajax.status;
                 }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send(valores);
    return;
}
/*Creamos y ejecutamos la instancia si el metodo elegido es GET*/
if (metodo.toUpperCase()=='GET'){

    ajax.open ('GET', url, true);
    ajax.onreadystatechange = function() {
         if (ajax.readyState==1) {
                 detalle.innerHTML="<table width=100% border=0 align=center cellpadding=0 cellspacing=0><tr><td><div align=center><img src=images/load_ajax.gif /><br /><span class=subTitulos >JVM Cargando....</span></div></td></tr></table>";
         }
         else if (ajax.readyState==4){
            if(ajax.status==200){ 
                 document.getElementById(capa).innerHTML=ajax.responseText; 
            }
            else if(ajax.status==404)
                 {

                     detalle.innerHTML = "La direccion existe";
                 }
                 else
                 {
                     detalle.innerHTML = "Error: ".ajax.status;
                 }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send(null);
    return
}
}



 function JvmPost(url_2,capa_2,valores_2,metodo_2,precarga)
{
   var ajax_2=creaAjax_2();
   var detalle_2 = document.getElementById(capa_2);
   var precarga_2 = document.getElementById(precarga);
/*Creamos y ejecutamos la instancia si el metodo elegido es POST*/
 if(metodo_2.toUpperCase()=='POST'){
        document.write="hola pepe";
    ajax_2.open ('POST', url_2, true);
    ajax_2.onreadystatechange = function() {
         if (ajax_2.readyState==1) {
                 precarga_2.innerHTML="<div id=CargaSobre ><img src=images/JvmCargado.gif width=165 height=80 /></div>";
         }
         else if (ajax_2.readyState==4){
            if(ajax_2.status==200)
            {
                 document.getElementById(capa_2).innerHTML=ajax_2.responseText; 
            }
            else if(ajax_2.status==404)
                 {

                     detalle_2.innerHTML = "Por favor cargar la Pagina.... NO TERMINO EL PROCEDIMIENTO";
                 }
             else
                 {
                     detalle_2.innerHTML = "Error: ".ajax_2.status;
                 }
        }
    }
    ajax_2.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax_2.send(valores_2);
    return;
}
/*Creamos y ejecutamos la instancia si el metodo elegido es GET*/
if (metodo_2.toUpperCase()=='GET'){

    ajax_2.open ('GET', url_2, true);
    ajax_2.onreadystatechange = function() {
         if (ajax_2.readyState==1) {
                 precarga_2.innerHTML="<div id=CargaSobre ><img src=images/JvmCargado.gif width=165 height=80 /></div>";
         }
         else if (ajax_2.readyState==4){
            if(ajax_2.status==200){ 
                 document.getElementById(capa_2).innerHTML=ajax_2.responseText; 
            }
            else if(ajax_2.status==404)
                 {

                     detalle_2.innerHTML = "La direccion existe";
                 }
                 else
                 {
                     detalle_2.innerHTML = "Error: ".ajax_2.status;
                 }
        }
    }
    ajax_2.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax_2.send(null);
    return
}
}
/**************************************************************************************************************/

var loadedobjects=""
var rootdomain="http://"+window.location.hostname

function ajaxpage(url, containerid){
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
page_request.onreadystatechange=function(){
loadpage(page_request, containerid)
}
page_request.open('GET', url, true)
page_request.send(null)
}

function loadpage(page_request, containerid){
if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
document.getElementById(containerid).innerHTML=page_request.responseText
}

function loadobjs(){
if (!document.getElementById)
return
for (i=0; i<arguments.length; i++){
var file=arguments[i]
var fileref=""
if (loadedobjects.indexOf(file)==-1){ //Check to see if this object has not already been added to page before proceeding
if (file.indexOf(".js")!=-1){ //If object is a js file
fileref=document.createElement('script')
fileref.setAttribute("type","text/javascript");
fileref.setAttribute("src", file);
}
else if (file.indexOf(".css")!=-1){ //If object is a css file
fileref=document.createElement("link")
fileref.setAttribute("rel", "stylesheet");
fileref.setAttribute("type", "text/css");
fileref.setAttribute("href", file);
}
}
if (fileref!=""){
document.getElementsByTagName("head").item(0).appendChild(fileref)
loadedobjects+=file+" " //Remember this object as being already added to page
}
}
}


function ajaxcombo(selectobjID, loadarea){
var selectobj=document.getElementById? document.getElementById(selectobjID) : ""
if (selectobj!="" && selectobj.options[selectobj.selectedIndex].value!="")
ajaxpage(selectobj.options[selectobj.selectedIndex].value, loadarea)
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


















