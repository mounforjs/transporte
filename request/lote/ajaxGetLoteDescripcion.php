<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="<fieldset>";
$lote=new lote();
$nombreLote=$lote->getDescripcionTable("lotes", $id, "descripcion");
$totalLote=$lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
$totalLoteConductor=$lote->getTotalCondicionado("viajes", "monto_pago", "lote_id=".$id);
$diferencia=$totalLote-$totalLoteConductor;


$montoLote=$lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
                            
$montoLoteTrasladoPersonal = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id." and encomienda=0");
$montoLoteEncomienda = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id." and encomienda=1");

$subtotal = $montoLoteTrasladoPersonal+$montoLoteEncomienda;

/*$totalLoteIVA=$lote->getTotalCondicionado("viajes", "(monto_viaje*iva)/100", "lote_id=".$id." and encomienda=1 and departamento_id=".$dpto['id']);
$totalLote=$montoLote+$totalLoteIVA;*/


$r.="<span class='titulo'>$nombreLote</span><br><br>";
/*$r.="<strong>Traslado de Personal: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
                            $r.="<strong>Encomiendas: </strong> ".number_format($montoLoteEncomienda,2,",",".")." Bs<br>";
                            $r.="<strong>Exento: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
                            $r.="<strong>Subtotal (Personal+Encomiendas): </strong> ".number_format($subtotal,2,",",".")." Bs<br>";
                            $r.="<strong>IVA: </strong> ".number_format($totalLoteIVA,2,",",".")." Bs<br>";
                            $r.="<strong>Total: </strong> ".number_format($subtotal+$totalLoteIVA,2,",",".")." Bs<br></div>";*/
$r.="</fieldset>";

cerrarConexion();


echo $r;
?>

