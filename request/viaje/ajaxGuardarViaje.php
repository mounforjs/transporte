<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/viaje.php';
require_once CLASES.'/lista.php';
require_once CLASES.'/detalles.php';
require_once DB;

$r=false;
$resp="false";

extract($_POST);
abrirConexion();
    
$viaje=new viaje();
$detalles=new Detalles();
$lista=new Lista();
$viaje->begin();

$lista=$selectLista;
$txtFechaViaje=$viaje->convertFechaSQLPostgres($txtFechaViaje);
$txtComoLlegar=($txtComoLlegar=="")?"DEFAULT":$txtComoLlegar;
$txtCostoViaje=($txtCostoViaje=="")?"DEFAULT":$txtCostoViaje;
$txtPagoViaje=($txtPagoViaje=="")?"DEFAULT":$txtPagoViaje;
$ruta=$viaje->getDescripcionTable("rutas", $selectRuta, "descripcion");
$txtAdicional=($txtAdicional=="")?"DEFAULT":$txtAdicional;
$txtAdicionalConductor=($txtAdicionalConductor=="")?"DEFAULT":$txtAdicionalConductor;
$iva=$viaje->getDescripcionTable("iva", 1, "iva");

if(trim($txtCostoViaje)=="" || trim($txtCostoViaje)==0){
    $costoRuta=$viaje->getModelCondicionado("listas_rutas", "ruta_id=".$selectRuta." and lista_id=".$lista);
    $txtCostoViaje=$costoRuta['precio'];
    $txtPagoViaje=$costoRuta['precio_conductores'];
}


if(!isset($chkRetorno)){
    $chkRetorno=0;
}
/*if($selectHorario==3){
    $chkRetorno=1;
}*/
if(!isset($chkEncomienda)){
    $chkEncomienda=0;
}
if(!isset($chkMontoEspecifico)){
    $chkMontoEspecifico=0;
}
if(trim($txtAdicional)==""){
    $txtAdicional=0;
}
if(!isset($chkHConductor)){
    $chkHConductor=0;
}

//SI ES UNA ENCOMIENDA, GUARDO EL SOLICITANTE EN EL CAMPO OBSERVACIONES

if($chkEncomienda==1){
    $solicitadapor=$txtEncomienda;
    $observaciones=$solicitadapor;
}else{
    $observaciones="";
}

if($selectDepartamento==""){
	$selectDepartamento="DEFAULT";
}


$arrviaje=array('conductor_id'=>$selectConductor,
                    'fecha'=>$txtFechaViaje,
                    'ruta_id'=>$selectRuta,
                    'estado'=>$selectEstatus,
                    'destino_final'=>"'".$txtDestinoFinal."'",
                    'como_llegar'=>"'".$txtComoLlegar."'",
                    'monto_viaje'=>$txtCostoViaje,
                    'monto_pago'=>$txtPagoViaje,
                    'ruta'=>"'".$ruta."'",
                    'lista_id'=>$lista,
                    'lote_id'=>$selectLote,
                    'encomienda'=>$chkEncomienda,
                    'iva'=>$iva,
                    //'horario'=>$selectHorario,
                    'retorno'=>$chkRetorno,
                    'monto_especifico'=>$chkMontoEspecifico,
                    'empresa_id'=>$selectEmpresa,
                    'adicional'=>$txtAdicional,
                    'adicional_conductor'=>$txtAdicionalConductor,
                    'monto_esp_empresa'=>$txtCostoViaje,
                    'monto_esp_conductor'=>$txtPagoViaje,
                    'observaciones'=>"'".$observaciones."'",
                    'departamento_id'=>$selectDepartamento,
                    'lista_id'=>$selectLista,
                    'recargo_porc'=>$txtRecargo,
                    'leyenda'=>"'".$txtLeyenda."'"
                    
                    );

    //Guardando datos de la viaje

    $viaje->update("viajes","id",$arrviaje ,$_SESSION['viajeId']);
    $r=true;
    //Guardando pasajeros
	
	/*echo "<pre>";
	print_r($_SESSION['pasajerosGuardar']);
	echo "</pre>";*/
	
    if(isset($_SESSION['pasajerosGuardar'])){
        $pasajeros=$_SESSION['pasajerosGuardar'];
        if(count($pasajeros)>=1){

            foreach($pasajeros as $pasajero)
            {
        //        $viaje->printArray($pasajero);
                $arr=array('pasajero_id'=>$pasajero['pasajero_id'],
                   'viaje_id'=>$pasajero['viaje_id'],
                );

                if(!$viaje->save("pasajeros_viajes", $arr)){
                    $r=false;
                }else{
                    $r=true;
                }
            }
        }
    }
    
    //Guardando Movilizaciones
   if(isset($_SESSION['movilizaciones'])){
        $movilizaciones=$_SESSION['movilizaciones'];

        if(count($movilizaciones)>=1){

            foreach($movilizaciones as $movilizacion)
            {
                $arr=array('descripcion'=>"'".$movilizacion['descripcion']."'",
                   'viaje_id'=>$movilizacion['viaje_id'],'precio'=>$movilizacion['precio'],'pago'=>$movilizacion['pago']
                );

                if(!$viaje->save("movilizaciones", $arr)){
                    $r=false;
                }else{
                    $r=true;
                }
            }
        }
    }

    if($r){
        $resp="ok";
        $viaje->commit();
    }else{
        $resp="false";
        $viaje->rollback();
    }
    echo $resp;
    cerrarConexion();

?>
