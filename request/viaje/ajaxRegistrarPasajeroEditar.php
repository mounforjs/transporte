<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once CLASES.'/pasajero.php';
require DB;

extract($_POST);
$pasajero=new Pasajero();
abrirConexion();
$nombrePasajero=$pasajero->getDescripcionTable("pasajeros",$selectPasajero,"nombre");
$telefonoPasajero=$pasajero->getDescripcionTable("pasajeros",$selectPasajero,"telefono");
cerrarConexion();

$arr=array('pasajero_id'=>$selectPasajero,
           'viaje_id'=>$_SESSION['viajeIdEdit']);

$_SESSION['pasajerosEdit'][]=$arr;

$r="<tr id=pasajero".$selectPasajero.">
        <td>".$nombrePasajero."</td>
        <td>".$telefonoPasajero."</td>
        <td><a name='eliminarPasajero' id=$selectPasajero>Eliminar</a></td>
      </tr>";

echo $r;

?>
