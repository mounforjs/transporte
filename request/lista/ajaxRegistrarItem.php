<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;

abrirConexion();
extract($_POST);
$lista = new Lista();

if(!isset($lista_id))
{
    $listActiva = $lista->getModelCondicionado("listas", "estado=1");
    $lista_id = $listActiva['id'];
}


if(!isset($txtPrecio))
	$txtPrecio = 0;

if(!isset($txtPrecioPago))
	$txtPrecioPago = 0;


$ruta = $lista->getDescripcionTable("rutas", $inputRuta, "descripcion");
$arr = array('lista_id' => $lista_id,'ruta_id' => $inputRuta,'ruta' => "'".$ruta."'",'precio' => $txtPrecio,'precio_conductores' => $txtPrecioPago);

if($lista->save("listas_rutas", $arr))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
