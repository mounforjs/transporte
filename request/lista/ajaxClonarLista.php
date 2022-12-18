<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;

/*ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);*/

abrirConexion();
$listaAclonar = 57;
extract($_POST);

$r = "";
$lista = new Lista();
$descripcion = "AGENCIA ABRIL 2016";
$lista->clonarLista($listaAclonar,  $descripcion, 0.35);

cerrarConexion();

echo $r;
?>