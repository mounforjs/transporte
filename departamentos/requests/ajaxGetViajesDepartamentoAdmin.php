<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="<tr class='tableTitle'>
    <td>ID</td>
    <td>Fecha</td>
    <td>Ruta</td>
    <td>T. Viaje</td>
    <td>Pasajeros /S. Encomienda</td>
    <td>Pago</td>
</tr>";

$lote=new lote();
$list="";
$total=0;

if(isset($departamento_id)){
    $list=$lote->getListCondicional("viajes",500,"departamento_id=$departamento_id ORDER BY fecha ASC");
}

if($list!=false){

    while($row=pg_fetch_array($list)){

        extract($row);
       
        $estadoLote=$lote->getDescripcionTableCondicional("lotes", "id=$lote_id", "estado");

        if($encomienda!=1){

                $tipo_viaje="Personal";
            
                $query="SELECT *
                        FROM pasajeros_viajes
                        WHERE viaje_id=".$row['id']." LIMIT 1";

                $result2=pg_query($query);
                $arrModel=pg_fetch_array($result2);
                $pasajero_id=$arrModel['pasajero_id'];
                if($pasajero_id!=""){
                    $pasajero=$lote->getModel($pasajero_id, "pasajeros");
                    $pasajero_nombre=$pasajero['nombre'];
                }else{
                    $pasajero_nombre="Ninguno";
                }

            }else{
                $pasajero_nombre=$observaciones;
                $tipo_viaje="Encomienda";
            }


            if($estadoLote==1){
               $total+=$monto_viaje;
                $r.="<tr id=$id>
                        <td>$id</td>
                        <td>".$lote->fechaVE($fecha)."</td>
                        <td>$ruta</td>".
                        "<td>$tipo_viaje</td>".
                        "<td>$pasajero_nombre</td>".
                       "<td>".number_format($monto_viaje,2,",",".")." Bs.</td>
                      </tr>";
            }
        
    }
}else{
    $r.="<tr><td colspan='5'>No existen viajes registrados en este lote aún.</td></tr>";
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;
$r.="&&&"."<span class='titulo marleft30'><strong>TOTAL: </strong>".number_format($total,2,",",".")."</span>";
echo $r;
?>

