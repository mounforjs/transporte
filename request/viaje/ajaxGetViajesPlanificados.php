<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();
$list=$viaje->getListCondicional("viajes",80,"estado=1 ORDER BY fecha DESC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$viaje->getDescripcionTable("conductores", $conductor_id, "nombre");
		$empresa=$viaje->getDescripcionTable("empresas", $empresa_id, "nombre");
		$pasajero_id=$viaje->getDescripcionTableCondicional("pasajeros_viajes", "viaje_id=$id", "pasajero_id");
		
		if($pasajero_id!=false){
			$pasajero=$viaje->getDescripcionTable("pasajeros", $pasajero_id, "nombre");
		}else{
			$pasajero="Encomienda";
		}
		

        $r.="<tr id=$id>
        <td><a id='$id' name='viewviaje'>$id</a></td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$conductor</td>
        <td>$ruta</td>
		<td>$empresa</td>
		<td>$pasajero</td>
        <td><a href='viaje/editarViaje.php?id=$id' target='_blank'>Editar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id='".$id."' id='enCurso' name='enCurso'>Viaje en Curso</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a></td>
      </tr>";
        
    }
}else{
    $r="<tr><td colspan=5>No existen viajes planificados.</td></tr>";
}

cerrarConexion();

echo $r;
?>

