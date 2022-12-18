<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once CLASES.'/movilizacion.php';
require_once CLASES.'/lista.php';
require_once DB;

extract($_POST);
$viaje=new viaje();
$lista=new Lista();
$movilizacion=new Movilizacion();
abrirConexion();

$viajeModel = $viaje->getModel($id, "viajes");
$costoRuta = $viaje->getModelCondicionado("listas_rutas", "ruta_id=".$viajeModel['ruta_id']." and lista_id=".$viajeModel['lista_id']);
$listaModel = $lista->getModel($viajeModel['lista_id'], "listas");


$totalViajeEmpresa=$viajeModel['monto_esp_empresa'];
$totalViajeConductor=$viajeModel['monto_esp_conductor'];

if($viajeModel['retorno'] == 1){
 $totalViajeEmpresa+=$viajeModel['monto_esp_empresa'];
 $totalViajeConductor+=$viajeModel['monto_esp_conductor'];
}


//CONSERVANDO DECIMALES EN HORAS DE ESPEA
if(empty($viajeModel['horas_espera_double']))
{
    $txtHoras = $viajeModel['horas_espera'];
}else{
    $txtHoras = $viajeModel['horas_espera_double'];
}


/*
if(!isset($txtHoras)){
    $txtHoras=$viajeModel['horas_espera'];
}
*/


if(!isset($txtHorasConductor)){
    $txtHorasConductor=$viajeModel['horas_conductor'];
}

if(!isset($txtObservaciones)){
    $txtObservaciones=$viajeModel['observaciones'];
}


//CALCULANDO TOTAL VIAJE (COSTO EMPRESA)
$montoHoraEsperaEmpresa = $listaModel['hora_espera']*$txtHoras;
$montoMovilizacionesEmpresa = $movilizacion->totalMovilizaciones($id, "precio");
$totalViajeEmpresa += $montoHoraEsperaEmpresa + $viajeModel['total_monto_movilizaciones'];

//$totalViajeEmpresa+=$montoHoraEsperaEmpresa+$montoMovilizacionesEmpresa; //MOdificar


//CALCULANDO TOTAL VIAJE (PAGO CONDUCTOR)
$montoHoraEsperaConductor = $listaModel['hora_espera_conductor']*$txtHorasConductor;
$montoMovilizacionesConductor = $movilizacion->totalMovilizaciones($id, "pago");
$totalViajeConductor += $montoHoraEsperaEmpresa + $viajeModel['total_monto_movilizaciones']/2;


//$totalViajeConductor+=$montoHoraEsperaConductor+$montoMovilizacionesConductor;  //MOdificar



$totalViajeEmpresa+=(($viajeModel['monto_esp_empresa'])*$viajeModel['recargo_porc']/100);




if($viajeModel['adicional']!=0){
    $totalViajeEmpresa+=$viajeModel['adicional'];
}

if($viajeModel['adicional_conductor']!=0){
    $totalViajeConductor+=$viajeModel['adicional_conductor'];
}

if($viajeModel['encomienda']==1){
    $iva=$viaje->getDescripcionTable("iva", 1, "iva");
    $totalIva=($iva*($totalViajeEmpresa))/100;
}


if($txtObservaciones==""){
    $txtObservaciones="DEFAULT";
}else{
    $txtObservaciones="'".$txtObservaciones."'";
}

if($viajeModel['estado']==1 ){
    if(isset($editar)){
        $estado=1;
    }else{
        $estado=2;
    }
}

if($viajeModel['estado']==2){
    if(isset($editar)){
        $estado=2;
    }else{
        $estado=3;
    }
}

if($viajeModel['estado']==3){
    if(isset($editar)){
        $estado=3;
    }else{
        $estado=3;
    }
}


$arr=array('estado'=>$estado,'horas_conductor'=>$txtHorasConductor,'observaciones'=>$txtObservaciones,'monto_viaje'=>$totalViajeEmpresa,'monto_pago'=>$totalViajeConductor);
/*echo "<pre>";
print_r($arr);
echo "</pre>";*/

if($viaje->update("viajes", "id", $arr,$id))
{
    echo "ok";
}else
{
    echo "false";
}

cerrarConexion();
?>
