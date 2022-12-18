<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/viaje.php';
require_once CLASES.'/model.php';
require_once DB;

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

extract($_POST);

abrirConexion();

$viaje = new Viaje();
$model = new model();


$r="true";
$rs="true";



if(isset($retorno))
{
    $hay_retorno = 1;
}else
{
    $hay_retorno = 0;
}



if(isset($encomienda))
{
    $es_encomienda = 1;
}else
{
    $es_encomienda = 0;
}


$response = array();



if($selectDepartamento == ""){
    $selectDepartamento = "DEFAULT";
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


$loteModel = $model->getModelCondicionado("lotes", "id=$lote");
$empresaModel = $model->getModelCondicionado("empresas", "id=".$loteModel['empresa_id']);
$rutaModel = $model->getModelCondicionado("rutas", "id=".$selectRuta);

$costoRuta=$viaje->getModelCondicionado("listas_rutas", "ruta_id=".$selectRuta." and lista_id=".$selectLista);
$txtCostoViaje=$costoRuta['precio'];


//Calculo movilizaciones
$model = new model();
$lista = $model->getModel($selectLista, "listas");

$total_movilizaciones = $nmovilizaciones * $lista['movilizaciones'];


$viajeModel = array( 
                    'estado' => 3,
                    'ruta_id'=>$selectRuta,
                    'ruta'=> "'".$rutaModel['descripcion']."'",
                    'lista_id'=> $selectLista,
                    'lote_id'=> $lote,
                    'iva'=> 12,
                    'encomienda'=> $es_encomienda,
                    'solicitud_servicio' => $txtSolicitud,
                    'retorno'=> $hay_retorno,
                    'empresa_id' => $loteModel['empresa_id'],
                    'adicional' => $busqueda,
                    'departamento_id'=> $selectDepartamento,
                    'recargo_porc' => $txtRecargo,
                    'nsolicitud'=>"'".$txtSolicitud."'",
                    'numero_pasajeros'=> $npasajeros,
                    'numero_movilizaciones'=> $nmovilizaciones,
                    'total_monto_movilizaciones'=> $total_movilizaciones,
                    'horas_espera' => $txtHoras,
                    'horas_espera_double' => $txtHoras,
                    'ruta_busqueda_id' => $selectRutaBusqueda,
                    'monto_viaje'=> $txtCostoViaje,
                    'monto_esp_empresa'=>$txtCostoViaje,
                    'recargo_porc' => $txtRecargo
                    );


$sql = "SELECT nextval('viajes_id_seq') AS id";
$result = pg_query($sql);
$arr = pg_fetch_array($result);
$idViaje = $arr['id'];



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





if($viaje->save("viajes",$viajeModel))
{
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
