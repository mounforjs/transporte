<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/model.php';
require_once DB;

abrirConexion();

$model = new model();


$qstring = "SELECT ruta ,ruta_id, precio FROM listas_rutas WHERE lista_id=".$_POST['lista']." and ruta_id=".$_POST['ruta'];
$result = pg_query($qstring);


$row = pg_fetch_array($result);

echo json_encode($row);

?>

