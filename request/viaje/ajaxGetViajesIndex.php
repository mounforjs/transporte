<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$list=$viaje->getList("viajes",30);

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$viaje->getDescripcionTable("conductores", $conductor_id, "nombre");
        switch($estado){
            case 1:$estado="Planificado";
            break;
            case 2:$estado="En Curso";
            break;
            case 3:$estado="Realizado";
            break;
        }

        $r.="<tr id=$id>
        <td>$id</td>
        <td>$fecha</td>
        <td>$conductor</td>
        <td>$ruta</td>
        <td>$estado</td>
        <td><a id='".$id."' name='eliminar'>Eliminar</a></td>
      </tr>";
        
    }
}

cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

