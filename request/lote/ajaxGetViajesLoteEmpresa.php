<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);

$r="";
$lote=new lote();
$list=$lote->getListCondicional("viajes",500,"lote_id=$id ORDER BY id ASC");
$totalLote=$lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
$totalLoteConductor=$lote->getTotalCondicionado("viajes", "monto_pago", "lote_id=".$id);


if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$lote->getDescripcionTable("conductores", $conductor_id, "nombre");


        //NUMERO DE MOVILIZACIONES DEL VIAJE

        $nummovilizaciones=$lote->count("movilizaciones", "id", "viaje_id=".$id);

        //ENCONTRANDO A LOS PASAJEROS

        $pasajerosIDS=$lote->getListCondicional("pasajeros_viajes", 500, "viaje_id=".$id);
        $pasajerosText="";
        $i=0;

        if($pasajerosIDS){
            while($reg=pg_fetch_array($pasajerosIDS)){

                $pasajeroText=$lote->getDescripcionTable("pasajeros", $reg['pasajero_id'], "nombre");
                if($i==0){
                    $pasajerosText=$pasajeroText;
                }else{
                    $pasajerosText.=",".$pasajeroText;
                }

                $i++;
            }
        }
        ////////////////////////

        if($encomienda==1){
            $trTitle="Encomienda";
            $trEncomiendaOPasajeros="<td>$observaciones</td>";
            $trIva="<td>".number_format(($monto_viaje*0.12),2,",",".")." Bs </td>";
            $trTotal="<td>".number_format($monto_viaje+(($monto_viaje*12)/100),2,",",".")." Bs </td>";
        }else{
            $trTitle="Pasajeros";
            $trEncomiendaOPasajeros="<td>$pasajerosText</td>";
            $trIva="<td>".number_format(0,2,",",".")." Bs </td>";
            $trTotal="<td>".number_format($monto_viaje,2,",",".")." Bs </td>";
        }

        ////////////////////////////
        if($departamento_id==""){
            $codigoDepartamento="N/A";
        }else{
            $codigoDepartamento=$lote->getDescripcionTable("departamentos", $departamento_id, "codigo");
        }

        if ($solicitud_servicio == 1) {
           $idString = "<td bgcolor='#4d484d' class='viajes_ss'>* $id</td>";
        }else{
           $idString = "<td>$id</td>";
        }

        $r.="<tr id=$id>
        $idString
        <td>".$lote->fechaVE($fecha)."</td>
        <td>".$codigoDepartamento."</td>
        <td>$ruta</td>
        $trEncomiendaOPasajeros
        <td>$horas_espera</td>
        <td>$nummovilizaciones</td>".
        "<td>".number_format($monto_viaje,2,",",".")." Bs </td>".
        $trIva.
        $trTotal."
      </tr>";
    }
}else{
    $r="<tr><td colspan='4'>No existen viajes registrados en este lote aún.</td></tr>";
}

        //DEFINIENDO EL ENCABEZADO 
        $title="<tr>
               <td colspan='8'></td>
            </tr>
        <tr class='tableTitle'>
            <td width='50px'>ID</td>
            <td width='80'>Fecha</td>
            <td width='80'>Dpto</td>
            <td width='150'>Ruta</td>
            <td width='150'>$trTitle</td>
            <td width='15' >H.E.</td>
            <td width='10'>M.</td>
            <td width='95'>Monto</td>
            <td width='95'>IVA</td>
            <td width='100'>Total</td>
        </tr>";

$table=$title.$r;

cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $table;
?>

