<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once DB;
abrirConexion();

$r="";
$viaje=new Viaje();


$query="SELECT conductores.id as conductor,conductores.nombre as nombre,count(viajes.id)
        FROM conductores INNER JOIN viajes
                ON (conductores.id=viajes.conductor_id)
        WHERE viajes.lote_id=0 and viajes.estado=3
        GROUP BY conductores.id,conductores.nombre
        HAVING count(viajes.id)>=1 ORDER BY conductores.nombre ASC";

$result=pg_query($query);

while($cond=pg_fetch_array($result)){
    extract($cond);
    $list=$viaje->getListCondicional("viajes",80,"estado=3 and lote_id=0 and conductor_id=$conductor ORDER BY fecha DESC");
    $r.="<tr class='tableTitle'><td colspan=8>&nbsp;&nbsp;$nombre</td></tr>";

    while($row=pg_fetch_array($list)){
        
        extract($row);
		$empresa=$viaje->getDescripcionTable("empresas", $empresa_id, "nombre");
        $conductor=$viaje->getDescripcionTable("conductores", $conductor_id, "nombre");
        switch($estado){
            case 1:$estado="Planificado";
            break;
            case 2:$estado="En Curso";
            break;
            case 3:$estado="Terminado";
            break;
            case 4:$estado="Cancelado";
            break;
        }

        switch($encomienda){
            case 1:$encomienda="E";
            break;
            case 0:$encomienda="P";
            break;
        }

        if($encomienda=="P"){
            $query="SELECT *
                    FROM pasajeros_viajes
                    WHERE viaje_id=".$row['id']." LIMIT 1";

            $result2=pg_query($query);
            $arrModel=pg_fetch_array($result2);
            $pasajero_id=$arrModel['pasajero_id'];
            if($pasajero_id!=""){
                $pasajero=$viaje->getModel($pasajero_id, "pasajeros");
                $pasajero_nombre=$pasajero['nombre'];
            }else{
                $pasajero_nombre="Ninguno";
            }
            
        }else{
            $pasajero_nombre=$observaciones;
        }

        

        if($solicitud_servicio==0) {
            $trSolicitud="<td bgcolor='#3B79B3'>CS</td>";
        }else {
            $trSolicitud="<td bgcolor='#C22727'>SS</td>";
        }

        $r.="<tr id=$id>
        <td><input id='$id' type='checkbox' name='chkviajes[]' value='$id'>&nbsp;<a id='$id' name='viewviaje' target='_blank'>$id</a></td>
        <td>".$viaje->fechaVE($fecha)."</td>
        <td>$ruta</td>
		<td>$empresa</td>
        ".$trSolicitud."
                <td>$encomienda</td>
                <td>$pasajero_nombre</td>
                
        <td><a href='editarViaje.php?id=$id' target='_blank'>Editar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a></td>";
        
        
    }

}

cerrarConexion();

echo $r;
?>

