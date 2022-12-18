<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;

abrirConexion();
extract($_POST);

$lista = new Lista();
$ruta = $lista->getDescripcionTable("rutas", $inputRuta, "descripcion");

if(!isset($txtPrecio))
	$txtPrecio = 0;

if(!isset($txtPrecioPago))
	$txtPrecioPago = 0;


$arr = array('ruta_id'=> $inputRuta,'ruta'=>"'".$ruta."'",'precio'=>$txtPrecio,'precio_conductores'=>$txtPrecioPago);

if($lista->update("listas_rutas", "id", $arr, $id))
{
   echo "ok";
}else
{
   echo "false";
}

cerrarConexion();

?>
