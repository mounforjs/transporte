<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);

abrirConexion();
$lote=new Lote();
$r="true";
$viajes="";

$arr=explode(",", $txtTags);

foreach($arr as $viaje){
    $viajeModel=$lote->getModelCondicionado("viajes", "lote_id=".$selectLote." and id=".$viaje);
    if($viajeModel==false){
        $viajes.=$viaje."-";
    }
}

if($viajes!=""){
    echo $viajes;
}else{
    echo $r;
}

cerrarConexion();

?>
