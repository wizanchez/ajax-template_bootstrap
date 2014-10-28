<?php
	define(DB_TYPE,'mysql');
	//define(DB_SERVER,'191.168.0.56');
	define(DB_SERVER,'localhost');
	define(DB_SERVER_USERNAME,'root');
	//define(DB_SERVER_PASSWORD,'kerberos');
	define(DB_SERVER_PASSWORD,'');
	define(DB_DATABASE,'jvmcompa_posweb_1');

										
										#############################################################################################
										##	NUMERO DE LA BODEGA EN CUESSTION
											define(LOCATION_ID,11);
											
										#############################################################################################
										##	NOMBRE DE LA BODEGA
											define(LOCATION_NOMBRE,'Farmacia Pasto');
										
										#############################################################################################
										##	PREFIJO DE LA BODEGA
											define(PREFIJO_BODEGA,'AT');
										
										#############################################################################################
										##	PREFIJO DE LA BODEGA
											define(DIRECCION_BODEGA,'Calle 18 3e-24');
										
$cfg_company="COOEMSSANAR SF";
$cfg_address=DIRECCION_BODEGA;
$cfg_phone="XXX XXXXXX";
$cfg_email="";
$cfg_fax="XXX XXXXXX";
$cfg_website="";
$cfg_other="";
$cfg_server=DB_SERVER;
$cfg_database=DB_DATABASE;
$cfg_username=DB_SERVER_USERNAME;
$cfg_password=DB_SERVER_PASSWORD;
$cfg_tableprefix="pos_";
$cfg_default_tax_rate="0";
$cfg_currency_symbol="$";
$cfg_theme="serious";
$cfg_numberForBarcode="Row ID";
$cfg_language="spanish.php";
$cfg_res_fact="140000033287 del 16 de diciembre de 2010";
$cfg_company_nit="900062612-8";
$cfg_fact_desde="42058";
$cfg_fac_hasta="100000";
$cfg_start_balance="";
$cfg_turnjournal="";  
$cfg_sucursal="";
$cfg_companycomments="";
$cfg_companynitcomments="";
$cfg_sucursalcomments="";
$cfg_companyAddresscomments="";
$cfg_companyPhonecomments="";
$cfg_companyEmailcomments="";
$cfg_companyFaxcomments="";
$cfg_companyWebsitecomments="";
$cfg_companyOthercomments="";
$cfg_themeSelectedcomments="";
$cfg_taxRatecomments="";
$cfg_currencySymbolcomments="";
$cfg_numberForBarcodecomments="";
$cfg_languagecomments="";
$cfg_res_factcomments="";
$cfg_fact_desdecomments="";
$cfg_fac_hastacomments="";
$cfg_pref_faccomments="";
$cfg_start_balancecomments="";
$cfg_turnjournalcomments="";
$cfg_tckcodetype="1";
$cfg_commentsttckcodetype="";
$cfg_footer1="";
$cfg_commentsfooter1="";
$cfg_footer2="";
$cfg_commentsfooter2="";
$cfg_footer3="";
$cfg_commentsfooter3="";
$cfg_header1="";
$cfg_commentsheader1="";
$cfg_header2="";
$cfg_commentsheader2="";
$cfg_header3="";
$cfg_commentsheader3="";
$cfg_promomgnt="1";
$cfg_commentspromomgnt="";
$cfg_dsctoprod="1";
$cfg_commentsdsctoprod="";
$cfg_dsctoglo="1";
$cfg_commentsdsctoglo="";
$cfg_dsctovol="1";
$cfg_commentsdsctovol="";
$cfg_aproxprice="1";
$cfg_commentsaproxprice="";
$cfg_aproxpay="1";
$cfg_commentsaproxpay="";
$cfg_especialmov="1";
$cfg_commentsespecialmov="";
$cfg_creditsales="1";
$cfg_commentscreditsales="";
$cfg_prepaysales="1";
$cfg_commentsprepaysales="";
$cfg_quotesales="";
$cfg_commentsquotesales="";
$cfg_fracprod="0";
$cfg_commentsfracprod="";
$cfg_domisales="1";
$cfg_commentsdomisales="";
$cfg_salesman="1";
$cfg_commentssalesman="";
$cfg_opencero="1";
$cfg_commentsopencero="";
$cfg_supervisorkey="1";
$cfg_commentssupervisorkey="";
$cfg_changeprice="1";
$cfg_commentschangeprice="";
$cfg_validatecmt="1";
$cfg_commentsvalidatecmt=";;;;;;;;";
$cfg_admonprinter="";
$cfg_commentsadmonprinter="";
$cfg_limitrecordview="";
$cfg_commentslimitrecordview="";
$cfg_ciiu="";
$cfg_commentsciiu="";
$cfg_tarifa_ciiu="";
$cfg_commentstarifa_ciiu="";
$cfg_tip_contrib="2";
$cfg_commentstip_contrib="";
$cfg_autoretenedor="1";
$cfg_commentsautoretenedor="";
$cfg_regnoventa="1";
$cfg_commentsregnoventa="";
$cfg_searchproductcombo="0";
$cfg_commentssearchproductcombo="";
$cfg_server=DB_SERVER;
$cfg_database=DB_DATABASE;
$cfg_username=DB_SERVER_USERNAME;
$cfg_password=DB_SERVER_PASSWORD;
$cfg_pref_fac=PREFIJO_BODEGA;
//-----------------------------------------------------------------------

//VARIABLE QUE ME INDICA EL LOCATIONID DEL ALMACEN DONDE ESTA UBICADO EL POS
									

$cfg_locationid = LOCATION_ID;
define('DISTRI_VTA',0);
									

if(!$style){
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
<?php 
}?>
