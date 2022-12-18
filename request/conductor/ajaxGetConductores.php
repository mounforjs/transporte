<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/conductor.php';
require_once DB;
abrirConexion();

$r="";
$conductor=new Conductor();
$list=$conductor->getListCondicional("conductores",500,"id!=000 ORDER BY nombre DESC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        $r.="<tr id=$id>
        <td>$id</td>
        <td>$cedula&nbsp;</td>
        <td>$nombre&nbsp;</td>
        <td>$direccion&nbsp;</td>
        <td>$vehiculo&nbsp;</td>
        <td><a id='".$id."' name='eliminar'>Eliminar</a>&nbsp;&nbsp;&nbsp;<a id='".$id."' name='editar'>Editar</a>&nbsp;&nbsp;&nbsp;<a id='".$id."' name='ver'>Ver</a></td>
      </tr>";
    }
}
cerrarConexion();

echo $r;
?>

