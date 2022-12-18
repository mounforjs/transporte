<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/destino.php';
require_once DB;
abrirConexion();

$r="";
$destino=new Destino();
$list=$destino->getListCondicional("destinos",300,"id!=000 ORDER BY descripcion DESC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $estado=$destino->getDescripcionTable("estados", $estado_id, "nombre");

        $r.="<tr id=$id>
        <td>$id</td>
        <td>$descripcion</td>
        <td>$estado</td>
        <td><a id='".$id."' name='eliminar'>Eliminar</a></td>
      </tr>";
    }
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

