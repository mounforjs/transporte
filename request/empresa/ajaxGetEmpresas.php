<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/empresa.php';
require_once DB;
abrirConexion();

$r="";
$empresa=new Empresa();
$list=$empresa->getListCondicional("empresas",30,"id!=000 ORDER BY nombre ASC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        $r.="<tr id=$id>
        <td>$id&nbsp;</td>
        <td>$nombre&nbsp;</td>
        <td>$rif&nbsp;</td>
        <td>$direccion&nbsp;</td>
        <td><a id='".$id."' name='editar'>Editar</a>&nbsp;&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a></td>
      </tr>";
    }
}
cerrarConexion();


echo $r;
?>

