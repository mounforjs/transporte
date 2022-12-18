<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;
abrirConexion();

$r="";
$lista = new Lista();
$lista_id = $_SESSION['idLista'];
$list = $lista->getListCondicional("listas_rutas",500,"lista_id=".$lista_id." ORDER BY ruta ASC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        $r.="<tr id=$id>
        <td>$id</td>
        <td>$ruta</td>
        <td>".number_format($precio,2,",",".")." Bs.</td>
        <td>".number_format($precio_conductores,2,",",".")." Bs.</td>
        <td><a id='".$id."' name='editar'>Editar</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a></td>
      </tr>";
    }
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

