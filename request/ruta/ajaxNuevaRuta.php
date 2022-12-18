<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/ruta.php';
require_once CLASES.'/lista.php';
require_once CLASES.'/destino.php';
require_once DB;

extract($_POST);
abrirConexion();
$ruta = new Ruta();
$lista = new Lista();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$destinos = explode(",", $_POST['selectRuta']);
$rutaStr = $ruta->createRutaFromIds($destinos);

$arr = array('descripcion' => "'".$rutaStr."'",'ids' => "'".implode("-", $destinos)."'");

$rutaExiste = $ruta->rutaExist($rutaStr);

if(!$ruta->rutaExist($rutaStr))
{
	$idRuta = $ruta->saveId("rutas", $arr);
}else{
	$idRuta = $rutaExiste['id'];
}



if($idRuta)
{

	$itemExiste = $lista->ItemExist($idRuta);

	

	if($itemExiste)
	{
		$lista->delete("listas_rutas", "id", $itemExiste['id']);
	}


	$arrItem = array('lista_id' => $selectLista, 'ruta_id' => $idRuta, 'ruta' => "'".$rutaStr."'",'precio' => $txtPrecio,'precio_conductores' => $txtPrecioPago);
   	
	if($lista->save("listas_rutas", $arrItem))
	{
		$response = array('r' => 'true');
	}else{
		$response = array('r' => 'false');
	}
   	

}else{
   $response = array('r' => 'false');
}

echo json_encode($response);

cerrarConexion();

?>
