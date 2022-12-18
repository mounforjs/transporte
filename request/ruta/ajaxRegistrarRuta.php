<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/ruta.php';
require_once DB;

extract($_POST);

abrirConexion();
$ruta = new Ruta();
$arr=array('descripcion'=>"'".$txtRuta."'",'ids'=>"'".$txtRutaID."'");

if($ruta->save("rutas",$arr))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
