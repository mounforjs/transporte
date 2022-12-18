<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/pasajero.php';
require DB;

extract($_POST);

if(isset($_SESSION['nmovilizacionesEdit'])){
    $nmovilizaciones=$_SESSION['nmovilizacionesEdit'];
    $nmovilizaciones+=1;
}else{
    $nmovilizaciones=1; 
}

$arr=array('id'=>$nmovilizaciones,'descripcion'=>$txtDescripcion,
           'viaje_id'=>$_SESSION['viajeIdEdit'],'precio'=>$txtPrecio,'pago'=>$txtPago);
$_SESSION['movilizacionesEdit'][]=$arr;

$_SESSION['nmovilizacionesEdit']=$nmovilizaciones;

$r="<tr id=movilizacion".$nmovilizaciones.">
        <td>".$txtDescripcion."</td>
        <td><a name='eliminarMovilizacion' id=$nmovilizaciones>Eliminar</a></td>
      </tr>";

echo $r;

?>
