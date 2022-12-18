<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once CLASES.'/model.php';
require_once DB;
abrirConexion();

$r = "";
$lista = new model();
$lista_id = $_POST['lista'];
$list = $lista->getListCondicional("listas_rutas", 500, "lista_id=".$lista_id." ORDER BY id DESC");

		

if( $list!= false ){

    while( $row = pg_fetch_array($list))
    {
        extract($row);

        $r.="<tr id=$id>
        <td>$id</td>
        <td>$ruta</td>
        <td><a id='".$id."' name='editar'>Editar</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a></td>
      </tr>";

    }

}

cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

