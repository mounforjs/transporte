<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="<table id='tablaViajes' cellspacing='0' width='800'>
    <tr>
        <td colspan='5'></td>
    </tr>
    <tr class='tableTitle'>
        <td>ID</td>
        <td>Fecha</td>
        <td>Conductor</td>
        <td>Ruta</td>
        <td>Lote</td>
    </tr>
    <tr>
        <td colspan='5'></td>
    </tr>";

$viaje=new Viaje();
$list=$viaje->getListCondicional('viajes',1,"id=$id");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$viaje->getDescripcionTable('conductores', $conductor_id, 'nombre');
        switch($estado){
            case 1:$estado='Planificado';
            break;
            case 2:$estado='En Curso';
            break;
            case 3:$estado='Terminado';
            break;
            case 4:$estado='Cancelado';
            break;
        }

        $r.="<tr id=$id>
        <td><a href='visualizarViaje.php?id=$id' target='_blank'>$id</a></td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$conductor</td>
        <td>$ruta</td>
        <td><a href='../lote/visualizarLote.php?id=$lote_id' target='_blank'>$lote_id</a></td>";
        
    }
}else{
    $r="<td colspan=6>No existen vijes con el ID ingresado</td>";
}

cerrarConexion();


echo $r;
?>

