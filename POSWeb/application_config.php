<?
	include_once 'setup/config.php';
	$prefix = $pnconfig['prefix'];
	$dbtype = $pnconfig['dbtype'];
	$dbhost = $pnconfig['dbhost'];
	$dbuname = $pnconfig['dbuname'];
	$dbpass = $pnconfig['dbpass'];
	$dbname = $pnconfig['dbname'];
	$system = $pnconfig['system'];
	$encoded = $pnconfig['encoded'];   

	$http_server = $pnconfig['http_server'];
	$dir_admin = $pnconfig['dir_admin'];
	$dir_catalog = $pnconfig['dir_catalog'];
	$dir_oserp = $pnconfig['dir_oserp'];
	$image_upload = $pnconfig['image_upload'];
$http_server_catalog = $http_server.$dir_catalog; 
// define our database connection
  define('DB_SERVER', $dbhost);
  define('DB_SERVER_USERNAME', $dbuname);
  define('DB_SERVER_PASSWORD', $dbpass);
  define('DB_DATABASE', $dbname);
  define('USE_PCONNECT', 1);
  define('DB_TYPE', $dbtype);
// define our webserver variables
// FS = Filesystem (physical)
// WS = Webserver (virtual)
  define('HTTP_SERVER', $http_server);
  define('HTTP_SERVER_CATALOG', $http_server_catalog);
  define('DIR_FS_DOCUMENT_ROOT', $DOCUMENT_ROOT . '/'); // where your pages are located on the server.. needed to delete images.. (eg, /usr/local/apache/htdocs)
  //define('DIR_FS_LOGS', '/usr/local/apache/logs/');
  define('DIR_WS_ADMIN', $dir_admin);
  define('DIR_WS_CATALOG', $dir_catalog);
  define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG);
  define('DIR_WS_IMAGES',  $image_upload);
  define('DIR_WS_CATALOG_IMAGES', $image_upload);
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', '../languages/');
  define('DIR_WS_OSADMIN_LANGUAGES',   DIR_WS_LANGUAGES . 'osadmin/');
  define('DIR_WS_OSCATALOG_LANGUAGES', DIR_WS_LANGUAGES . 'oscatalog/');
  define('DIR_WS_CATALOG_LANGUAGES', DIR_WS_CATALOG . 'includes/languages/');
  define('DIR_FS_PAYMENT_MODULES', DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG . 'includes/modules/payment/');
  define('DIR_FS_SHIPPING_MODULES', DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG . 'includes/modules/shipping/');

  //define('HTTPS_SERVER', 'https://demo.jvmcompany.com');
  define('ENABLE_SSL', 0); // ssl server enable(1)/disable(0)

  define('DIR_WS_PAYMENT_MODULES', DIR_WS_MODULES . 'payment/');


  define('EXIT_AFTER_REDIRECT', 1); // if enabled, the parse time will not store its time after the header(location) redirect - used with tep_tep_exit();

  define('STORE_DB_TRANSACTIONS', 0);


?>
