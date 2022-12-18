<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/ruta.php';
require_once DB;
abrirConexion();

$r="";
$ruta=new Ruta();
$list=$ruta->getList("rutas",2000);

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        $r.="<tr id=$id>
        <td>$id&nbsp;</td>
        <td>$descripcion&nbsp;</td>
        <td><a id='".$id."' name='eliminar'>Eliminar</a></td>
      </tr>";
    }
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

