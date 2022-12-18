<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);

abrirConexion();
$lote=new Lote();
$fecha=date("d/m/Y");
$fecha=$lote->convertFechaSQLPostgres($fecha);
$arr=array('descripcion'=>"'".$txtDescripcion."'",'fecha'=>$fecha,'nfactura'=>"'".$txtFactura."'",'empresa_id'=>$selectEmpresa);

if($lote->update("lotes", "id", $arr, $_SESSION['idLote']))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
