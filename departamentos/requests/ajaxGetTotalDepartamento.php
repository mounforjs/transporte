<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();
extract($_POST);

$viaje=new Viaje();
//$desde=$viaje->convertFechaSQLPostgres($desde);
//$hasta=$viaje->convertFechaSQLPostgres($hasta);

if(!isset($departamento_id)){
    $departamento_id=$viaje->getDescripcionTableCondicional("departamentos", "nombre='$departamento'", "id");
}

$total=$viaje->getTotalCondicionado("viajes", "monto_viaje", "departamento_id=$departamento_id");

echo "<span class='titulo marleft30'><strong>TOTAL: </strong>".number_format($total,2,",",".")." Bs</span>";
?>

