<?php session_start();
include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");
define(URL_RAIZ_FONDO,'../');
include(URL_RAIZ_FONDO.'classes/stylos_new.class.php'); 

//include ("../Connections/conexion.php");
//$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
// Gets current values from settings.php
function getFormFields() 
{
	global $cfg_company;
	global $cfg_company_nit;
	global $cfg_address;
	global $cfg_phone;
	global $cfg_email;	
	global $cfg_fax;
	global $cfg_website;
	global $cfg_other;
	global $cfg_default_tax_rate;
	global $cfg_currency_symbol;
	global $cfg_theme;
	global $cfg_language;
	global $cfg_numberForBarcode;
    global $cfg_res_fact;
	global $cfg_fact_desde;
	global $cfg_fac_hasta;
    global $cfg_pref_fac;
	global $cfg_start_balance;
	global $cfg_turnjournal;
	global $cfg_sucursal;
	global $cfg_companycomments;
	global $cfg_companynitcomments;
	global $cfg_sucursalcomments;
	global $cfg_companyAddresscomments;
    global $cfg_companyPhonecomments;
	global $cfg_companyEmailcomments;
	global $cfg_companyFaxcomments;
	global $cfg_companyWebsitecomments;
	global $cfg_companyOthercomments;
	global $cfg_themeSelectedcomments;	
	global $cfg_taxRatecomments;	
	global $cfg_currencySymbolcomments;
	global $cfg_numberForBarcodecomments;	
	global $cfg_languagecomments;	
	global $cfg_res_factcomments;	
	global $cfg_fact_desdecomments;	
	global $cfg_fac_hastacomments;	
	global $cfg_pref_faccomments;	
	global $cfg_start_balancecomments;	
	global $cfg_turnjournalcomments;	
	global $cfg_tckcodetype;
	global $cfg_commentsttckcodetype;
	global $cfg_footer1;
	global $cfg_commentsfooter1;
	global $cfg_footer2;
	global $cfg_commentsfooter2;
	global $cfg_footer3;
	global $cfg_commentsfooter3;
	global $cfg_header1;
	global $cfg_commentsheader1;
	global $cfg_header2;
	global $cfg_commentsheader2;
	global $cfg_header3;
	global $cfg_commentsheader3;
	global $cfg_promomgnt;
	global $cfg_commentspromomgnt;
	global $cfg_dsctoprod;
	global $cfg_commentsdsctoprod;
	global $cfg_dsctoglo;
	global $cfg_commentsdsctoglo;
	global $cfg_dsctovol;
	global $cfg_commentsdsctovol;
	global $cfg_aproxprice;
	global $cfg_commentsaproxprice;
	global $cfg_aproxpay;
	global $cfg_commentsaproxpay;
	global $cfg_especialmov;
	global $cfg_commentsespecialmov;
	global $cfg_creditsales;
	global $cfg_commentscreditsales;
	global $cfg_prepaysales;
	global $cfg_commentsprepaysales;
	global $cfg_quotesales;
	global $cfg_commentsquotesales;
	global $cfg_fracprod;
	global $cfg_commentsfracprod;
	global $cfg_domisales;
	global $cfg_commentsdomisales;
	global $cfg_salesman;
	global $cfg_commentssalesman;
	global $cfg_opencero;
	global $cfg_commentsopencero;
	global $cfg_supervisorkey;
	global $cfg_commentssupervisorkey;
	global $cfg_changeprice;
	global $cfg_commentschangeprice;
	global $cfg_validatecmt;
	global $cfg_commentsvalidatecmt;
	global $cfg_admonprinter;
	global $cfg_commentsadmonprinter;
	global $cfg_limitrecordview;
	global $cfg_commentslimitrecordview;
	global $cfg_ciiu;
	global $cfg_commentsciiu;
	global $cfg_tarifa_ciiu;
	global $cfg_commentstarifa_ciiu;
	global $cfg_tip_contrib;
	global $cfg_commentstip_contrib;
	global $cfg_autoretenedor;
	global $cfg_commentsautoretenedor;
	global $cfg_regnoventa;
	global $cfg_commentsregnoventa;
	global $cfg_searchproductcombo;
	global $cfg_commentssearchproductcombo;
	
	$formFields[0]=$cfg_company;
	$formFields[1]=$cfg_address;
	$formFields[2]=$cfg_phone;
	$formFields[3]=$cfg_email;
	$formFields[4]=$cfg_fax;
	$formFields[5]=$cfg_website;
	$formFields[6]=$cfg_other;
	$formFields[7]=$cfg_default_tax_rate;
	$formFields[8]=$cfg_currency_symbol;
	$formFields[9]=$cfg_numberForBarcode;
	$formFields[10]=$cfg_language;
	$formFields[11]=$cfg_res_fact;
	$formFields[12]=$cfg_company_nit;
	$formFields[13]=$cfg_fact_desde;
	$formFields[14]=$cfg_fac_hasta;
	$formFields[15]=$cfg_pref_fac;
	$formFields[16]=$cfg_start_balance;
	$formFields[17]=$cfg_turnjournal;
	$formFields[18]=$cfg_sucursal;  
	$formFields[19]=$cfg_companycomments;  
	$formFields[20]=$cfg_companynitcomments;  
	$formFields[21]=$cfg_sucursalcomments;  
	$formFields[22]=$cfg_companyAddresscomments;
	$formFields[23]=$cfg_companyPhonecomments;  
	$formFields[24]=$cfg_companyEmailcomments; 
	$formFields[25]=$cfg_companyFaxcomments; 
	$formFields[26]=$cfg_companyWebsitecomments; 
	$formFields[27]=$cfg_companyOthercomments; 
	$formFields[28]=$cfg_themeSelectedcomments; 
	$formFields[29]=$cfg_taxRatecomments; 
	$formFields[30]=$cfg_currencySymbolcomments;
	$formFields[31]=$cfg_numberForBarcodecomments;
	$formFields[32]=$cfg_languagecomments;
	$formFields[33]=$cfg_res_factcomments;
	$formFields[34]=$cfg_fact_desdecomments;
	$formFields[35]=$cfg_fac_hastacomments;
	$formFields[36]=$cfg_pref_faccomments;
	$formFields[37]=$cfg_start_balancecomments;
	$formFields[38]=$cfg_turnjournalcomments;
	$formFields[39]=$cfg_tckcodetype;
	$formFields[40]=$cfg_commentsttckcodetype;
	$formFields[41]=$cfg_footer1;
	$formFields[42]=$cfg_commentsfooter1;
	$formFields[43]=$cfg_footer2;
	$formFields[44]=$cfg_commentsfooter2;
	$formFields[45]=$cfg_footer3;
	$formFields[46]=$cfg_commentsfooter3;
	$formFields[47]=$cfg_header1;
	$formFields[48]=$cfg_commentsheader1;
	$formFields[49]=$cfg_header2;
	$formFields[50]=$cfg_commentsheader2;
	$formFields[51]=$cfg_header3;
	$formFields[52]=$cfg_commentsheader3;
	$formFields[53]=$cfg_promomgnt;
	$formFields[54]=$cfg_commentspromomgnt;
	$formFields[55]=$cfg_dsctoprod;
	$formFields[56]=$cfg_commentsdsctoprod;
	$formFields[57]=$cfg_dsctoglo;
	$formFields[58]=$cfg_commentsdsctoglo;
	$formFields[59]=$cfg_dsctovol;
	$formFields[60]=$cfg_commentsdsctovol;
	$formFields[61]=$cfg_aproxprice;
	$formFields[62]=$cfg_commentsaproxprice;
	$formFields[63]=$cfg_aproxpay;
	$formFields[64]=$cfg_commentsaproxpay;
	$formFields[65]=$cfg_especialmov;
	$formFields[66]=$cfg_commentsespecialmov;
	$formFields[67]=$cfg_creditsales;
	$formFields[68]=$cfg_commentscreditsales;
	$formFields[69]=$cfg_prepaysales;
	$formFields[70]=$cfg_commentsprepaysales;
	$formFields[71]=$cfg_quotesales;
	$formFields[72]=$cfg_commentsquotesales;
	$formFields[73]=$cfg_fracprod;
	$formFields[74]=$cfg_commentsfracprod;
	$formFields[75]=$cfg_domisales;
	$formFields[76]=$cfg_commentsdomisales;
	$formFields[77]=$cfg_salesman;
	$formFields[78]=$cfg_commentssalesman;
	$formFields[79]=$cfg_opencero;
	$formFields[80]=$cfg_commentsopencero;
	$formFields[81]=$cfg_supervisorkey;
	$formFields[82]=$cfg_commentssupervisorkey;
	$formFields[83]=$cfg_changeprice;
	$formFields[84]=$cfg_commentschangeprice;
	$formFields[85]=$cfg_validatecmt;
	$formFields[86]=$cfg_commentsvalidatecmt;
	$formFields[87]=$cfg_admonprinter;
	$formFields[88]=$cfg_commentsadmonprinter;
	$formFields[89]=$cfg_limitrecordview;
	$formFields[90]=$cfg_commentslimitrecordview;
	$formFields[91]=$cfg_ciiu;
	$formFields[92]=$cfg_commentsciiu;
	$formFields[93]=$cfg_tarifa_ciiu;
	$formFields[94]=$cfg_commentstarifa_ciiu;
	$formFields[95]=$cfg_tip_contrib;
	$formFields[96]=$cfg_commentstip_contrib;
	$formFields[97]=$cfg_autoretenedor;
	$formFields[98]=$cfg_commentsautoretenedor;
	$formFields[99]=$cfg_regnoventa;
	$formFields[100]=$cfg_commentsregnoventa;
	$formFields[101]=$cfg_searchproductcombo;
    $formFields[102]=$cfg_commentssearchproductcombo;
	return $formFields;
}


function displayUpdatePage($defaultValuesAsArray) 
{

global $hDisplay;
global $cfg_theme;
global $cfg_numberForBarcode;
global $dbf;

$themeRowColor1=$hDisplay->rowcolor1;
$themeRowColor2=$hDisplay->rowcolor2;
$lang=new language();

?>
<?php
echo "
<html>
<head>
</head>
<body>

<table border=\"0\" width=\"100%\">
  <tr>
    <td>
      <p align=\"left\"><img border=\"0\" src=\"../images/menubar/config.png\" width=\"55\" height=\"55\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->config</b></font><br>
      <br>
      <font face=\"Verdana\" size=\"2\">$lang->configurationWelcomeMessage</font></p>
      <div align=\"center\">
        <center>
        <form action=\"index.php\" method=\"post\">
        <div align=\"left\">
        <table border=\"0\" width=\"349\" bgcolor=\"#FFFFFF\">
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
             <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->vble</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
             <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->extendedPrice</b></font></p>
            </td>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->comments</b></font></p>
            </td>
          </tr>
		  <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->companyName</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyName\" size=\"29\" value=\"".$defaultValuesAsArray[0]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companycomments\" size=\"80\" value=\"".$defaultValuesAsArray[19]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
		  <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->companynit</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companynit\" size=\"29\" value=\"".$defaultValuesAsArray[12]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companynitcomments\" size=\"80\" value=\"".$defaultValuesAsArray[20]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->sucursal:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"sucursal\" id=\"sucursal\">";
           $customer_result=mysql_query("select pos_inventorylocation.id, pos_company.companyname  from pos_company, pos_inventorylocation where pos_company.id = pos_inventorylocation.companyid",$dbf->conn);
		while($row=mysql_fetch_assoc($customer_result))
		{
		     
			 $id=$row['id'];
		     $companyn=$row['companyname'];
			  echo '<option value="'.$id.'"';if(!(strcmp($id, $defaultValuesAsArray[18]))){echo $selected = "selected=\"selected\"";}echo '>'.$companyn.'</option>';
		//	 echo "<option value=$id>$companyn</option></center>";
		}
			 echo"</select>
			 </p>
            </td>
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"sucursalcomments\" size=\"80\" value=\"".$defaultValuesAsArray[21]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
		  <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->address:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><textarea name=\"companyAddress\" rows=\"4\" cols=\"26\" style=\"border-style: solid; border-width: 1\">$defaultValuesAsArray[1]</textarea></p>
            </td>
          
		  <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyAddresscomments\" size=\"80\" value=\"".$defaultValuesAsArray[22]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->phoneNumber:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyPhone\" size=\"29\" value=\"".$defaultValuesAsArray[2]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			 <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyPhonecomments\" size=\"80\" value=\"".$defaultValuesAsArray[23]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->email:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"companyEmail\" size=\"29\" value=\"".$defaultValuesAsArray[3]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyEmailcomments\" size=\"80\" value=\"".$defaultValuesAsArray[24]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
		  </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->fax:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyFax\" size=\"29\" value=\"".$defaultValuesAsArray[4]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyFaxcomments\" size=\"80\" value=\"".$defaultValuesAsArray[25]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
		  </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->website:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"companyWebsite\" size=\"29\" value=\"".$defaultValuesAsArray[5]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyWebsitecomments\" size=\"80\" value=\"".$defaultValuesAsArray[26]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
		  </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->other:</font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyOther\" size=\"29\" value=\"".$defaultValuesAsArray[6]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
           <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"companyOthercomments\" size=\"80\" value=\"".$defaultValuesAsArray[27]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
		  </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->theme:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><select size=\"1\" name=\"themeSelected\" style=\"border-style: solid; border-width: 1\">";

			  if($cfg_theme=='serious') 
			  {
				 	echo "
                	<option selected value=\"serious\">$lang->serious</option>
                	<option value=\"big blue\">$lang->bigBlue</option>
					";
			  }
			  elseif($cfg_theme=='big blue')
			  {
			  		echo "
			  		 <option selected value=\"big blue\">$lang->bigBlue</option>
			  		 <option value=\"serious\">$lang->serious</option>


					";
			  }

			echo "
              </select></p>
            </td>
			 <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"themeSelectedcomments\" size=\"80\" value=\"".$defaultValuesAsArray[28]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
          <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->taxRate:</b><br>
              &nbsp;<i>($lang->inPercent)</i></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"taxRate\" size=\"29\" value=\"".$defaultValuesAsArray[7]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"taxRatecomments\" size=\"80\" value=\"".$defaultValuesAsArray[29]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
            <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->currencySymbol:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><input type=\"text\" name=\"currencySymbol\" size=\"29\" value=\"".$defaultValuesAsArray[8]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"currencySymbolcomments\" size=\"80\" value=\"".$defaultValuesAsArray[30]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
            </tr>
        <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->barCodeMode:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><select size=\"1\" name=\"numberForBarcode\" style=\"border-style: solid; border-width: 1\">";	
			  if($cfg_numberForBarcode=='Row ID') 
			  {
				 	echo "
                	<option selected value=\"Row ID\">$lang->rowID</option>
                	<option value=\"Account/Item Number\">$lang->accountNumber/$lang->itemNumber</option>
					";
			  }
			  elseif($cfg_numberForBarcode=='Account/Item Number')
			  {
			  		echo "
                	 <option selected value=\"Account/Item Number\">$lang->accountNumber/$lang->itemNumber</option>
                	 <option value=\"Row ID\">$lang->rowID</option>
					";
			  }
			?>
              </select></p>
            </td>
            <? echo "<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"numberForBarcodecomments\" size=\"80\" value=\"".$defaultValuesAsArray[31]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>";
            ?>
          </tr>
     
           <tr>
        <td width="190" align="left" bgcolor=<?php echo "$themeRowColor2" ?>>
        <p align="center"><font face="Verdana" size="2"><b><?php echo $lang->language ?>:</b></font></td>
        <td width="242" align="center" bgcolor=<?php echo "$themeRowColor2" ?>>&nbsp;<font face="Verdana" size="5">
        <select name="language" style="border-style: solid; border-width: 1; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">
        
        <?php
        $temp_lang=ucfirst(substr($defaultValuesAsArray[10],0,strpos($defaultValuesAsArray[10],'.')));
 		echo "<option selected value='$defaultValuesAsArray[10]'>$temp_lang</option>";
        $handle = opendir('../language');
        	while (false !== ($file = readdir($handle))) 
 			{ 
    			if ($file {0}!='.' && $file!=$defaultValuesAsArray[10]) 
 				{ 
 					$temp_lang=ucfirst(substr($file,0,strpos($file,'.')));
      				echo "<option value='$file'>$temp_lang</option>"; 
    			} 
  			}
   	    	closedir($handle); 
 		
		?>
        
        </select></font></td>
      <? echo "<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"languagecomments\" size=\"80\" value=\"".$defaultValuesAsArray[32]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>";
      ?>
      </tr>
       <? echo"<tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->res_fact:</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
               <p align=\"center\"><textarea name=\"res_fact\" rows=\"1\" cols=\"26\" style=\"border-style: solid; border-width: 1\">$defaultValuesAsArray[11]</textarea></p>
            </td>
          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"res_factcomments\" size=\"80\" value=\"".$defaultValuesAsArray[33]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
		  </tr>
		  <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->fact_desde</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"fact_desde\" size=\"29\" value=\"".$defaultValuesAsArray[13]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          
		   <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"fact_desdecomments\" size=\"80\" value=\"".$defaultValuesAsArray[34]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>
		  <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->fac_hasta</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"fac_hasta\" size=\"29\" value=\"".$defaultValuesAsArray[14]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          
		  <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"fac_hastacomments\" size=\"80\" value=\"".$defaultValuesAsArray[35]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>
		  <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->pref_fac</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"pref_fac\" size=\"29\" value=\"".$defaultValuesAsArray[15]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
         
		   <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"pref_faccomments\" size=\"80\" value=\"".$defaultValuesAsArray[36]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
				</tr>
		   <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->start_balance</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"start_balance\" size=\"29\" value=\"".$defaultValuesAsArray[16]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"start_balancecomments\" size=\"80\" value=\"".$defaultValuesAsArray[37]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>
		   <tr>
            <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->turnjournal</b></font></p>
            </td>
            <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"turnjournal\" size=\"29\" value=\"".$defaultValuesAsArray[17]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"turnjournalcomments\" size=\"80\" value=\"".$defaultValuesAsArray[38]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
          </tr>";
          ////////////////  
		  echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->tckcodetype:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"tckcodetype\" id=\"tckcodetype\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[39]))){echo $selected = "selected=\"selected\"";}echo '>Plu</option>';
			 echo '<option value="2"';if(!(strcmp(2, $defaultValuesAsArray[39]))){echo $selected = "selected=\"selected\"";}echo '>Barcode</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsttckcodetype\" size=\"80\" value=\"".$defaultValuesAsArray[40]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			 <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->footer1</b></font></p>
            </td>
		          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"footer1\" size=\"80\" value=\"".$defaultValuesAsArray[41]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsfooter1\" size=\"80\" value=\"".$defaultValuesAsArray[42]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			 <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->footer2</b></font></p>
            </td>
		          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"footer2\" size=\"80\" value=\"".$defaultValuesAsArray[43]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsfooter2\" size=\"80\" value=\"".$defaultValuesAsArray[44]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			 <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->footer3</b></font></p>
            </td>
		          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"footer3\" size=\"80\" value=\"".$defaultValuesAsArray[45]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsfooter3\" size=\"80\" value=\"".$defaultValuesAsArray[46]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			 <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->header1</b></font></p>
            </td>
		          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"header1\" size=\"80\" value=\"".$defaultValuesAsArray[47]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsheader1\" size=\"80\" value=\"".$defaultValuesAsArray[48]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			 <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->header2</b></font></p>
            </td>
		          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"header1\" size=\"80\" value=\"".$defaultValuesAsArray[49]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsheader2\" size=\"80\" value=\"".$defaultValuesAsArray[50]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			 <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\"><b>$lang->header3</b></font></p>
            </td>
		          <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"header3\" size=\"80\" value=\"".$defaultValuesAsArray[51]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsheader3\" size=\"80\" value=\"".$defaultValuesAsArray[52]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->promomgnt:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"promomgnt\" id=\"promomgnt\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[53]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[53]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentspromomgnt\" size=\"80\" value=\"".$defaultValuesAsArray[54]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
				echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->dsctoprod:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"dsctoprod\" id=\"dsctoprod\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[55]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[55]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"dsctoglo\" size=\"80\" value=\"".$defaultValuesAsArray[56]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->dsctoglo:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"dsctoglo\" id=\"dsctoglo\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[57]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[57]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsdsctoglo\" size=\"80\" value=\"".$defaultValuesAsArray[58]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->dsctovol:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"dsctovol\" id=\"dsctovol\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[59]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[59]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsdsctovol\" size=\"80\" value=\"".$defaultValuesAsArray[60]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->aproxprice:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"aproxprice\" id=\"aproxprice\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[61]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[61]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsaproxprice\" size=\"80\" value=\"".$defaultValuesAsArray[62]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->aproxpay:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"aproxpay\" id=\"aproxpay\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[63]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[63]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsaproxpay\" size=\"80\" value=\"".$defaultValuesAsArray[64]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->especialmov:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"especialmov\" id=\"especialmov\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[65]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[65]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsespecialmov\" size=\"80\" value=\"".$defaultValuesAsArray[66]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->creditsales:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"creditsales\" id=\"creditsales\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[67]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[67]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentscreditsales\" size=\"80\" value=\"".$defaultValuesAsArray[68]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->prepaysales:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"prepaysales\" id=\"prepaysales\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[69]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[69]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsprepaysales\" size=\"80\" value=\"".$defaultValuesAsArray[70]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->quotesales:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"prepaysales\" id=\"prepaysales\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[71]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[71]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsquotesales\" size=\"80\" value=\"".$defaultValuesAsArray[72]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->fracprod:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"fracprod\" id=\"fracprod\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[73]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[73]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsfracprod\" size=\"80\" value=\"".$defaultValuesAsArray[74]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
				echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->domisales:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"domisales\" id=\"domisales\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[75]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[75]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsdomisales\" size=\"80\" value=\"".$defaultValuesAsArray[76]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->salesman:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"salesman\" id=\"salesman\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[77]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[77]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentssalesman\" size=\"80\" value=\"".$defaultValuesAsArray[78]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->opencero:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"opencero\" id=\"opencero\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[79]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[79]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsopencero\" size=\"80\" value=\"".$defaultValuesAsArray[80]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->supervisorkey:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"supervisorkey\" id=\"supervisorkey\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[81]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[81]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentssupervisorkey\" size=\"80\" value=\"".$defaultValuesAsArray[82]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->changeprice:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"changeprice\" id=\"changeprice\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[83]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[83]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentschangeprice\" size=\"80\" value=\"".$defaultValuesAsArray[84]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->validatecmt:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"validatecmt\" id=\"validatecmt\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[85]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[85]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsvalidatecmt\" size=\"80\" value=\"".$defaultValuesAsArray[86]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->admonprinter:</font></p>
            </td>
		   <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"admonprinter\" size=\"80\" value=\"".$defaultValuesAsArray[87]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsadmonprinter\" size=\"80\" value=\"".$defaultValuesAsArray[88]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->limitrecordview:</font></p>
            </td>
		   <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"limitrecordview\" size=\"80\" value=\"".$defaultValuesAsArray[89]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentslimitrecordview\" size=\"80\" value=\"".$defaultValuesAsArray[90]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->ciiu:</font></p>
            </td>
		   <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"ciiu\" size=\"80\" value=\"".$defaultValuesAsArray[91]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsciiu\" size=\"80\" value=\"".$defaultValuesAsArray[92]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->tarifa_ciiu:</font></p>
            </td>
		   <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"tarifa_ciiu\" size=\"80\" value=\"".$defaultValuesAsArray[93]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentstarifa_ciiu\" size=\"80\" value=\"".$defaultValuesAsArray[94]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->tip_contrib:</font></p>
            </td>
		   <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"tip_contrib\" id=\"tip_contrib\">";
           	 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[95]))){echo $selected = "selected=\"selected\"";}echo '>Regimen comun</option>';
			 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[95]))){echo $selected = "selected=\"selected\"";}echo '>Regimen Simplificado</option>';
			 echo '<option value="2"';if(!(strcmp(2, $defaultValuesAsArray[95]))){echo $selected = "selected=\"selected\"";}echo '>Gran Contribuyente</option>';
					 echo"</select>
			 </p>
            </td>			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentstip_contrib\" size=\"80\" value=\"".$defaultValuesAsArray[96]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->autoretenedor:</font></p>
            </td>
		  <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"autoretenedor\" id=\"autoretenedor\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[97]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[97]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>	
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsautoretenedor\" size=\"80\" value=\"".$defaultValuesAsArray[98]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
			<td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->regnoventa:</font></p>
            </td>
		   <td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><select  name=\"regnoventa\" id=\"regnoventa\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[99]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[99]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select></p>
            </td>			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentsregnoventa\" size=\"80\" value=\"".$defaultValuesAsArray[100]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
			echo "<tr>
		          <td width=\"122\" align=\"left\" bgcolor=\"$themeRowColor2\">
              <p align=\"center\"><font face=\"Verdana\" size=\"2\">$lang->search_product_combo:</font></p>
            </td>
             <td width=\"214\" bgcolor=\"$themeRowColor2\">
            <p align=\"center\"><select  name=\"searchproductcombo\" id=\"searchproductcombo\">";
           	 echo '<option value="1"';if(!(strcmp(1, $defaultValuesAsArray[101]))){echo $selected = "selected=\"selected\"";}echo '>Si</option>';
			 echo '<option value="0"';if(!(strcmp(0, $defaultValuesAsArray[101]))){echo $selected = "selected=\"selected\"";}echo '>No</option>';
					 echo"</select>
			 </p>
            </td>
			
			<td width=\"214\" bgcolor=\"$themeRowColor1\">
              <p align=\"center\"><input type=\"text\" name=\"commentssearchproductcombo\" size=\"80\" value=\"".$defaultValuesAsArray[102]."\" style=\"border-style: solid; border-width: 1\"></p>
            </td>
			</tr>";
		  //////////////7
        echo "</table>
        </div>
        </center>
        <p align=\"left\">
        <input type=\"submit\" name=\"submitChanges\" style=\"border-style: solid; border-width: 1\"><Br>
        </form>
      </div>
    </td>
  </tr>
</table>
</body>
</html>";

}

function updateSettings($companyname,$companyaddress,$companyphone,$companyemail,$companyfax,$companywebsite,$companyother,$theme,$taxrate,$currencySymbol,$numberForBarcode,$language,$res_fact,$companynit,$fact_desde,$fac_hasta,$pref_fac,$start_balance,$turnjournal,$sucursal,$companycomments,$companynitcomments,$sucursalcomments,$companyAddresscomments,$companyPhonecomments,$companyEmailcomments,$companyFaxcomments,$companyWebsitecomments,$companyOthercomments,$themeSelectedcomments,$taxRatecomments,$currencySymbolcomments,$numberForBarcodecomments,$languagecomments,$res_factcomments,$fact_desdecomments,$fac_hastacomments,$pref_faccomments,$start_balancecomments,$turnjournalcomments,$tckcodetype,$commentsttckcodetype,$footer1,$commentsfooter1,$footer2,$commentsfooter2,$footer3,$commentsfooter3,$header1,$commentsheader1,$header2,$commentsheader2,$header3,$commentsheader3,$promomgnt,$commentspromomgnt,$dsctoprod,$commentsdsctoprod,$dsctoglo,$commentsdsctoglo,$dsctovol,$commentsdsctovol,$aproxprice,$commentsaproxprice,$aproxpay,$commentsaproxpay,$especialmov,$commentsespecialmov,$creditsales,$commentscreditsales,$prepaysales,$commentsprepaysales,$quotesales,$commentsquotesales,$fracprod,$commentsfracprod,$domisales,$commentsdomisales,$salesman,$commentssalesman,$opencero,$commentsopencero,$supervisorkey,$commentssupervisorkey,$changeprice,$commentschangeprice,$validatecmt,$commentsvalidatecmt,$admonprinter,$commentsadmonprinter,$limitrecordview,$commentslimitrecordview,$ciiu,$commentsciiu,$tarifa_ciiu,$commentstarifa_ciiu,$tip_contrib,$commentstip_contrib,$autoretenedor,$commentsautoretenedor,$regnoventa,$commentsregnoventa,$searchproductcombo,$commentssearchproductcombo) {
 
include("../settings.php");
$lang=new language();
$writeConfigurationFile="<?php
 define(DB_TYPE,'mysql');
 define(DB_SERVER,\"$cfg_server\");
 define(DB_SERVER_USERNAME,\"$cfg_username\");
 define(DB_SERVER_PASSWORD,\"$cfg_password\");
 define(DB_DATABASE,\"$cfg_database\");


\$cfg_company=\"$companyname\";
\$cfg_address=\"$companyaddress\";
\$cfg_phone=\"$companyphone\";
\$cfg_email=\"$companyemail\";
\$cfg_fax=\"$companyfax\";
\$cfg_website=\"$companywebsite\";
\$cfg_other=\"$companyother\";
\$cfg_server=DB_SERVER;
\$cfg_database=DB_DATABASE;
\$cfg_username=DB_SERVER_USERNAME;
\$cfg_password=DB_SERVER_PASSWORD;
\$cfg_tableprefix=\"$cfg_tableprefix\";
\$cfg_default_tax_rate=\"$taxrate\";
\$cfg_currency_symbol=\"$currencySymbol\";
\$cfg_theme=\"$theme\";
\$cfg_numberForBarcode=\"$numberForBarcode\";
\$cfg_language=\"$language\";
\$cfg_res_fact=\"$res_fact\";
\$cfg_company_nit=\"$companynit\";
\$cfg_fact_desde=\"$fact_desde\";
\$cfg_fac_hasta=\"$fac_hasta\";
\$cfg_pref_fac=\"$pref_fac\";
\$cfg_start_balance=\"$start_balance\";
\$cfg_turnjournal=\"$turnjournal\";  
\$cfg_sucursal=\"$sucursal\";
\$cfg_companycomments=\"$companycomments\";
\$cfg_companynitcomments=\"$companynitcomments\";
\$cfg_sucursalcomments=\"$sucursalcomments\";
\$cfg_companyAddresscomments=\"$companyAddresscomments\";
\$cfg_companyPhonecomments=\"$companyPhonecomments\";
\$cfg_companyEmailcomments=\"$companyEmailcomments\";
\$cfg_companyFaxcomments=\"$companyFaxcomments\";
\$cfg_companyWebsitecomments=\"$companyWebsitecomments\";
\$cfg_companyOthercomments=\"$companyOthercomments\";
\$cfg_themeSelectedcomments=\"$themeSelectedcomments\";
\$cfg_taxRatecomments=\"$taxRatecomments\";
\$cfg_currencySymbolcomments=\"$currencySymbolcomments\";
\$cfg_numberForBarcodecomments=\"$numberForBarcodecomments\";
\$cfg_languagecomments=\"$languagecomments\";
\$cfg_res_factcomments=\"$res_factcomments\";
\$cfg_fact_desdecomments=\"$fact_desdecomments\";
\$cfg_fac_hastacomments=\"$fac_hastacomments\";
\$cfg_pref_faccomments=\"$pref_faccomments\";
\$cfg_start_balancecomments=\"$start_balancecomments\";
\$cfg_turnjournalcomments=\"$turnjournalcomments\";
\$cfg_tckcodetype=\"$tckcodetype\";
\$cfg_commentsttckcodetype=\"$commentsttckcodetype\";
\$cfg_footer1=\"$footer1\";
\$cfg_commentsfooter1=\"$commentsfooter1\";
\$cfg_footer2=\"$footer2\";
\$cfg_commentsfooter2=\"$commentsfooter2\";
\$cfg_footer3=\"$footer3\";
\$cfg_commentsfooter3=\"$commentsfooter3\";
\$cfg_header1=\"$header1\";
\$cfg_commentsheader1=\"$commentsheader1\";
\$cfg_header2=\"$header2\";
\$cfg_commentsheader2=\"$commentsheader2\";
\$cfg_header3=\"$header3\";
\$cfg_commentsheader3=\"$commentsheader3\";
\$cfg_promomgnt=\"$promomgnt\";
\$cfg_commentspromomgnt=\"$commentspromomgnt\";
\$cfg_dsctoprod=\"$dsctoprod\";
\$cfg_commentsdsctoprod=\"$commentsdsctoprod\";
\$cfg_dsctoglo=\"$dsctoglo\";
\$cfg_commentsdsctoglo=\"$commentsdsctoglo\";
\$cfg_dsctovol=\"$dsctovol\";
\$cfg_commentsdsctovol=\"$commentsdsctovol\";
\$cfg_aproxprice=\"$aproxprice\";
\$cfg_commentsaproxprice=\"$commentsaproxprice\";
\$cfg_aproxpay=\"$aproxpay\";
\$cfg_commentsaproxpay=\"$commentsaproxpay\";
\$cfg_especialmov=\"$especialmov\";
\$cfg_commentsespecialmov=\"$commentsespecialmov\";
\$cfg_creditsales=\"$creditsales\";
\$cfg_commentscreditsales=\"$commentscreditsales\";
\$cfg_prepaysales=\"$prepaysales\";
\$cfg_commentsprepaysales=\"$commentsprepaysales\";
\$cfg_quotesales=\"$quotesales\";
\$cfg_commentsquotesales=\"$commentsquotesales\";
\$cfg_fracprod=\"$fracprod\";
\$cfg_commentsfracprod=\"$commentsfracprod\";
\$cfg_domisales=\"$domisales\";
\$cfg_commentsdomisales=\"$commentsdomisales\";
\$cfg_salesman=\"$salesman\";
\$cfg_commentssalesman=\"$commentssalesman\";
\$cfg_opencero=\"$opencero\";
\$cfg_commentsopencero=\"$commentsopencero\";
\$cfg_supervisorkey=\"$supervisorkey\";
\$cfg_commentssupervisorkey=\"$commentssupervisorkey\";
\$cfg_changeprice=\"$changeprice\";
\$cfg_commentschangeprice=\"$commentschangeprice\";
\$cfg_validatecmt=\"$validatecmt\";
\$cfg_commentsvalidatecmt=\"$commentsvalidatecmt;\";
\$cfg_admonprinter=\"$admonprinter\";
\$cfg_commentsadmonprinter=\"$commentsadmonprinter\";
\$cfg_limitrecordview=\"$limitrecordview\";
\$cfg_commentslimitrecordview=\"$commentslimitrecordview\";
\$cfg_ciiu=\"$ciiu\";
\$cfg_commentsciiu=\"$commentsciiu\";
\$cfg_tarifa_ciiu=\"$tarifa_ciiu\";
\$cfg_commentstarifa_ciiu=\"$commentstarifa_ciiu\";
\$cfg_tip_contrib=\"$tip_contrib\";
\$cfg_commentstip_contrib=\"$commentstip_contrib\";
\$cfg_autoretenedor=\"$autoretenedor\";
\$cfg_commentsautoretenedor=\"$commentsautoretenedor\";
\$cfg_regnoventa=\"$regnoventa\";
\$cfg_commentsregnoventa=\"$commentsregnoventa\";
\$cfg_searchproductcombo=\"$searchproductcombo\";
\$cfg_commentssearchproductcombo=\"$commentssearchproductcombo\";
//VARIABLE QUE ME INDICA EL LOCATIONID DEL ALMACEN DONDE ESTA UBICADO EL POS
\$cfg_locationid = '4';
define('DISTRI_VTA',0);

if(!\$style){
?>
<style>
body {
    text-transform: uppercase;
}
table{
   text-transform: uppercase; 
}
input{
   text-transform: uppercase; 
}
</style>
<?php }
?>";	
        
	@unlink("../settings.php");
	$hWriteConfiguration = @fopen("../settings.php", "w+" ) or die ("<br><center><img src='config_updated_failed.gif'><br><br><b>$lang->configUpdatedUnsucessfully</b></center>");
	fputs( $hWriteConfiguration, $writeConfigurationFile);
	fclose( $hWriteConfiguration );
}

// --------------------- Code starts here -----------------------//
$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$hDisplay=new display($dbf,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

if(isset($_POST['submitChanges'])) {
	if($_POST['companyName']!="" && $_POST['companyPhone']!="" && $_POST['taxRate']!="" && $_POST['currencySymbol']!="") 
	{
		
		updateSettings($_POST['companyName'],$_POST['companyAddress'],$_POST['companyPhone'],
			$_POST['companyEmail'],$_POST['companyFax'],$_POST['companyWebsite'],$_POST['companyOther'],$_POST['themeSelected'],$_POST['taxRate'],$_POST['currencySymbol'],$_POST['numberForBarcode'],$_POST['language'],$_POST['res_fact'],$_POST['companynit'],$_POST['fact_desde'],$_POST['fac_hasta'],$_POST['pref_fac'],$_POST['start_balance'],$_POST['turnjournal'],$_POST['sucursal'],$_POST['companycomments'],$_POST['companynitcomments'],$_POST['sucursalcomments'],$_POST['companyAddresscomments'],$_POST['companyPhonecomments'],$_POST['companyEmailcomments'],$_POST['companyFaxcomments'],$_POST['companyWebsitecomments'],$_POST['companyOthercomments'],$_POST['themeSelectedcomments'],$_POST['taxRatecomments'],$_POST['currencySymbolcomments'],$_POST['numberForBarcodecomments'],$_POST['languagecomments'],$_POST['res_factcomments'],$_POST['fact_desdecomments'],$_POST['fac_hastacomments'],$_POST['pref_faccomments'],$_POST['start_balancecomments'],$_POST['turnjournalcomments'],$_POST['tckcodetype'],$_POST['commentsttckcodetype'],$_POST['footer1'],$_POST['commentsfooter1'],$_POST['footer2'],$_POST['commentsfooter2'],$_POST['footer3'],$_POST['commentsfooter3'],$_POST['header1'],$_POST['commentsheader1'],$_POST['header2'],$_POST['commentsheader2'],$_POST['header3'],$_POST['commentsheader3'],$_POST['promomgnt'],$_POST['commentspromomgnt'],$_POST['dsctoprod'],$_POST['commentsdsctoprod'],$_POST['dsctoglo'],$_POST['commentsdsctoglo'],$_POST['dsctovol'],$_POST['commentsdsctovol'],$_POST['aproxprice'],$_POST['commentsaproxprice'],$_POST['aproxpay'],$_POST['commentsaproxpay'],$_POST['especialmov'],$_POST['commentsespecialmov'],$_POST['creditsales'],$_POST['commentscreditsales'],$_POST['prepaysales'],$_POST['commentsprepaysales'],$_POST['quotesales'],$_POST['commentsquotesales'],$_POST['fracprod'],$_POST['commentsfracprod'],$_POST['domisales'],$_POST['commentsdomisales'],$_POST['salesman'],$_POST['commentssalesman'],$_POST['opencero'],$_POST['commentsopencero'],$_POST['supervisorkey'],$_POST['commentssupervisorkey'],$_POST['changeprice'],$_POST['commentschangeprice'],$_POST['validatecmt'],$_POST['commentsvalidatecmt'],$_POST['admonprinter'],$_POST['commentsadmonprinter'],$_POST['limitrecordview'],$_POST['commentslimitrecordview'],$_POST['ciiu'],$_POST['commentsciiu'],$_POST['tarifa_ciiu'],$_POST['commentstarifa_ciiu'],$_POST['tip_contrib'],$_POST['commentstip_contrib'],$_POST['autoretenedor'],$_POST['commentsautoretenedor'],$_POST['regnoventa'],$_POST['commentsregnoventa'],$_POST['searchproductcombo'],$_POST['commentssearchproductcombo']);     
			 
		echo "<br><center><img src='config_updated_ok.gif'><br><br><b>$lang->configUpdatedSuccessfully</b></center>";
	} 
		else 
	{
		echo "$lang->forgottenFields";
	}
} 
elseif (isset($_POST['cancelChanges'])) 
{
	header("Location: ../home.php");
} 
else 
{
	displayUpdatePage(getFormFields());
}

$dbf->closeDBlink();


?>

