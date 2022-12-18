<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;

abrirConexion();

extract($_POST);
$model = new model();
$viaje = $model->getModel($id, $modelo);

if(is_array($viaje))
{
	if($viaje['recargo_porc'] == 30)
	{
		$modalidad = "fon";
	}

	switch ($viaje['recargo_porc']) {
		case '0':
			$modalidad = "ninguna";
			break;
		case '30':
			$modalidad = "fon";
			break;
		case '60':
			$modalidad = "fyn";
			break;
		case '40':
			$modalidad = "encomienda";
			break;
		
		default:
			$modalidad = "ninguna";
			break;
	}

	$viaje['modalidad'] = $modalidad;

}

echo json_encode($viaje);

?>

