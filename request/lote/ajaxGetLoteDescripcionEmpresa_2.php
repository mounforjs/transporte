<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);
$r="<table width='1000' ><tr><td colspan=10><fieldset><div class='caja-totales'><span class='titulo'>".strtoupper($empresa)."</span><br><br>";
$lote=new lote();
$nombreLote=$lote->getDescripcionTable("lotes", $id, "descripcion");



$montoLote=$lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
                            
$montoLoteTrasladoPersonal = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id." and encomienda=0");
$montoLoteEncomienda = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id." and encomienda=1");

$subtotal = $montoLoteTrasladoPersonal+$montoLoteEncomienda;

$totalLoteIVA=$lote->getTotalCondicionado("viajes", "(monto_viaje*12)/100", "lote_id=".$id." and encomienda=1");
$totalLote=$montoLote+$totalLoteIVA;


$r.="<span class='titulo'>$nombreLote</span><br><br>";
$r.="<strong>Traslado de Personal: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
                            $r.="<strong>Encomiendas: </strong> ".number_format($montoLoteEncomienda,2,",",".")." Bs<br>";
                            $r.="<strong>Exento: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
                            $r.="<strong>Subtotal (Personal+Encomiendas): </strong> ".number_format($subtotal,2,",",".")." Bs<br>";
                            $r.="<strong>IVA: </strong> ".number_format($totalLoteIVA,2,",",".")." Bs<br>";
                            $r.="<strong>Total: </strong> ".number_format($subtotal+$totalLoteIVA,2,",",".")." Bs<br></div>";
                            
$r.="<div class='caja'><span class='titulo'>TRANSPORTE ARENAS C.A</span><br><br>
                                            <strong>RIF :</strong>J-29642721-6<br>
                                            <strong>CONTACTO :</strong>0412-8465713  /  0244-3864346
                                            &nbsp;<p class='titulo'>$nombreLote</p></div></fieldset></td></tr></table>";
                            
                            
$r.="</fieldset>";

cerrarConexion();


echo $r;
?>
