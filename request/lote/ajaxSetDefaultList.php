<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/model.php';
require_once DB;

extract($_POST);
//
//


abrirConexion();


$model = new model();
$datos = array('default_list' => $lista);
$result = $model->update("lotes", "id", $datos, $lote);

if($result)
{
	echo json_encode(array('response' => "true", 'msg' => "Lista por defecto establecida Satisfactoriamente!"));
}else{
	echo json_encode(array('response' => "false", 'msg' => "No se pudo establecer la lista por defecto!"));
}


?>