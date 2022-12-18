<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lote.php';
require_once DB;
abrirConexion();

extract($_POST);

$lote_id = $id;
$r = "";
$numreg = 0;
$lote = new lote();

$departamentosList = $lote->getList("departamentos",1000);
$totalLote = $lote->getTotalCondicionado("viajes", "monto_viaje", "lote_id=".$id);
$totalLoteConductor = $lote->getTotalCondicionado("viajes", "monto_pago", "lote_id=".$id);
$idEmpresa = $lote->getDescripcionTable("lotes", $id, "empresa_id");

//OBTENIENDO EL NUMERO DE DEPARTAMENTOS PARA ESA EMPRESA
$queryND = "SELECT COUNT(*) as n FROM departamentos WHERE empresa_id=".$idEmpresa;
//echo $queryND;
$result = pg_query($queryND);
$n = pg_fetch_array($result);
$n = $n['n']; //NUMERO DE DEPARTAMENTOS PARA ESA EMPRESA

if($departamentosList != false){
    
    while($dpto = pg_fetch_array($departamentosList)){

        $list = $lote->getListCondicional("viajes",500,"lote_id=$lote_id and departamento_id=".$dpto['id']." ORDER BY id ASC");
        
        if($list != false){

            if(pg_num_rows($list) >= 1){//NUMEROS DE VIAJES (PARA CALCULAR EL SALTO DE PAGINA)

                $nreg = pg_num_rows($list);

                        if($n > 0){
                             //<td width='50'>Pago</td>
                            $r.="<tr>
                                    <td colspan='17'>&nbsp;</td>
                                    </tr>
                                    </tr><tr class='tableTitle'>
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
                                        </tr>
                                    <tr>
                                    <td colspan='17'></td>
                                    </tr>
                                <tr class='tableTitle'>
                                    <td colspan='17'><strong>".$dpto['nombre']."</strong></td>
                                </tr>";
                        }

            }else{
                $nreg = 0;
            }
        }


        $list = $lote->getListCondicional("viajes",1000,"lote_id=$lote_id and departamento_id=".$dpto['id']." ORDER BY id ASC");

        if($list!=false){
            
            
            $numreg=1;
            while($row=pg_fetch_array($list)){
            
                extract($row);
                $conductor = $lote->getDescripcionTable("conductores", $conductor_id, "nombre");

                //NUMERO DE MOVILIZACIONES DEL VIAJE

                $nummovilizaciones = $lote->count("movilizaciones", "id", "viaje_id=".$id);

                //ENCONTRANDO A LOS PASAJEROS

                $pasajerosIDS = $lote->getListCondicional("pasajeros_viajes", 500, "viaje_id=".$id);
                $pasajeroText = "";
                $i=0;

                $pasajerosText = "";

                if($pasajerosIDS){
                    while($reg=pg_fetch_array($pasajerosIDS)){

                        $pasajeroText = $lote->getDescripcionTable("pasajeros", $reg['pasajero_id'], "nombre");
                        if($i==0){
                            $pasajerosText = $pasajeroText;
                        }else{
                            $pasajerosText.=",".$pasajeroText;
                        }

                        $i++;
                    }
                }else{
                    $pasajeroText="";
                }
                ////////////////////////
                
                
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
                } else {
                    $idString = "<td>$id</td>";
                }


                 //<td>$monto_pago Bs.</td>
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
        <td><a href='../../pagina/viaje/editarViaje.php?id=$id' target='_blank'>Editar</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Sacar del Lote</a>&nbsp;&nbsp;<a id='".$id."' name='clonarViaje'>Clonar</a>&nbsp;&nbsp;<a id='".$id."' name='eliminar-viaje'>Eliminar</a>&nbsp;&nbsp;<a id='".$id."' name='clonarViaje3'>Clonar3</a>&nbsp;&nbsp;<a id='".$id."' name='editarViaje3'>Editar Viaje3</a>&nbsp;&nbsp;</td>
      </tr>";
                
                if($numreg==$nreg){
                    $r.="<tr class='saltoPagina'><td colspan='16'>&nbsp;</td></tr>";
                }

                $numreg++;

            }
        }
    
    }

}
        


$table = $r;

cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $table;
?>

