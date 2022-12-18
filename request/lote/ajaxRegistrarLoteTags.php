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
    $arrDatos=array('lote_id'=>$selectLote,'solicitud_servicio'=>0);
    $lote_id=$lote->getDescripcionTable("viajes", $viaje, "lote_id");
    
        if($lote_id==0){
            if(!$lote->update("viajes", "id", $arrDatos, $viaje)){
                $r="false";
                break;
            }
        }else{
            //echo $viaje;
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
