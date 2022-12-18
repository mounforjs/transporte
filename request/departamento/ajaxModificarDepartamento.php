<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/pasajero.php';
require_once DB;

extract($_POST);

abrirConexion();
$pasajero=new Pasajero();
$arr=array('nombre'=>"'".$txtNombre."'",'codigo'=>"'".$txtCodigo."'",'empresa_id'=>$selectEmpresa);

if($pasajero->update("departamentos", "id", $arr, $_SESSION['idDepartamento']))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
