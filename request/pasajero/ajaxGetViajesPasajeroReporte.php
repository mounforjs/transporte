<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();
extract($_POST);
$r="";
$viaje=new Viaje();
$ndesde=$desde;
$nhasta=$hasta;
$desde=$viaje->convertFechaSQLPostgres($desde);
$hasta=$viaje->convertFechaSQLPostgres($hasta);
$query="SELECT viajes.id as id,viajes.monto_viaje,viajes.fecha as fecha,viajes.horas_espera as horas,viajes.retorno ,viajes.ruta as ruta from viajes
        INNER JOIN pasajeros_viajes ON (viajes.id=pasajeros_viajes.viaje_id)
        WHERE pasajero_id=$selectPasajero AND fecha BETWEEN $desde and $hasta ORDER BY fecha ASC";

$list=pg_query($query);

//$list=$viaje->getListCondicional("pasajeros_viajes",100,"estado=3 and pasajero_id=$selectPasajero and fecha BETWEEN $desde and $hasta ORDER BY fecha ASC");

if($list!=false) {
    $r.="<tr class='tableTitle'>
            <td>ID</td>
            <td>Fecha</td>
            <td>Ruta</td>
			<td>H.E</td>
			<td>Mov.</td>
			<td>Retorno</td>
            <td>Monto</td>
          </tr>";

    while($row=pg_fetch_array($list)) {

        extract($row);
		$nmov=$viaje->count("movilizaciones","id","viaje_id=".$id);
		
		if($retorno==1){
			$retornoString="Si";
		}else{
			$retornoString="No";
		}
		
        $r.="<tr id=$id>
        <td><a href='visualizarViaje.php?id=$id'>$id</a></td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$ruta</td>
		<td>$horas</td>
		<td>$nmov</td>
		<td>$retornoString</td>
        <td>".number_format($monto_viaje,2,",",".")." Bs </td>
      </tr>";

    }

    $r.="<br><br>";

}else {
    $r="<tr><td colspan=7><td></tr><tr><td colspan=4>No existen viajes de este conductor en este periodo de tiempo.<td></tr>";
}

cerrarConexion();


echo $r;
?>

