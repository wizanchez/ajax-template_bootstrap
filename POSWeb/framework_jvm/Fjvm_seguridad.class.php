<?PHP

class Fjvm_seguridad
{
	
	public function codificar($cont){
	/* Description: metodo para codificar parámetros en BASE64.
	* @param: El contenido a codificar
	* @return: El contenido codificado en BASE64.
	* @Creado 28 Sep 2010
	* @autor luis Sanchez
	*/	
		return base64_encode($cont);
	}	
	public function decodificar($cont){
	/* Description: metodo para decodificar parámetros en BASE64.
	* @param: El contenido a decodificar
	* @return: El contenido decodificado
	* @Creado 28 Sep 2010
	* @autor luis Sanchez
	*/

	return base64_decode($cont);
	}
	
	public function compilar_ini(){
			/* Description: metodo para compilar colocando en la cabecera
			* @param n/a
			* @return n/a
			* @Creado Julio 28 de 2010
			* @autor luis Sanchez
			*/
		ob_start();
	}
	public function compilar_fin(){
			/* Description: metodo para compilar colocando en el finnal
			* @param n/a
			* @return n/a
			* @Creado Julio 28 de 2010
			* @autor luis Sanchez
			*/
		$cntACmp =ob_get_contents(); 
		ob_end_clean(); 
		$cntACmp=str_replace("\n",' ',$cntACmp); 
		$cntACmp=ereg_replace('[[:space:]]+',' ',$cntACmp); 
		ob_start("ob_gzhandler"); 
		echo $cntACmp; 
		ob_end_flush();
	}
	
	}

?>