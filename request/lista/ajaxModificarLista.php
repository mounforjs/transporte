<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;

extract($_POST);

abrirConexion();
$lista=new Lista();
$fecha=date("d/m/Y");
$fecha=$lista->convertFechaSQLPostgres($fecha);

if(!isset($txtHora))
	$txtHora = 0;

if(!isset($txtHoraConductor))
	$txtHoraConductor = 0;

$arr=array('descripcion'=>"'".$txtDescripcion."'",'fecha'=>$fecha,'hora_espera'=>$txtHora,'hora_espera_conductor'=>$txtHoraConductor, 'movilizaciones' => $movilizaciones);

if($lista->update("listas", "id", $arr, $_SESSION['idLista']))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
