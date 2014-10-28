<?php session_start();
$style = true;
include ("settings.php");
include ("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");

//create two objects that are needed in this script.
$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);

if(isset($_POST['username']) and isset($_POST['password']))
{
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	 
		if($sec->checkLogin($username,$password))
		{
		 	$_SESSION['session_user_id'] = $dbf->getUserID($username,$password);
			header ("location: index.php");
		}
	    else
	    {
	  	 	$valid_error = "$lang->usernameOrPasswordIncorrect";
            //echo "<center><b>$lang->usernameOrPasswordIncorrect</b></center>";
		}
}

if($sec->isLoggedIn())
{
	header ("Location: index.php");	
}

$dbf->closeDBlink();

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="css/login.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>POS Web - JVM Company Soft <?php
echo $lang->login_login;
?></title>
<script src="js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>
</head>
<body style="margin: 0px 0px 0px 0px;">
<div style="background-image:url(<?php echo 'images/fondofondo_2.jpg';?>);height: 84px;">

</div>
<div >
    <img src="<?php echo 'images/jvmlogo.png';?>" border="0"  align="center"/>
</div>
<form action="login.php" method="post" name="Login">
<div id="container">
<?php
if($valid_error){?>
    <div class="error" align="center"><?php    echo $valid_error;    ?>    </div>     <?php 	}    ?>

<?php /*?>	<div id="topo" class="TexTitulo_login topo">	<?php echo $lang->login_login; ?> 	</div>
        <div id="login_form" class="login_form_carbom"> 
            <div id="welcome_message"> <?php echo $lang->loginWelcomeMessage ?>	</div>
            <div class="form_field_label"><?php echo $lang->username; ?>: </div>
            <div class="form_field"> <input type="text" name="username" id="username" size="20" ></div>
            <div class="form_field_label"><?php echo $lang->password; ?>: </div>
            <div class="form_field"> <input type="password" name="password" size="20" >	</div>
            <div id="submit_button"> <input type="submit" value="<?php echo $lang->go ?>" class="display_naranja"> </div>
        </div>
	</div>
<?php */?>    

    <table width="400" border="0" align="center">
    	<tr>
            <td colspan="4" id="topo" class="TexTitulo_login topo"><?php echo $lang->login_login; ?><br> <span style="color:yellow;"><?PHp echo strtoupper(LOCATION_NOMBRE);?></span></td>
        </tr>
            <td>
        	    <table width="100%" border="0"  id="login_form" class="login_form_carbom" align="center">
            		<tr >
			            <td colspan="4"><?php echo $lang->loginWelcomeMessage ?></td>
                    </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td><?php echo $lang->username; ?>:</td>
                        <td><input type="text" name="username" id="username" size="20"  style="color:#069"></td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td><?php echo $lang->password; ?>: </td>
                        <td><input type="password" name="password" size="20" style="color:#069" >	</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><input type="submit" value="<?php echo $lang->go?>" class="display_naranja"  height="50"> </td>
                        <td>&nbsp;</td>
                  </tr>
                  <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>&nbsp;</td>
                  </tr>
               </table>
           </td>
       <tr>
       </tr>
       <tr>
          <td colspan="4"class="jvm_link">Copyright © 2014, Desarrollado por jvmcompany.com</td>
       </tr>
	</table>

</form>
</BODY>
</HTML>