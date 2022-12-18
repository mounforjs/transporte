<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/viaje.php';
require_once DB;

extract($_POST);

abrirConexion();
$viaje=new Viaje();
$viaje->delete("viajes", "ruta", "'nuevo'"); //Borrandos guias que no culminaron el registro
$arr=array('ruta'=>"'nuevo'");

$arr_response = array();

if($viaje->save("viajes",$arr))
{
   $id=$viaje->getId("viajes", "ruta", "'nuevo'");
   $_SESSION['viajeId']=$id;
   $arr_response['response'] = "ok";	
   $arr_response['id'] = $id;
   

}else{
    $arr_response['response'] = "false";
}

echo json_encode($arr_response); 

cerrarConexion();

?>
