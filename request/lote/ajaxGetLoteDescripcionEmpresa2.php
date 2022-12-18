<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);
$r = "<fieldset>";
$lote = new lote();

$lote_id = $id;
$idEmpresa = $empresa;
$iva = $lote->getDescripcionTable("iva", 1, "iva");
$empresa = $lote->getDescripcionTable("empresas", $idEmpresa, "nombre");
$rif = $lote->getDescripcionTable("empresas", $idEmpresa, "rif");
$nombreLote = $lote->getDescripcionTable("lotes", $id, "descripcion");
$montoLote = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
$totalLoteIVA = $lote->getTotalCondicionado("viajes", "(monto_viaje*$iva)/100", "lote_id=".$id." and encomienda=1");
$totalLote = $montoLote+$totalLoteIVA;


$montoLoteTrasladoPersonal = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$lote_id."  and encomienda=0");
$montoLoteEncomienda = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$lote_id."  and encomienda=1");

$subtotal = $montoLoteTrasladoPersonal + $montoLoteEncomienda;
                            
$totalLoteIVA = $lote->getTotalCondicionado("viajes", "(monto_viaje*$iva)/100", "lote_id=".$lote_id." and encomienda=1");
$totalLote = $montoLote+$totalLoteIVA;







$r.="<div class='caja'><span class='titulo'>".strtoupper($empresa)."</span><br><br>";
$r.="<strong>Traslado de Personal: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
$r.="<strong>Encomiendas: </strong> ".number_format($montoLoteEncomienda,2,",",".")." Bs<br>";
$r.="<strong>Exento: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
$r.="<strong>Subtotal (Personal+Encomiendas): </strong> ".number_format($subtotal,2,",",".")." Bs<br>";
$r.="<strong>IVA: </strong> ".number_format($totalLoteIVA,2,",",".")." Bs<br>";
$r.="<strong>Total: </strong> ".number_format($subtotal+$totalLoteIVA,2,",",".")." Bs<br></div>";
$r.="<div class='caja2'><span class='titulo'>TRANSPORTE ARENAS C.A</span><br><br>
                <strong>RIF :</strong>J-29642721-6<br>
                <strong>CONTACTO :</strong>0412-8465713  /  0244-3864346
                &nbsp;<p class='titulo'>$nombreLote</p></div>";
$r.="</fieldset>";




cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

