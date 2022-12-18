<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;

extract($_POST);

abrirConexion();
$conductor=new Conductor();
$arr=array('nombre'=>"'".$txtNombre."'",'telefono'=>"'".$txtTelefono."'",'direccion'=>"'".$txtDireccion."'",'vehiculo'=>"'".$txtVehiculo."'",'cedula'=>"'".$txtCedula."'");

if($conductor->save("conductores",$arr))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
