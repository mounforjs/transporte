<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/pasajero.php';
require_once DB;
abrirConexion();

$r="";
$pasajero=new pasajero();
$list=$pasajero->getListCondicional("pasajeros",500,"id!=000 ORDER BY nombre ASC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        $empresa=$pasajero->getDescripcionTable("empresas", $empresa_id, "nombre");
        
        $r.="<tr id=$id>
        <td>$id&nbsp;</td>
        <td>$nombre&nbsp;</td>
        <td>$telefono&nbsp;</td>
        <td>$direccion&nbsp;</td>
        <td>$empresa&nbsp;</td>
        <td>$departamento&nbsp;</td>
        <td><a id='".$id."' name='eliminar'>Eliminar</a>&nbsp;&nbsp;<a id='".$id."' name='editar'>Editar</a></td>
      </tr>";
    }
}
cerrarConexion();
//<a id='".$id."' name='editarpasajero' href='../pagina/editUsuario.php?idpasajero=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

