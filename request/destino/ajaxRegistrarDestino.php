<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/destino.php';
require_once DB;

extract($_POST);

abrirConexion();
$destino=new Destino();
$arr=array('descripcion'=>"'".$txtNombreDestino."'",'estado_id'=>$selectEstado);

if($destino->save("destinos",$arr))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
