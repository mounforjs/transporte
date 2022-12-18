<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/viaje.php';
require_once DB;

extract($_POST);

abrirConexion();
$viaje=new Viaje();


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

$idViajeO=$idViaje;


$viajeModel = $viaje->getModel($idViaje, "viajes");




extract($viajeModel);


if($departamento_id==""){
    $departamento_id = "DEFAULT";
}

$monto_esp_empresa = $viaje->getDescripcionTableCondicional("listas_rutas", "ruta_id=".$selectRuta." AND lista_id=".$lista_id, "precio");
$monto_esp_conductor = $viaje->getDescripcionTableCondicional("listas_rutas", "ruta_id=".$selectRuta." AND lista_id=".$lista_id, "precio_conductores");


if($selectRutaBusqueda != 0 && $selectRutaBusqueda != ""){
    $qstring = "SELECT ruta ,ruta_id, precio FROM listas_rutas WHERE lista_id=$lista_id and  ruta_id = ".$selectRutaBusqueda;
    $result = pg_query($qstring);


    $rutal_model = pg_fetch_array($result);
    $busqueda =  ($rutal_model['precio']*50)/100;
}else
{
   $busqueda = 0; 
}




$viajeModel = array( 
                    'estado' => 3,
                    'destino_final' => "'".$destino_final."'",
                    'como_llegar' => "'".$como_llegar."'",
                    'monto_viaje' => $monto_viaje,
                    'monto_pago' => $monto_pago,
                    'ruta'=> "'".$ruta."'",
                    'lista_id'=>$lista_id,
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
                    'lista_id' => $lista_id,
                    'recargo_porc' => $txtRecargo,
                    'nsolicitud'=>"'".$txtSolicitud."'",
                    'numero_pasajeros'=> $npasajeros,
                    'numero_movilizaciones'=> $nmovilizaciones,
                    'total_monto_movilizaciones'=>"'".$totalmovilizaciones."'",
                    'horas_espera' => $txtHoras,
					'horas_espera_double' => $txtHoras,
                    'ruta_busqueda_id' => $selectRutaBusqueda

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
$viajeModel['total_monto_movilizaciones'] = "'".$totalmovilizaciones."'";




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
