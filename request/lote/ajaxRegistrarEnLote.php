<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);

abrirConexion();
$r="true";
$viajes="";
$lote=new Lote();
$arr=array('lote_id'=>$selectLote);

    
$arr=array("lote_id"=>$selectLote);


foreach($chkviajes as $chk)
{
    $ss=$lote->getDescripcionTable("viajes", $chk, "solicitud_servicio");
    $empresa_viaje=$lote->getDescripcionTable("viajes", $chk, "empresa_id");
    $empresa_lote=$lote->getDescripcionTable("lotes", $selectLote, "empresa_id");
    $lote_id=$lote->getDescripcionTable("viajes", $chk, "lote_id");
    
    //if($ss==0){

        //if($lote_id==0 && $empresa_lote == $empresa_viaje){
        if($lote_id==0 )
        {
            $lote->update("viajes", "id", $arr, $chk);
        }else{
            $viajes.=$chk."-"; //SI LAS EMPRESAS NO COINCIDEN
        }

   // }else{
    //   $viajes.=$chk."-"; // SI NO TIENE SOLICITUD
   // }
}

if($viajes!=""){
    
    echo $viajes;
}else{
    echo $r;
}
    cerrarConexion();

?>
