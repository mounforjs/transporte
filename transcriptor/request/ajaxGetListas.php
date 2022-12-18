<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;
abrirConexion();

$r="";
$lista=new Lista();
$list = $lista->getOrdererList("listas",300, " ORDER BY id DESC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        switch ($estado){
            case 1:
                $estadolink="<a id='$id' name='estado'>Desactivar</a>";
                break;
            case 0:
                $estadolink="<a id='$id' name='estado'>Activar</a>";
                break;
        }

        $r.="<tr id=$id>
        <td>$id&nbsp;</td>
        <td>$descripcion&nbsp;</td>
        <td>$fecha&nbsp;</td>
        <td><a id='".$id."' name='visualizarLista' href='/transcriptor/visualizarLista.php?id=$id'>Visualizar lista</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id='".$id."' name='editar'>Editar</a>&nbsp;&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a>&nbsp;&nbsp;&nbsp;$estadolink</td>
      </tr>";
    }
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

