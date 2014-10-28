<?php
/* 
V1.71 18 Jan 2001 (c) 2000, 2001 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. 
  Set tabs to 4 for best viewing.
    
  Latest version is available at http://php.weblogs.com/
*/

error_reporting(63);
include_once('adodb-pear.inc.php');
include_once('tohtml.inc.php');
session_register('curr_page');

$db = NewADOConnection('mysql');
$db->debug = true;
//$db->Connect('localhost:4321','scott','tiger','natsoft.domain');
$db->Connect('localhost','root','','xphplens');

$num_of_rows_per_page = 7;
$sql = "select * from adoxyz ";

if (isset($HTTP_GET_VARS['next_page']))
	$curr_page = $HTTP_GET_VARS['next_page'];
if (empty($curr_page)) $curr_page = 1; ## at first page

$rs = $db->PageExecute($sql, $num_of_rows_per_page, $curr_page);
if (!$rs) die('Query Failed');

if (!$rs->EOF && (!$rs->AtFirstPage() || !$rs->AtLastPage())) {
	if (!$rs->AtFirstPage()) {
?>
<a href="<?php echo $PHP_SELF,'?next_page=',$rs->AbsolutePage() - 1 ?>">Previous page</a>
<?php
	}
	if (!$rs->AtLastPage()) {
?>
<a href="<?php echo $PHP_SELF,'?next_page=',$rs->AbsolutePage() + 1 ?>">Next page</a>
<?php
	}
	rs2html($rs);
}


?>
