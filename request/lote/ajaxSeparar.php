<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;

extract($_POST);

abrirConexion();
$lote=new Lote();

if($chkseparar=="nuevo")
{
    $fecha=date("d/m/Y");
    $fecha=$lote->convertFechaSQLPostgres($fecha);
    $arr=array('descripcion'=>"'".$txtDescripcion."'",'fecha'=>$fecha,'nfactura'=>$txtFactura,'empresa_id'=>$selectEmpresa);

    if($lote->save("lotes",$arr))
    {
        $idLote=$lote->getDescripcionTableCondicional("lotes", "descripcion='".$txtDescripcion."'", "id");
        
            foreach ($chkviajes as $viaje){
                $arr=array('lote_id'=>$idLote);
                $lote->update("viajes", "id", $arr, $viaje);
            }

            echo "ok";
        
        

    }else{
       echo "false";
    }
}else{
    foreach ($chkviajes as $viaje){
        $arr=array('lote_id'=>$selectLote);
        $lote->update("viajes", "id", $arr, $viaje);
    }

    echo "ok";
}



cerrarConexion();

?>
