<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);
$r = "";
$lote = new lote();
$list = $lote->getListCondicional("viajes",500,"lote_id=$id ORDER BY id ASC");
$totalLote = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
$totalLoteConductor = $lote->getTotalCondicionado("viajes", "monto_pago", "lote_id=".$id);

$r = "</tr><tr class='tableTitle'>
<td width='6px'>ID</td>
<td width='6px'>N.S</td>
<td width='50px'></td>
<td width='80'>Fecha</td>
<td width='70'>Conductor</td>

<td width='30'>E</td>
<td width='30'>R</td>
<td width='30'>Porc</td>
<td width='30'>Nº P</td>
<td width='30'>Nº M</td>
<td width='30'>Monto Mov.</td>
<td>Ruta</td>
<td width='15' >Monto Base</td>
<td width='15' >Adicional (B)</td>
<td width='15' >% Bs</td>
<td width='15' >Total</td>
<td width='220'>Acciones</td>
</tr>";

if($list != false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$lote->getDescripcionTable("conductores", $conductor_id, "nombre");

        if ($solicitud_servicio == 1) {
           $idString = "<td bgcolor='#4d484d' class='viajes_ss'><a target='_blank' name='viewviaje' id='$id'>* $id</a></td>";
        }else{
           $idString = "<td><a target='_blank' name='viewviaje' id='$id'> $id</a></td>";
        }
        
        
        $nummovilizaciones=$lote->count("movilizaciones", "id", "viaje_id=".$id);

        //ENCONTRANDO A LOS PASAJEROS

        
        $pasajerosIDS=$lote->getListCondicional("pasajeros_viajes", 500, "viaje_id=".$row['id']);
        $pasajeroText="";
       
        
        
        $i=0;
        if($pasajerosIDS){
            
            while($reg=pg_fetch_array($pasajerosIDS)){

                $pasajeroText = $lote->getDescripcionTable("pasajeros", $reg['pasajero_id'], "nombre");
                if($i==0){
                    $pasajerosText = $pasajeroText;
                }else{
                    $pasajerosText.= ",".$pasajeroText;
                }

                $i++;
            }
            
        }else{
            $pasajeroText = "";
        }
        
        if($encomienda==1){
            $enc = "Si";
        }else{
            $enc = "No";
        }

        if($retorno==1){
            $ret = "Si";
        }else{
            $ret = "No";
        }
        
        

        $r.="<tr id=$id>
        <td><input id='$id' type='checkbox' name='chkviajes[]' value='$id'>&nbsp;$idString</td>

        <td>".$nsolicitud."</td>
         <td>".$lote->fechaVE($fecha)."</td>
        <td>$conductor</td>
        
        <td>$enc</td>
        <td>$ret</td>
        <td>$recargo_porc</td>
        <td>$numero_pasajeros</td>
        <td>$numero_movilizaciones</td>
        <td>$total_monto_movilizaciones Bs.</td>
        <td>$ruta</td>".
        "<td>".number_format($monto_esp_empresa,2,",",".")." Bs.</td>".
        "<td>".number_format($adicional,2,",",".")." Bs.</td>".
        "<td>".number_format(($monto_esp_empresa*$recargo_porc)/100,2,",",".")." Bs.</td>".
       "<td>".number_format($monto_viaje,2,",",".")." Bs.</td>
        <td><a href='../../pagina/viaje/editarViaje.php?id=$id' target='_blank'>Editar</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Sacar del Lote</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar-viaje'>Eliminar</a>&nbsp;&nbsp;<a id='".$id."' name='clonarViaje3'>Clonar3</a>&nbsp;&nbsp;<a id='".$id."' name='editarViaje3'>Editar Viaje3</a>&nbsp;&nbsp;</td>
      </tr>";
    }
}else{
    $r="<tr><td colspan='7'>No existen viajes registrados en este lote aún.</td></tr>";
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

