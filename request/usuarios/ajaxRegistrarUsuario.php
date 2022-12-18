<?php
session_start();
require_once '../../rutas.php';
require_once DB;
abrirConexion();

$password=md5($_POST['password']);
$query="INSERT INTO users (username,rol,nombre,password) values ('".$_POST['username']."','".$_POST['rol']."','".$_POST['nombre']."','".$password."')";
$result=pg_query($query);
if($result){
    $r="true";
}else{
    $r="false";
}

echo $r;

cerrarConexion();
?>
