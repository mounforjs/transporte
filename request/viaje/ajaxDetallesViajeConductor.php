<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/viaje.php';
require_once CLASES.'/movilizacion.php';
require_once DB;
abrirConexion();

extract($_POST);

$viaje_id=$id;
$r="";
$retornoConductor="";
$retornoEmpresa="";
$horarioEmpresa="";
$horarioConductor="";
$encomienda="";
$montoAdicionalEmpresa="";
$montoAdicionalConductor="";
$viaje=new Viaje();
$movilizacion=new Movilizacion();
$viajeModel=$viaje->getModel($id, "viajes");
$thorarioEmpresa=0;

if($viajeModel!=false){

    extract($viajeModel);
    
    $movilizacionesList=$viaje->getListCondicional("movilizaciones", 1000, "viaje_id=".$id);
    $pasajerosList=$viaje->getListCondicional("pasajeros_viajes", 1000, "viaje_id=".$id);
    $ruta=$viajeModel['ruta'];

    //DATOS INICIALES
        $datosini="<strong>Fecha: </strong>".$viaje->fechaVE($viajeModel['fecha'])."<br>";
        $datosini.="<strong>Horas de espera: </strong>".$viajeModel['horas_conductor']."<br>
                     <strong>Ruta: </strong>".$viajeModel['ruta']."<br><br>";

    //PASAJEROS DEL VIAJE

    $pasajeros="<span class='sub'>PASAJEROS</span><br><br><table cellspacing=0 width=500>
    <tr class='tableTitle'>
        <td>ID</td>
        <td>Nombre</td>
        <td>Teléfono</td>
    </tr>";

    if($pasajerosList!=false){

        while($row=pg_fetch_array($pasajerosList)){

            extract($row);
            $nombrePasajero=$viaje->getDescripcionTable("pasajeros", $pasajero_id, "nombre");
            $telefonoPasajero=$viaje->getDescripcionTable("pasajeros", $pasajero_id, "telefono");

            $pasajeros.="<tr id=$id>
            <td>$id</td>
            <td>$nombrePasajero</td>
            <td>$telefonoPasajero</td>
          </tr>";
        }
        $pasajeros.="</table>";
    }else{
        $pasajeros.="<tr><td>No existen pasajeros registrados en este viaje</td></tr>";
    }

    //MOVILIZACIONES DEL VIAJE

    $movilizaciones="<span class='sub'>MOVILIZACIONES</span><br><br><table cellspacing=0 width=500>
    <tr class='tableTitle'>
        <td>Descripcion</td>
        <td>Precio</td>
        <td>Pago</td>
    </tr>";

    if($movilizacionesList!=false){

        while($row=pg_fetch_array($movilizacionesList)){

            extract($row);

            $movilizaciones.="<tr id=$id>
            <td>$descripcion</td>
            <td>$precio</td>
            <td>$pago</td>
          </tr>";
        }
        $movilizaciones.="</table>";
    }else{
        $movilizaciones.="<tr><td>No existen movilizaciones registradas en este viaje</td></tr>";
    }

    $costoRuta=$viaje->getModelCondicionado("listas_rutas", "ruta_id=".$viajeModel['ruta_id']." and lista_id=".$viajeModel['lista_id']);
    $listaModel=$viaje->getModel($viajeModel['lista_id'], "listas");


    //CALCULANDO MONTOS POR HORAS DE ESPERA Y MOVILIZACIONES
    $montoh=$listaModel['hora_espera']*$viajeModel['horas_espera'];
    $montom=$movilizacion->totalMovilizaciones($viaje_id, "precio");
    $montoHConductor=$listaModel['hora_espera_conductor']*$viajeModel['horas_conductor'];


    $montoMConductor=$movilizacion->totalMovilizaciones($viaje_id, "pago");

    //-----------//

    //MOSTRANDO RESULTADOS DE LOS MONTOS ANTERIORES
    $monto_horas_espera="<strong>Monto Horas de espera :</strong>  +".$montoh." Bs";
    $monto_horas_conductores="<strong>Monto Horas de espera (Conductor) :</strong> +".$montoHConductor." Bs";
    $montoMovilizacionesEmpresa="<strong>Monto movilizaciones :</strong> +".$montom." Bs";
    $montoMovilizacionesConductor="<strong>Monto movilizaciones (Conductores) :</strong> +".$montoMConductor." Bs";

    //----------------//

    $totalViajeEmpresa=$viajeModel['monto_esp_empresa'];
    $totalViajeConductor=$viajeModel['monto_esp_conductor'];

    if($viajeModel['retorno']==1){
       $totalViajeEmpresa+=$viajeModel['monto_esp_empresa'];
       $totalViajeConductor+=$viajeModel['monto_esp_conductor'];
       $retornoEmpresa="<strong>Retorno :</strong> +".$viajeModel['monto_esp_empresa']." Bs";
       $retornoConductor="<strong>Retorno :</strong> +".$viajeModel['monto_esp_conductor']." Bs";
    }

    switch ($viajeModel['horario']){
        case 1:$porHorario="Solo Ida";
            break;
        case 2:$porHorario="Solo vuelta";
            break;
        case 3:$porHorario="Ida y Vuelta";
            break;
    }

    if($viajeModel['horario']==1 || $viajeModel['horario']==2){
        $thorarioEmpresa=($viajeModel['monto_esp_empresa']*30)/100;
        $thorarioConductor=($viajeModel['monto_esp_conductor']*30)/100;

        $horarioEmpresa="<br><strong>Noctorno ó Festivo($porHorario):</strong> +".$thorarioEmpresa." Bs";
    }

    if($viajeModel['horario']==3){
        $thorarioEmpresa=($totalViajeEmpresa*30)/100;
        $thorarioConductor=($totalViajeConductor*30)/100;

        $horarioEmpresa="<br><strong>Noctorno ó Festivo($porHorario):</strong> +".$thorarioEmpresa." Bs";
    }
    
    if($viajeModel['adicional']!=0){
        $montoAdicionalEmpresa="<strong>Monto Adicional:</strong> +".$viajeModel['adicional'];
    }

    if($viajeModel['adicional_conductor']!=0){
        $montoAdicionalConductor="<strong>Monto Adicional:</strong> +".$viajeModel['adicional_conductor'];
    }

    if($viajeModel['encomienda']==1){
        $iva=$viaje->getDescripcionTable("iva", 1, "iva");
        $totalIva=($iva*($totalViajeEmpresa+$montoh+$montom+$thorarioEmpresa+$viajeModel['adicional']))/100;
        $viajeModel['monto_viaje']+=$totalIva;

        $encomienda="<br><strong>Encomienda: Si</strong><br><strong>IVA:</strong> +".$totalIva." Bs";
    }else{
        $encomienda="";
    }

    $precioBase="<strong>Precio Viaje (Base):</strong>   ".$viajeModel['monto_esp_empresa']." Bs";
    $precioBaseConductor="<br><br><br><strong>Pago Conductor (Base):</strong> ".$viajeModel['monto_esp_conductor']." Bs";

    $r.=$datosini."<br><br>".$pasajeros."<br><br>".$movilizaciones;

    $r.=$precioBaseConductor."<br>".$retornoConductor."<br>".$monto_horas_conductores."<br>".$montoMovilizacionesConductor."<br>".$montoAdicionalConductor."<br><br><strong>TOTAL PAGO :</strong>  ".$viajeModel['monto_pago']." Bs<br><br>";
    
}else{
    $r="<td>No existe el viaje</td>";
}

cerrarConexion();

echo $r;
?>

