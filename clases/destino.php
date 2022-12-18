<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of destino
 *
 * @author aarenas
 */

require_once CLASES.'/model.php';

class Destino extends model {
    
	public function getDestinoById($id)
	{
		$destino = $this->getModel($id, "destinos");
		if(!empty($destino))
		{
			return $destino;

		}else{
			return null;
		}
	}

}
?>
