<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ruta
 *
 * @author aarenas
 */

require_once CLASES.'/model.php';
require_once CLASES.'/destino.php';


class Ruta extends model {

    
	public function createRutaFromIds(Array $destinos)
	{

		$ruta = array();
		$destinoObj = new Destino();

		if(!empty($destinos))
		{

			foreach ($destinos as $key => $destino) {

				$destinoModel = $destinoObj->getDestinoById($destino);
				$ruta[] = $destinoModel['descripcion'];
			}

		}else{
			return null;
		}

		return implode(" - ", $ruta);
	}

	public function rutaExist(String $ruta)
	{

		$result = $this->getModelCondicionado("rutas", "descripcion = '".$ruta."'");
		
		

		if(!empty($result))
		{
			return $result;
		}else{
			return false;
		}

	}


}
?>
