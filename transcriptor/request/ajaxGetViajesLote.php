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


$r="</tr><tr class='tableTitle'>
<td width='6px'></td>
<td width='6px'>ID</td>
<td width='6px'>N.S</td>
<td width='50px'></td>
<td width='80px'>Fecha</td>
<td width='70px'>Conductor</td>

<td width='30px'>E</td>
<td width='30px'>R</td>

<td width='30px'>Nº P</td>
<td width='30px'>Nº M</td>
<td>H.E</td>
<td width='30px'>Modalidad</td>
<td width='120px'>Ruta</td>
<td width='180px'>Acciones</td>
</tr>";

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$lote->getDescripcionTable("conductores", $conductor_id, "nombre");

        if ($solicitud_servicio == 1) {
           $idString = "<td bgcolor='#4d484d' class='viajes_ss'><a target='_blank' name='' id='$id'>* $id</a></td>";
        }else{
           $idString = "<td><a target='_blank' name='' id='$id'> $id</a></td>";
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

        switch ($recargo_porc) {

                case '0':
                    $modalidad = "Ninguna";
                    break;
                case '30':
                    $modalidad = "Nocturno o Feriado";
                    break;
                case '60':
                    $modalidad = "Nocturno y Feriado";
                    break;
                case '40':
                    $modalidad = "Encomienda";
                    break;
                
                default:
                    $modalidad = "Ninguna";
                    break;
            }
        
        

        $r.="<tr id=$id>
        <td><input id='$id' type='checkbox' name='chkviajes[]' value='$id'>&nbsp;$idString</td>
        <td>".$id."</td>
        <td>".$nsolicitud."</td>
         <td>".$lote->fechaVE($fecha)."</td>
        <td>$conductor</td>
        
        <td>$enc</td>
        <td>$ret</td>

        <td>$numero_pasajeros</td>
        <td>$numero_movilizaciones</td>
        <td>$horas_espera_double</td>
        <td >$modalidad</td>
        <td width='120px'>$ruta</td>".
    
        "<td><a id='".$id."' name='eliminar-viaje'>Eliminar</a>&nbsp;&nbsp;<a id='".$id."' name='clonarViaje3'>Clonar3</a>&nbsp;&nbsp;<a id='".$id."' name='editarViaje3'>Editar Viaje3</a>&nbsp;&nbsp;</td>
      </tr>";
    }
}else{
    $r="<tr><td colspan='7'>No existen viajes registrados en este lote aún.</td></tr>";
}

cerrarConexion();

echo $r;

?>

