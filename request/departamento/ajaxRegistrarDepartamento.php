<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;

extract($_POST);

abrirConexion();
$model=new model();
$arr=array('nombre'=>"'".$txtNombre."'",'codigo'=>"'".$txtCodigo."'",'empresa_id'=>$selectEmpresa);

if($model->save("departamentos",$arr))
{
   echo "ok";
}else{
   echo "false";
}

cerrarConexion();

?>
