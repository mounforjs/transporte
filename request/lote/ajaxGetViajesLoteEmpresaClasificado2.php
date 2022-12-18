<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);

$lote_id=$id;
$r="";
$numreg=0;
$lote=new lote();

$departamentosList=$lote->getList("departamentos",1000);
$totalLote=$lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
$totalLoteConductor=$lote->getTotalCondicionado("viajes", "monto_pago", "lote_id=".$id);
$idEmpresa=$lote->getDescripcionTable("lotes", $id, "empresa_id");

//OBTENIENDO EL NUMERO DE DEPARTAMENTOS PARA ESA EMPRESA
$queryND="SELECT COUNT(*) as n FROM departamentos WHERE empresa_id=".$idEmpresa;
//echo $queryND;
$result=pg_query($queryND);
$n=pg_fetch_array($result);
$n=$n['n']; //NUMERO DE DEPARTAMENTOS PARA ESA EMPRESA
$re="";

if($departamentosList!=false){
    
    while($dpto=pg_fetch_array($departamentosList)){

        $list=$lote->getListCondicional("viajes",1000,"lote_id=$lote_id and departamento_id=".$dpto['id']." ORDER BY id ASC");
        
        if($list!=false){

            if(pg_num_rows($list)>=1){//NUMEROS DE VIAJES (PARA CALCULAR EL SALTO DE PAGINA)

                $nreg=pg_num_rows($list);

                        if($n>0){

                            $iva=$lote->getDescripcionTable("iva", 1, "iva");
                            $empresa=$lote->getDescripcionTable("empresas", $idEmpresa, "nombre");
                            $rif=$lote->getDescripcionTable("empresas", $idEmpresa, "rif");
                            
                            
                            $nombreLote=$lote->getDescripcionTable("lotes", $lote_id, "descripcion");
                            $montoLote=$lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$lote_id." and departamento_id=".$dpto['id']);
                            
                            $montoLoteTrasladoPersonal = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$lote_id." and departamento_id=".$dpto['id']." and encomienda=0");
                            $montoLoteEncomienda = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$lote_id." and departamento_id=".$dpto['id']." and encomienda=1");
                            
                            $subtotal = $montoLoteTrasladoPersonal+$montoLoteEncomienda;
                            
                            $totalLoteIVA=$lote->getTotalCondicionado("viajes", "(monto_viaje*$iva)/100", "lote_id=".$lote_id." and encomienda=1 and departamento_id=".$dpto['id']);
                            $totalLote=$montoLote+$totalLoteIVA;

                            $r.="<tr><td colspan=10><fieldset><div class='caja-totales'><span class='titulo'>".strtoupper($empresa)."</span><br><br>";
                            $r.="<strong>RIF: </strong> ".$rif." <br>";
                            
                            $r.="<strong>Traslado de Personal: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
                            $r.="<strong>Encomiendas: </strong> ".number_format($montoLoteEncomienda,2,",",".")." Bs<br>";
                            $r.="<strong>Exento: </strong> ".number_format($montoLoteTrasladoPersonal,2,",",".")." Bs<br>";
                            $r.="<strong>Subtotal (Personal+Encomiendas): </strong> ".number_format($subtotal,2,",",".")." Bs<br>";
                            $r.="<strong>IVA: </strong> ".number_format($totalLoteIVA,2,",",".")." Bs<br>";
                            $r.="<strong>Total: </strong> ".number_format($subtotal+$totalLoteIVA,2,",",".")." Bs<br></div>";
                            
                            //$r.="<strong>Monto lote: </strong> ".number_format($montoLote,2,",",".")." Bs<br>";
                            //$r.="<strong>Total IVA: </strong> ".number_format($totalLoteIVA,2,",",".")." Bs<br>";
                            //$r.="<strong>Total lote: </strong> ".number_format($totalLote,2,",",".")." Bs<br></div>";
                            
                            
                            
                            $r.="<div class='caja'><span class='titulo'>TRANSPORTE ARENAS C.A</span><br><br>
                                            <strong>RIF :</strong>J-29642721-6<br>
                                            <strong>CONTACTO :</strong>0412-8465713  /  0244-3864346
                                            &nbsp;<p class='titulo'>$nombreLote</p></div></fieldset></td></tr>";
                            
                            $r.="<tr>
                                    <td colspan='12'>&nbsp;</td>
                                    </tr>
                                    </tr><tr class='tableTitle'>
                        <td width='50px'>ID</td>
                        <td width='70'>Fecha</td>
                        <td width='70'>Dpto</td>
                        <td>Ruta</td>
                        <td width='100'>Pasajeros</td>
                        <td width='15' >H.E.</td>
                        <td width='10'>Número M.</td>
                        <td width='95'>Monto Viaje</td>
                        <td width='95'>IVA</td>
                        <td width='100'>Total</td>
                    </tr>
                                    <tr>
                                    <td colspan='12'></td>
                                    </tr>
                                <tr class='tableTitle'>
                                    <td colspan='12'><strong>".$dpto['nombre']."</strong></td>
                                </tr>";
                        }

            }else{
                $nreg=0;
            }
        }


        $list=$lote->getListCondicional("viajes",500,"lote_id=$lote_id and departamento_id=".$dpto['id']." ORDER BY id ASC");

        if($list!=false){
            
            
            $numreg=1;
            while($row=pg_fetch_array($list)){
            
                extract($row);
                
                //MOVILIZACIONES
                $i=1;
                $movilizaciones=$lote->getListCondicional("movilizaciones", 1000, "viaje_id=".$id);
                
                
                if($movilizaciones){
                    while($reg=pg_fetch_array($movilizaciones)){

                        
                        if($i==1){
                            $movilizacionText=$i.".".$reg['descripcion'];
                        }else{
                            $movilizacionText.=","."<br>".$i.".".$reg['descripcion'];
                        }

                        $i++;
                    }
                }else
                {
                 $movilizacionText="0";

                }
                
                
                
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
                    $leyenda="";
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
                } else {
                    $idString = "<td>$id</td>";
                }

                if($encomienda!=1){
                    $leyenda=$row['leyenda'];
                }

                        if($encomienda==1){
                            $enc = "Si";
                        }else{
                            $enc = "";
                        }

                        if($retorno==1){
                            $ret = "Si";
                        }else{
                            $ret = "";
                        }


                    if(empty($horas_espera_double))
                    {
                        $horas = $horas_espera;
                    }else{
                        $horas = $horas_espera_double;
                    }



               /* $r.="<tr id=$id>
                    <td width='50px'>$id</td>
                    <td>".$nsolicitud."</td>
                     <td>".$lote->fechaVE($fecha)."</td>
                     <td width='150px'>$ruta</td>".
                    "<td>$enc</td>
                    <td>$ret</td>
                    <td>$numero_pasajeros</td>
                    <td>$numero_movilizaciones</td>".
                    
                   "<td>".number_format($monto_viaje,2,",",".")." Bs.</td>
              </tr>";*/

              $r.="<tr id=$id>
        $idString
        <td>".$nsolicitud."</td>
        <td>".$lote->fechaVE($fecha)."</td>
        <td>$ruta</td>
        <td>$numero_pasajeros</dr>
        <td>$horas</td>
        <td> $numero_movilizaciones</td>".
        "<td>".number_format($monto_viaje,2,",",".")." Bs </td>".
        $trIva.
        $trTotal."
      </tr>";
                
                if($numreg==$nreg){
                    $r.="<tr class='saltoPagina'><td colspan='10'>&nbsp;</td></tr>";
                }

                $numreg++;

            }
        }
    
    }

}
        


$table=$r;

cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $table;
?>
