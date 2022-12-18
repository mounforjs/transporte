<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;
abrirConexion();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$r = "";
$lista = new Lista();
$list = $lista->getOrdererList("listas",300, " ORDER BY id DESC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        switch ($estado){
            case 1:
                $estadolink = "<a id='$id' name='estado'>Desactivar</a>";
                break;
            case 0:
                $estadolink = "<a id='$id' name='estado'>Activar</a>";
                break;
        }

        $r.="<tr id=$id>
        <td width='25px'>$id&nbsp;</td>
        <td width='150px'>$descripcion&nbsp;</td>
        <td width='120px'>$fecha&nbsp;</td>
        <td width='30px'>$hora_espera Bs&nbsp;</td>
        <td width='60px'>$hora_espera_conductor Bs&nbsp;</td>
        <td width='80px'>$movilizaciones Bs.</td>
        <td width='220px'><a id='".$id."' name='visualizarLista' href='visualizarLista.php?id=$id'>Visualizar lista</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id='".$id."' name='editar'>Editar</a>&nbsp;&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a>&nbsp;&nbsp;&nbsp;$estadolink</td>
      </tr>";
    }
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

