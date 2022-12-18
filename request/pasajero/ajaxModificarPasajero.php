<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/pasajero.php';
require_once DB;

extract($_POST);

abrirConexion();
$pasajero=new Pasajero();
$arr=array('nombre'=>"'".$txtNombre."'",'telefono'=>"'".$txtTelefono."'",'direccion'=>"'".$txtDireccion."'",'empresa_id'=>$selectEmpresa,'email'=>"'".$txtEmail."'",'departamento_id'=>$selectDepartamento);

if($pasajero->update("pasajeros", "id", $arr, $_SESSION['idPasajero']))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
