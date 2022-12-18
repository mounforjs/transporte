<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/empresa.php';
require_once DB;

extract($_POST);

abrirConexion();
$empresa=new Empresa();
$fecha=date("d/m/Y");
$fecha=$empresa->convertFechaSQLPostgres($fecha);
$arr=array('nombre'=>"'".$txtNombre."'",'rif'=>"'".$txtRif."'",'direccion'=>"'".$txtDireccion."'");

if($empresa->update("empresas", "id", $arr, $_SESSION['idEmpresa']))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
