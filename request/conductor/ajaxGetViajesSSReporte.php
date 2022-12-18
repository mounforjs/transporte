<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();
extract($_POST);
$r="";
$viaje=new Viaje();

$query="SELECT conductores.nombre as conductor,viajes.id as id,viajes.ruta,viajes.fecha as fecha,pasajeros.nombre as pasajero,viajes.observaciones as observaciones,viajes.encomienda as encomienda 
        FROM ((conductores INNER JOIN viajes ON (conductores.id=viajes.conductor_id)) FULL JOIN pasajeros_viajes ON
		      (pasajeros_viajes.viaje_id=viajes.id)) FULL JOIN pasajeros ON
			  (pasajeros.id=pasajeros_viajes.pasajero_id)
        WHERE viajes.solicitud_servicio=1 and viajes.estado=3
		ORDER BY pasajeros.nombre ASC
		";
		
		

$list=pg_query($query);

if($list!=false) {
    $r.="<tr class='tableTitle'>
            <td>ID</td>
			<td>Condutor</td>
            <td>Pasajero</td>
			<td>Tipo</td>
            <td>Fecha</td>
            <td>Ruta</td>
          </tr>";

    while($row=pg_fetch_array($list)) {

        extract($row);
		
		if($pasajero=='')
		{
			$pasajero=$observaciones;
		}
		
		if($encomienda==1){
			$tipo="E";
		}else{
			$tipo="P";
		}
		
        $r.="<tr id=$id>
        <td>$id</td>
        <td>$conductor</td>
		<td>$pasajero</td>
		<td>$tipo</td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$ruta</td>
      </tr>";

    }

    $r.="<br><br>";

}else {
    $r="<tr><td colspan=8><td></tr><tr><td colspan=4>No existen viajes sin solicitud de servicio<td></tr>";
}

cerrarConexion();


echo $r;
?>

