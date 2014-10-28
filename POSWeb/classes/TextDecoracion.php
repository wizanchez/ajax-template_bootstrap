<?PHp
class TextDecoracion{
	//Fincion para crear Links	
	public function Cuadro_Links($Texto,$href)
	     {
		 ?><p>
            <div class="popScripts EfectoZoom">
                 <div class="popScriptLink ">
                	<a title="<?=$Texto?>" href="<?=$href?>" ><?=$Texto?></a>
                </div>   
            </div><br><p>
		 <? }//CuadroTitulos($Texto)


///funcuion para colocar efecto sobre 
//se utiliza dentro de etiquetas <a  $TextDecoration->EfectoSobre('textoa colocar','ancho de la decoracion');  ></a>
	public function EfectoSobre($Texto,$Ancho)
	    {?>
		onMouseover="ddrivetip_2('<div class=sencillo ><?=$Texto?></div>','<?=$Ancho?>')"; onMouseout="hideddrivetip_2()"
		<? }//EfectoSobre
	
	
	
	public function CuadroTitulos($Texto,$div,$class)
	     {
		 if($class){$class='class='.$class; $Titulo='';}else{$class=''; $Titulo='class="TituloInv"';}
		 ?>
                     <table width="99%"  border="0" cellspacing="0" cellpadding="0"  <?=$Titulo?> >
                    <tr>
                      <td width="10"><div  class="InvTituloIzqui"></div></td>
                      <td class="InvTitulofondo" align="center"><div id="<?=$div?>" <?=$class?> ><?=$Texto?></div></td>
                      <td width="10"><div align="center" class="InvTituloDer"></div></td>
                    </tr>
                  </table>
		 <? }//CuadroTitulos($Texto)
	
		function CuadroTitulos_2($Texto,$div,$class)
	     {
		 if($class){$class='class='.$class; $Titulo='';}else{$class=''; $Titulo='class="DesTituloInv"';}
		 ?>
                     <table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0"  <?=$Titulo?> >
                    <tr>
                      <td width="10"><div  class="DesTituloIzqui"></div></td>
                      <td class="DesTitulofondo" align="center"><div id="<?=$div?>" <?=$class?> ><?=$Texto?></div></td>
                      <td width="10"><div align="center" class="DesTituloDer"></div></td>
                    </tr>
                  </table>
		 <? }//CuadroTitulos($Texto)
	

	public function CuadroTitulosUp($Texto,$DIV)
	     {
	?>
	<table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20"><div  class="InvTituloUpIzq"></div></td>
        <td width="15" class="InvTituloUpCenter"><div align="center" id="<?=$DIV?>"></div></td>
        <td width="100%" class="InvTituloUpCenter InvUpText"><?=$Texto?></td>
        <td width="8"><div  class="InvTituloUpDer"></div></td>
      </tr>
    </table>
	<? }
	
	public function CuadroTitulosUpHover($Texto)
	     {
	?>
	<table  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20"><div  class="InvTituloUpIzqHover"></div></td>
        <td width="15" class="InvTituloUpCenterHover"></td>
        <td width="100%"class="InvTituloUpCenterHover InvUpTextHover"><?=$Texto?></td>
        <td width="8"><div  class="InvTituloUpDerHover"></div></td>
      </tr>
    </table>
	<? }
public function BarraTitulo($TEXT,$aling,$div){
	switch($aling){
		case 'derecha':{$ALI='right';}break;
		case 'izquierda':{$ALI='left';}break;
		default:{$ALI='center';}break;
		}
	?>
<div align="<?=$ALI?>"  style="margin:1px; margin-top:3px;"class="FondoBarra_2"><span  align="<?=$ALI?>" id="<?=$div?>"><strong><?=$TEXT?></strong></span></div>
<? }





/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	public function CuadroLabels($Texto,$div,$align,$onClick)
	     {
			switch($align){
				case 'izquierda':{$Alinear='left';}break;	
				case 'centro':{$Alinear='center';}break;	
				case 'derecha':{$Alinear='right';}break;	
						default:{$Alinear='center';}break;
				}
			?>
		<div class="Borde_x TexTitulo_label" 
        		id="<?=$div?>" onclick="<?=$onClick?>" <? if($MESS) TextDecoracion::EfectoSobre($MESS,'200');?>  
             	align="<?=$Alinear?>">&nbsp;<?=$Texto?>&nbsp;</div>	
			
		<?	}//CuadroTitulos($Texto)

	public function CuadroLabels_puntas($Texto,$div,$align,$onClick)
	     {
			switch($align){
				case 'izquierda':{$Alinear='left';}break;	
				case 'centro':{$Alinear='center';}break;	
				case 'derecha':{$Alinear='right';}break;	
						default:{$Alinear='center';}break;
				}
			?>
		<div class="Borde_punta TexTitulo_label" 
        		id="<?=$div?>" onclick="<?=$onClick?>" <? if($MESS) TextDecoracion::EfectoSobre($MESS,'200');?>  
                align="<?=$Alinear?>">&nbsp;<?=$Texto?>&nbsp;</div>	
			
		<?	}//CuadroTitulos($Texto)
		
	public function CuadroLabels_puntas_vino($Texto,$div,$align,$onClick)
	     {
			switch($align){
				case 'izquierda':{$Alinear='left';}break;	
				case 'centro':{$Alinear='center';}break;	
				case 'derecha':{$Alinear='right';}break;	
						default:{$Alinear='center';}break;
				}
			?>
		<div class="Borde_punta_vino TexTitulo_label" 
        		id="<?=$div?>" onclick="<?=$onClick?>" <? if($MESS) TextDecoracion::EfectoSobre($MESS,'200');?>  
                align="<?=$Alinear?>" >&nbsp;<?=$Texto?>&nbsp;
       </div>	
			
		<?	}//CuadroTitulos($Texto)
		
	public function CuadroLabels_carbon($Texto,$div,$align,$onClick)
	     {
			switch($align){
				case 'izquierda':{$Alinear='left';}break;	
				case 'centro':{$Alinear='center';}break;	
				case 'derecha':{$Alinear='right';}break;	
						default:{$Alinear='center';}break;
				}
			?>
		<div class="fondo_carbon TexTitulo_label" 
        		id="<?=$div?>" onclick="<?=$onClick?>" <? if($MESS) TextDecoracion::EfectoSobre($MESS,'200');?>  
             align="<?=$Alinear?>">&nbsp;<?=$Texto?>&nbsp;</div>	
			
		<?	}//CuadroTitulos($Texto)




}//class

?>
<?php /*?><style type="text/css">

#dhtmltooltip{
position: absolute;
left: -300px;
width: 150px;
border: 1px solid black;
padding: 2px;
background-color: lightyellow;
visibility: hidden;
z-index: 100;
//Remove below line to remove shadow. Below line should always appear last within this CSS
filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
}

#dhtmlpointer{
position:absolute;
left: -300px;
z-index: 101;
visibility: hidden;
}

</style>

<script type="text/javascript">

var offsetfromcursorX=12 //Customize x offset of tooltip
var offsetfromcursorY=10 //Customize y offset of tooltip

var offsetdivfrompointerX=10 //Customize x offset of tooltip DIV relative to pointer image
var offsetdivfrompointerY=14 //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

document.write('<div id="dhtmltooltip"></div>') //write out tooltip DIV
document.write('<img id="dhtmlpointer" src="images/arrow2.gif">') //write out pointer image

var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

var pointerobj=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip_2(thetext, thewidth, thecolor){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var nondefaultpos=false
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20

var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY

var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth){
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=curX-tipobj.offsetWidth+"px"
nondefaultpos=true
}
else if (curX<leftedge)
tipobj.style.left="5px"
else{
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetfromcursorX-offsetdivfrompointerX+"px"
pointerobj.style.left=curX+offsetfromcursorX+"px"
}

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px"
nondefaultpos=true
}
else{
tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
pointerobj.style.top=curY+offsetfromcursorY+"px"
}
tipobj.style.visibility="visible"
if (!nondefaultpos)
pointerobj.style.visibility="visible"
else
pointerobj.style.visibility="hidden"
}
}

function hideddrivetip_2(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
pointerobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

  </script><?php */?>