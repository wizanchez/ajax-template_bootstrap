<?php   session_start(); 
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
  header("Content-type: application/xhtml+xml");
}
else {
  header("Content-type: text/html");
}
?>
<? 
include ("settings.php");
include ("Connections/conexion.php");
include ("classes/security_functions.php");
include ("classes/db_functions.php");
/*include ("classes/display.php");
*/

$b = $_GET['b'];
$c = $_GET['c'];
$d = $_GET['d'];
  
  if($c == 1)
    {
	 $a = 0;
	 $rc_posus=mysql_query('SELECT * FROM pos_users WHERE username="'.$d.'" and key2 = "'.$b.'"',$conn_2);
     $row=mysql_fetch_assoc($rc_posus);
	 
     /*if($row['id'] != "") 
	   {
	    $a = 1; 
	   $rc_usertyp=mysql_query('SELECT * FROM pos_users WHERE id="'.$row['id'].'" and type ="Supervisor" ',$conn_2);
	   $row2=mysql_fetch_assoc($rc_usertyp);
	    if($row2['id'] != "") $a = 2;  else $a = 3;  
	   }*/  //else  { $a = 0;  }
    echo '<item>
          <valsuperv>'.$a.'</valsuperv>
          </item>'; 
   }
   if($c == 2)
     {
	      $rc_posus=mysql_query('SELECT * FROM pos_users WHERE username="'.$a.'" and key2 = "'.$b.'"',$conn_2);
	 $row=mysql_fetch_assoc($rc_posus);
     if($row['id'] != "") 
	   {
	    $a = 1; 
	   } else $a = 0; 
    echo '<item>
          <valsuperv>'.$a.'</valsuperv>
          </item>'; 
	 
	 }		  
 ?>