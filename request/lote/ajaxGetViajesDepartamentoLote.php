<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="<tr class='tableTitle'>
    <td>ID</td>
    <td></td>
    <td>Fecha</td>
    <td>Conductor</td>
    <td>Ruta</td>
    <td>Precio</td>
    <td>Pago</td>
    <td>Acciones</td>
</tr>";
$lote=new lote();

if(isset($departamento)){
    $list=$lote->getListCondicional("viajes",500,"lote_id=$id and departamento_id=$departamento ORDER BY fecha ASC");
}else{
    $list=$lote->getListCondicional("viajes",500,"lote_id=$id ORDER BY fecha ASC");
}


$totalLote=$lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
$totalLoteConductor=$lote->getTotalCondicionado("viajes", "monto_pago", "lote_id=".$id);


if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);
        $conductor=$lote->getDescripcionTable("conductores", $conductor_id, "nombre");

        if ($solicitud_servicio == 1) {
           $idString = "<td bgcolor='#4d484d' class='viajes_ss'>* $id</td>";
        }else{
           $idString = "<td>$id</td>";
        }

        $r.="<tr id=$id>
        <td><input id='$id' type='checkbox' name='chkviajes[]' value='$id'>&nbsp;$idString</td>
        <td>".$lote->fechaVE($fecha)."</td>
        <td>$conductor</td>
        <td>$ruta</td>".

       "<td>".number_format($monto_viaje,2,",",".")." Bs.</td>
        <td>".number_format($monto_pago,2,",",".")." Bs.</td>
        <td><a href='../../pagina/viaje/editarViaje.php?id=$id' target='_blank'>Editar</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Sacar del Lote</a></td>
      </tr>";
    }
}else{
    $r.="<tr><td colspan='5'>No existen viajes registrados en este lote aún.</td></tr>";
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

