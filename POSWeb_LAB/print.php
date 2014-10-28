
<?

$handle = fopen("PRN", "w");
fwrite($handle,chr(27). chr(64));
fwrite($handle, chr(27). chr(97). chr(1));//centrado
fwrite($handle,"Título");
fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
fwrite($handle, chr(27). chr(97). chr(0)); //izquierda
fwrite($handle, "texto");
fclose($handle); // cierra el fichero PRN
$salida = shell_exec('lpr PRN'); //lpr->puerto impresora, imprimir archivo PRN
?>

