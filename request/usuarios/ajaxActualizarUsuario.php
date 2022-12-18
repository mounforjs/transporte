<?php
session_start();
require_once '../../rutas.php';
require_once DB;

$r="true";

abrirConexion();
$query="UPDATE users SET username='".$_POST['username']."', rol='".$_POST['rol']."', nombre='".$_POST['nombre']."'  WHERE id=".$_POST['id'];
$result=pg_query($query);

if($result){
    $r="true";
}else{
    $r="false";
}

cerrarConexion();

echo $r;

?>
