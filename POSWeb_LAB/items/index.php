<?php session_start();
$url_class =("../settings.php");                                if(!file_exists($url_class)) {echo 'Error_includ{' . $url_class.'}<br>';}else{include ($url_class);}
$url_class =("../language/$cfg_language");                      if(!file_exists($url_class)) {echo 'Error_includ{' . $url_class.'}<br>';}else{include ($url_class);}
$url_class =("../classes/db_functions.php");                    if(!file_exists($url_class)) {echo 'Error_includ{' . $url_class.'}<br>';}else{include ($url_class);}
$url_class =("../classes/security_functions.php");              if(!file_exists($url_class)) {echo 'Error_includ{' . $url_class.'}<br>';}else{include ($url_class);}
define(URL_RAIZ_FONDO,'../');
$url_class =(URL_RAIZ_FONDO.'classes/TextDecoracion.php');      if(!file_exists($url_class)) {echo 'Error_includ{' . $url_class.'}<br>';}else{include ($url_class);}
$url_class =(URL_RAIZ_FONDO.'classes/stylos_new.class.php');    if(!file_exists($url_class)) {echo 'Error_includ{' . $url_class.'}<br>';}else{include ($url_class);}
      
      

	$ObjDeco=new TextDecoracion();		


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

?>
<html>
<body>
<table border="0" width="500">
  <tr>
    <td><img border="0" src="../images/menubar/items.png" width="55" height="55" valign='top'><font color='#005B7F' size='4'>&nbsp;<b><?=$lang->items?></b></font><br>
      <br>
      <font face="Verdana" size="2"><?=$lang->itemsWelcomeScreen?></font>
<!--      <ul>
        <li><font face="Verdana" size="2"><a href="form_items.php?action=insert">< ?=$lang->createNewItem?></a></font></li>
       <ul>
      	  <li><font face="Verdana" size="2"><a href="discounts/form_discounts.php?action=insert">< ?=$lang->discountAnItem?></a></font></li>
      	  <li><font face="Verdana" size="2"><a href="discounts/manage_discounts.php">< ?=$lang->manageDiscounts?></a></font></li>
		</ul>
 		  <li><font face="Verdana" size="2"><a href="manage_items.php">< ?=$lang->manageItems?></a></font></li>
         <li><font face="Verdana" size="2"><a href="items_barcode.php">< ?=$lang->itemsBarcode?></a></font></li>
       
-->     <ul>
   			<?=$ObjDeco->Cuadro_Links($lang->manageItems,'manage_items.php');?>
   			<?=$ObjDeco->Cuadro_Links($lang->itemsBarcode,'items_barcode.php');?>

      	
      </ul>
      
<!--      <ul>
        <li><font face="Verdana" size="2"><a href="brands/form_brands.php?action=insert">< ?=$lang->createBrand?></a></font></li>
        <li><font face="Verdana" size="2"><a href="brands/manage_brands.php">< ?=$lang->manageBrands?></a></font></li>
      </ul>
      <ul>
        <li><font face="Verdana" size="2"><a href="categories/form_categories.php?action=insert">< ?=$lang->createCategory?></a></font></li>
        <li><font face="Verdana" size="2"><a href="categories/manage_categories.php">< ?=$lang->manageCategories?></a></font></li>
      </ul>
       <ul>
        <li><font face="Verdana" size="2"><a href="suppliers/form_suppliers.php?action=insert">< ?=$lang->createSupplier?></a></font></li>
        <li><font face="Verdana" size="2"><a href="suppliers/manage_suppliers.php">< ?=$lang->manageSuppliers?></a></font></li>
      </ul>-->
      <p>&nbsp;</td>
  </tr>
</table>

</body>

</html><?
$dbf->closeDBlink();

?>
