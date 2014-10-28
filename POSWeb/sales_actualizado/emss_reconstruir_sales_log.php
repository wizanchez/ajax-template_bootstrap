<?php 

		include('includes/main_2.php'); 
		include('class/Item.class.php'); 


				$SQL='	SELECT
								id 			as item_id,
								itemcode	as plu
						FROM
								item
						WHERE 
								cancel=0
								
								
								LIMIT 100';

			if($recordSet = &$conn->Execute($SQL)===false)
				{echo 'Error SQL ['.$SQL.']';exit;}
				
			$sql_maestro_prod=	$recordSet->GetArray();
			
			
			for($i=0;$i<count($sql_maestro_prod);++$i){
				
						$item_id		=$sql_maestro_prod[$i]['item_id'];
						$plu			=$sql_maestro_prod[$i]['plu'];
			
			echo $plu.'|';
						######################################################################################################
						## MIRAMOS EN ITEMPOS SI EXISTE EL  REGISTRO
								$SQL='	SELECT
												purchasegroupid 	as agrupacion_id
										FROM
												itempos
										WHERE 
												cancel=0 AND
												itemid="'.$item_id.'"';
				
							if($recordSet = &$conn->Execute($SQL)===false)
								{echo 'Error SQL ['.$SQL.']';exit;}
									$sql_itempos=	$recordSet->GetArray();
						######################################################################################################
				
							if(count($sql_itempos)==0){
							
								echo 'no itempos|--';	
								
								}elseif(count($sql_itempos)>1){
									
								echo 'mas de un registro en itempos|--';
									
									}else{
										$ruta_agrupacion	=Item::MirarRutaArbol($sql_itempos[0]['agrupacion_id'],$hasta='',$type='caja');
								echo $sql_itempos[0]['agrupacion_id'].'|'.$ruta_agrupacion;		
										
										
										}
							
							
			echo '<br>';
				
				
				}
			
			
?>