<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/viaje.php';
require_once CLASES.'/model.php';
require_once DB;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

extract($_POST);

abrirConexion();
$viaje=new Viaje();




$r="true";
$rs="true";

$es_encomienda = 0;
$hay_retorno = 0;

if(isset($retorno))
{
    if($retorno)
    {
        $hay_retorno = 1;
    }
}

if(isset($encomienda))
{
    if($encomienda)
    {
        $es_encomienda = 1;
    }
}

$response = array();

$idViajeO=$idViaje;


$viajeModel = $viaje->getModel($idViaje, "viajes");




extract($viajeModel);


if($departamento_id==""){
    $departamento_id = "DEFAULT";
}

$monto_esp_empresa = $viaje->getDescripcionTableCondicional("listas_rutas", "ruta_id=".$selectRuta." AND lista_id=".$selectLista, "precio");
$monto_esp_conductor = $viaje->getDescripcionTableCondicional("listas_rutas", "ruta_id=".$selectRuta." AND lista_id=".$selectLista, "precio_conductores");


if($selectRutaBusqueda != 0 && $selectRutaBusqueda != ""){
    $qstring = "SELECT ruta ,ruta_id, precio FROM listas_rutas WHERE lista_id=$selectLista and  ruta_id = ".$selectRutaBusqueda;
    $result = pg_query($qstring);


    $rutal_model = pg_fetch_array($result);
    $busqueda =  ($rutal_model['precio']*50)/100;
}else
{
   $busqueda = 0; 
}


switch ($txtRecargo) {

    case 'ninguna':
        $txtRecargo = 0;
        break;
    case 'fon':
        $txtRecargo = 30;
        break;
    case 'fyn':
        $txtRecargo = 60;
        break;
    case 'encomienda':
        $txtRecargo = 60;
        break;
    
    default:
        $txtRecargo = 0;
        break;
}



//Calculo movilizaciones
$model = new model();
$lista = $model->getModel($selectLista, "listas");



$total_movilizaciones = $nmovilizaciones * $lista['movilizaciones'];



$viajeModel=array( 
                    'estado' => 3,
                    'destino_final' => "'".$destino_final."'",
                    'como_llegar' => "'".$como_llegar."'",
                    'monto_viaje' => $monto_viaje,
                    'monto_pago' => $monto_pago,
                    'ruta'=> "'".$ruta."'",
                    'lista_id'=>$selectLista,
                    'ruta_id'=> $selectRuta,
                    'lote_id'=>$lote_id,
                    'encomienda'=> $es_encomienda,
                    'iva' => $iva,
                    'horario' => $horario,
                    'solicitud_servicio' => $solicitud_servicio,
                    'retorno'=> $hay_retorno,
                    'empresa_id' => $empresa_id,
                    'adicional' => $busqueda,
                    'adicional_conductor' => $adicional_conductor,
                    'monto_esp_empresa' => $monto_esp_empresa,
                    'monto_esp_conductor'=> $monto_esp_conductor,
                    'observaciones' => "'".$observaciones."'",
                    'departamento_id'=> $departamento_id,
                    'recargo_porc' => $txtRecargo,
                    'nsolicitud'=>"'".$txtSolicitud."'",
                    'numero_pasajeros'=> $npasajeros,
                    'numero_movilizaciones'=> $nmovilizaciones,
                    'total_monto_movilizaciones'=> $total_movilizaciones,
                    'horas_espera' => $txtHoras,
                    'horas_espera_double' => $txtHoras,
                    'ruta_busqueda_id' => $selectRutaBusqueda

                    );

/*$sql = "SELECT nextval('viajes_id_seq') AS id";
$result = pg_query($sql);
$arr = pg_fetch_array($result);
$idViaje = $arr['id'];*/



$viajeModel['id']= $idViaje;
$viajeModel['retorno']= $hay_retorno;
$viajeModel['conductor_id'] = $selectConductor;
$viajeModel['departamento_id'] = $selectDepartamento;
$viajeModel['ruta_id'] = $selectRuta;

$ruta = $viaje->getDescripcionTable("rutas", $selectRuta, "descripcion"); 
$viajeModel['ruta'] = "'".$ruta."'";


if(empty($txtFechaViaje) || $txtFechaViaje == null)
{
    $viajeModel['fecha'] = "NULL";
}else{
    $txtFechaViaje = "'".$txtFechaViaje."'";
    $viajeModel['fecha'] = $txtFechaViaje;
}




$viajeModel['numero_pasajeros'] = "'".$npasajeros."'";
$viajeModel['numero_movilizaciones'] = "'".$nmovilizaciones."'";





if($viaje->update("viajes", "id", $viajeModel, $idViaje))
{

//if($viaje->save("viajes",$viajeModel))
//{
    //REGISTRANDO PASAJEROS
 
    $response['success'] = "true";
    $response['viaje'] = $idViaje;
        
    echo json_encode($response);
   
}else{
    $rs = "false";
    echo $rs;
}

cerrarConexion();

?>
