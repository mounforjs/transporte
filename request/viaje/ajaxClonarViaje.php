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



if($retorno)
{
    $hay_retorno = 1;
}else
{
    $hay_retorno = 0;
}


if($encomienda)
{
    $es_encomienda = 1;
}else
{
    $es_encomienda = 0;
}

$response = array();

$idViajeO=$idViaje;


$viajeModel=$viaje->getModel($idViaje, "viajes");
$pasajeros_r=$viaje->getListCondicional("pasajeros_viajes", 15, "viaje_id=".$idViajeO);
$movilizaciones_r=$viaje->getListCondicional("movilizaciones", 15, "viaje_id=".$idViajeO);

extract($viajeModel);


if($departamento_id==""){
    $departamento_id = "DEFAULT";
}

$monto_esp_empresa = $viaje->getDescripcionTableCondicional("listas_rutas", "ruta_id=".$selectRuta." AND lista_id=".$lista_id, "precio");
$monto_esp_conductor = $viaje->getDescripcionTableCondicional("listas_rutas", "ruta_id=".$selectRuta." AND lista_id=".$lista_id, "precio_conductores");


$viajeModel=array( 
                    'estado' => 3,
                    'destino_final'=>"'".$destino_final."'",
                    'como_llegar'=>"'".$como_llegar."'",
                    'monto_viaje'=>$monto_viaje,
                    'monto_pago'=>$monto_pago,
                    'ruta'=>"'".$ruta."'",
                    'lista_id'=>$lista_id,
                    'lote_id'=>$lote_id,
                    'encomienda'=> $es_encomienda,
                    'iva'=>$iva,
                    'horario'=>$horario,
                    'solicitud_servicio'=>$solicitud_servicio,
                    'retorno'=> $hay_retorno,
                    'monto_especifico'=>$monto_especifico,
                    'empresa_id'=>$empresa_id,
                    'adicional'=>$adicional,
                    'adicional_conductor'=>$adicional_conductor,
                    'monto_esp_empresa'=>$monto_esp_empresa,
                    'monto_esp_conductor'=>$monto_esp_conductor,
                    'observaciones'=>"'".$observaciones."'",
                    'departamento_id'=>$departamento_id,
                    'lista_id'=>$lista_id,
                    'recargo_porc'=>$txtRecargo,
                    'nsolicitud'=>"'".$txtSolicitud."'"




                    );

$sql="SELECT nextval('viajes_id_seq') AS id";
$result=pg_query($sql);
$arr=pg_fetch_array($result);
$idViaje=$arr['id'];

if(isset ($hay_retorno)){
    $retorno=1;
}

$viajeModel['id']=$idViaje;
//$viajeModel['retorno']=$retorno;
$viajeModel['conductor_id']=$selectConductor;
$viajeModel['departamento_id']=$selectDepartamento;
$viajeModel['ruta_id']=$selectRuta;

$ruta = $viaje->getDescripcionTable("rutas", $selectRuta, "descripcion"); 
$viajeModel['ruta']="'".$ruta."'";
$viajeModel['fecha']="'".$txtFechaViaje."'";

//$viaje->begin();

if($viaje->save("viajes",$viajeModel))
{
    //REGISTRANDO PASAJEROS

    if($pasajerosviaje){
        foreach($pasajerosviaje as $pasajerov){

            $sql="SELECT nextval('pasajeros_viajes_id_seq') AS id";
            $result=pg_query($sql);
            $arr=pg_fetch_array($result);
            $idpv=$arr['id'];
            //echo $idpv;

            $reg['id']=$idpv;
            $reg['viaje_id']=$idViaje;
            $reg['pasajero_id']=$pasajerov;
            $r=$viaje->save("pasajeros_viajes",$reg);
            if($r==false){
                $rs="false";
                break;
            }

        }
    }
    
   

    //REGISTRANDO MOVILIZACIONES
    if($rs!="false"){



        if($movilizaciones_r!=false){
            while($regm=pg_fetch_assoc($movilizaciones_r)){
                        //print_r($regm);
                $sql="SELECT nextval('movilizaciones_id_seq') AS id";
                $result=pg_query($sql);
                $arr=pg_fetch_array($result);
                $idm=$arr['id'];

                $regm['id']=$idm;
                $regm['viaje_id']=$idViaje;
                $regm['descripcion']="'".$regm['descripcion']."'";
                $r=$viaje->save("movilizaciones",$regm);
                if($r==false){
                    $rs="false";
                    break;
                }

            }
        }
    }


    if($r=="true"){
        
        
        $response['success'] = "true";
        $response['viaje'] = $idViaje;
        
    }

   echo json_encode($response);
   
}else{
    $rs="false";
    echo $rs;
}

cerrarConexion();

?>
