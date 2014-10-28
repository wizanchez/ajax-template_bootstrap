<?php
/* 
 * Clase para la gestion de transacciones con la base de datos
 * Metodos de Insercion, Actualizacion y Eliminacion.
 * 25 de Mayo de 2010
 */
class Fjvm_consulta{
	
	
	public function query_consulta($a_vec,$ver_consulta='')
	{
			global $conn;
     /* Descripcion: Metodo para la ejecucion de consultas pos medio de un vector
     * Parametros : Sentecia SQL que sera ejecutada(STRING)
     * Retorno    : Array con el Resultado de la Consulta(Para selecciones), o estado de la consulta(Inserciones, Actualizaciones y Borrado)
     *              Si ocurre un error sera devuelta una cadena(STRING) con el error que ocurrio(ErrorMsg())
     * Fecha      :2 julio 2010 3.40pm
     */
		$rc_sql = &$conn->Prepare('SELECT '.$a_vec['datos'].' FROM '.$a_vec['tabla'].' WHERE '.$a_vec['donde']);
		if(isset($ver_consulta)&&$ver_consulta=='ver_consulta'){echo $rc_sql;}
		if($rs = &$conn->Execute($rc_sql)===false){echo 'error SQL ['.$rc_sql.']['.$conn->ErrorMsg().']';}
		return $rs->GetArray();
	}
	
	public function query_consulta_simple($a_sql,$ver_consulta='')
	{
			global $conn;
     /* Descripcion: Metodo para la ejecucion de consultas pos medio de un vector
     * Parametros : Sentecia SQL que sera ejecutada(STRING)
     * Retorno    : Array con el Resultado de la Consulta(Para selecciones), o estado de la consulta(Inserciones, Actualizaciones y Borrado)
     *              Si ocurre un error sera devuelta una cadena(STRING) con el error que ocurrio(ErrorMsg())
     * Fecha      :2 julio 2010 3.40pm
     */
		$rc_sql = &$conn->Prepare($a_sql);
		if(isset($ver_consulta)&&$ver_consulta=='ver_consulta'){echo $rc_sql;}
		if($rs = &$conn->Execute($rc_sql)===false){echo 'error SQL ['.$rc_sql.']['.$conn->ErrorMsg().']';}
		return $rs->GetArray();
	}
	
    public function query_insertar($post, $tabla,$ver_consulta)
	{ global $conn;
     /*Descripcion: Metodo que genera una cadena SQL para insercion de datos a la Base de Datos
     * Parametros : Array Asociativo de tipo array[nombre del campo]= "valor a agregar", Tabla a la que apunta la insercion
     * Retorno    : Cadena (STRING) de insercion para ser ejecutada por el medoto AdminConsulta::ejecutar_consulta()
     * Fecha      :25 de Mayo de 2010
     */
        //SE OBTIENEN LOS INDICES Y DATOS DEL ARRAY ENVIADO
        $indices=@array_keys($post);
        $datos=@array_values($post);
        //SE DEFINE EL NUMERO DE DATOS QUE SE VANA INSERTAR
        $num_val=count($datos)-1;

        //SE RECORREN LOS DOS ARRAYS DE INDICES Y VALORES PARA CREAR LA CADENA DE INSERCION
        for($i=0;$i<=$num_val;$i++)
        {
            $indice.=$indices[$i];
            if($i!=$num_val)
            {
                $indice.=", ";
            }
        }
        $i=0;
        for($i=0;$i<=$num_val;$i++)
        {       
            $valor.="'".$datos[$i]."'";
            if($i!=$num_val)
            {
                $valor.=", ";
            }
        }
        $sql="INSERT INTO ".$tabla." (".$indice.") VALUES (".$valor.")";
        
		  $rc_sql = &$conn->Prepare($sql);
		  	if($ver_consulta=='ver_consulta')
		  		{echo $rc_sql;}
		  if($conn->Execute($rc_sql)===false){echo 'error SQL ['.$rc_sql.']['.$conn->ErrorMsg().']';}
			if($VIEW=='ver_query'){$rc_sql;}	
        return $conn->INSERT_ID();
    }
	
    public function ejecutar_consulta($consulta)
    {
     /* Descripcion: Metodo para la ejecucion de consultas
     * Parametros : Sentecia SQL que sera ejecutada(STRING)
     * Retorno    : Array con el Resultado de la Consulta(Para selecciones), o estado de la consulta(Inserciones, Actualizaciones y Borrado)
     *              Si ocurre un error sera devuelta una cadena(STRING) con el error que ocurrio(ErrorMsg())
     * Fecha      :25 de Mayo de 2010
     */
        global $conn;
        /*Metodo que ejecuta una consulta a partir de una sentencia SQL y la variable
         * 
         */
        $resultado=$conn->Execute($consulta);
        if(!$resultado){
		  $resultado = "Se produjo un Error en la Consulta con los siguientes Detalles: ".$conn->ErrorMsg();
		  exit;
	   }
	return $resultado;
    }
    
    public function insertar($post, $tabla)
    {
     /*Descripcion: Metodo que genera una cadena SQL para insercion de datos a la Base de Datos
     * Parametros : Array Asociativo de tipo array[nombre del campo]= "valor a agregar", Tabla a la que apunta la insercion
     * Retorno    : Cadena (STRING) de insercion para ser ejecutada por el medoto AdminConsulta::ejecutar_consulta()
     * Fecha      :25 de Mayo de 2010
     */
        //SE OBTIENEN LOS INDICES Y DATOS DEL ARRAY ENVIADO
        $indices=@array_keys($post);
        $datos=@array_values($post);
        //SE DEFINE EL NUMERO DE DATOS QUE SE VANA INSERTAR
        $num_val=count($datos)-1;

        //SE RECORREN LOS DOS ARRAYS DE INDICES Y VALORES PARA CREAR LA CADENA DE INSERCION
        for($i=0;$i<=$num_val;$i++)
        {
            $indice.=$indices[$i];
            if($i!=$num_val)
            {
                $indice.=", ";
            }
        }
        $i=0;
        for($i=0;$i<=$num_val;$i++)
        {       
            $valor.="'".$datos[$i]."'";
            if($i!=$num_val)
            {
                $valor.=", ";
            }
        }
        $sql="INSERT INTO ".$tabla." (".$indice.") VALUES (".$valor.")";
        
        return $sql;
        //return $this->ejecutar_consulta($resultado);
    }

    public function actualizar($post, $tabla, $donde)
    {
     /*Descripcion: Metodo que genera una cadena SQL para actualizacion de datos a la Base de Datos
     * Parametros : Array Asociativo de tipo array[nombre del campo]= "valor a actualizar", Tabla a la que apunta la actualizacion
      *             y variable con el WHERE de la consulta ej: $donde="id='3'"
     * Retorno    : Cadena (STRING) de actualizacion para ser ejecutada por el medoto AdminConsulta::ejecutar_consulta()
     * Fecha      :25 de Mayo de 2010
     */
        $indices=@array_keys($post);
        $datos=@array_values($post);

        $num_val=count($datos)-1;

        for($i=0;$i<=$num_val;$i++)
        {
            $valores.=$indices[$i]." = '".$datos[$i]."'";
            if($i!=$num_val)
            {
                $valores.=", ";
            }
        }
        $sql= "UPDATE ".$tabla." SET ".$valores." WHERE ".$donde;

        return $sql;
        //return $this->ejecutar_consulta($resultado);
    }
    
    public function eliminar($datos, $tabla, $donde='1')
    {
    /*Descripcion: Metodo que genera una cadena SQL para eliminacion de datos a la Base de Datos
     * Parametros : Array con los datos a eliminar, Tabla a la que apunta la eliminacion, variable con el WHERE
     *              de la consulta.
     * Retorno    : Cadena (STRING) de seleccion para ser ejecutada por el medoto AdminConsulta::ejecutar_consulta()
     * Fecha      :25 de Mayo de 2010
     */
        $i=0;
        $num=count($datos);
        for($i=0;$i<=$num;$i++)
        {
            $valores.=$datos[$i];

            if($i<$num)
            {
                $valores.=", ";
            }
        }
        $valores = substr ($valores, 0, -2);
        $sql="DELETE ".$valores." FROM ".$tabla." WHERE ".$donde;
        return $sql;
    }

    public function seleccionar($datos, $tabla, $donde='1', $ordenar='')
    {
    /*Descripcion: Metodo que genera una cadena SQL para seleccion de datos a la Base de Datos
     * Parametros : Array con los datos a Seleccionar, Tabla a la que apunta la seleccion, variable con el WHERE
     *              de la consulta.
     * Retorno    : Cadena (STRING) de seleccion para ser ejecutada por el medoto AdminConsulta::ejecutar_consulta()
     * Fecha      :25 de Mayo de 2010
     */
        $i=0;
        $num=count($datos);
        for($i=0;$i<=$num;$i++)
        {
            $valores.=$datos[$i];

            if($i<$num)
            {
                $valores.=", ";
            }
        }
        $valores = substr ($valores, 0, -2);
        $sql="SELECT ".$valores." FROM ".$tabla." WHERE ".$donde ." ". $ordenar;
        return $sql;
    }

    public function ultimo_id($consulta)
    {
     /*Descripcion: Metodo que retorna el ultimo id autonomerico insertado en la Base de Datos
     * Parametros : Variable Global $conn despues de haber realizado consultas de Insercion
     * Retorno    : Ultimo ID autonumerico insertado en la Base de Datos
     * Fecha      :25 de Mayo de 2010
     */
        return $consulta->Insert_ID();
    }

    public function llenar_combo($consulta, $seleccion="")
	{
     /*Descripcion: Metodo que llena un combo con valores traidos de la base de datos
     * Parametros : Array de resultado de una consulta de seleccion
     * Retorno    : Valores del tag option, este metodo debe ser utilizado dentro de los tags
      *             select para que sea llenado adecuadamente
     * Fecha      :25 de Mayo de 2010
     */
        while (!$consulta->EOF)
        {
            
            ($consulta->fields['0']==$seleccion)?$seleccionado="selected='selected'":$seleccionado="";
            echo "<option value='".$consulta->fields['0']."' ".$seleccionado.">".$consulta->fields['1']."</option>";
            $consulta->MoveNext();
        }
    }


}

?>
