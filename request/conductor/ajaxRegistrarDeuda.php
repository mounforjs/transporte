<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;

extract($_POST);

abrirConexion();
$conductor=new Conductor();
$arr=array('observaciones'=>"'".$txtConcepto."'",'conductor_id'=>"'".$idConductor."'",'monto'=>"'".$txtMonto."'",'fecha'=>"current_date");

if($conductor->save("deudas",$arr))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
