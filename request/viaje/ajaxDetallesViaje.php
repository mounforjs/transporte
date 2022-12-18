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
$datosini="";
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
        $datosini.="<strong>Viaje ID:</strong>".$viajeModel['id']."<br>";
        $datosini.="<strong>Fecha: </strong>".$viaje->fechaVE($viajeModel['fecha'])."<br>";
        $datosini.="<strong>Horas de espera: </strong>".$viajeModel['horas_espera']."<br>
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
    $monto_horas_conductores="<strong>Monto Horas de espera (Conductores) :</strong> +".$montoHConductor." Bs";
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




    
   // $thorarioConductor=($viajeModel['monto_esp_conductor']*$viajeModel['recargo_porc'])/100;
    
    if($viajeModel['recargo_porc']==""){
        
        
        switch ($viajeModel['horario']){
            case 0:
                $porc=0;
                break;
            case 1:
                $porc=30;
                $leyenda = "Solo ida";
                break;
            case 2:
                $porc=30;
                $leyenda = "Solo vuelta";
                break;
            case 3:
                $porc=60;
                 $leyenda = "Ida y vuelta";
                break;
        }  
        
        $thorarioEmpresa=($viajeModel['monto_esp_empresa']*$porc)/100;
        
    }else{
        
        $porc=$viajeModel['recargo_porc'];
        $thorarioEmpresa=$viajeModel['monto_esp_empresa']*($viajeModel['recargo_porc']/100);
        $leyenda =$viajeModel['leyenda'];

    }
    
    
    
    $horarioEmpresa="<br><strong>Recargo: ($porc %)</strong> +".$thorarioEmpresa." Bs .<br><strong>Leyenda :</strong> $leyenda ";
    

    
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

    $observaciones=$viajeModel['observaciones'];

    $precioBase="<strong>Precio Viaje (Base):</strong>   ".$viajeModel['monto_esp_empresa']." Bs";
    $precioBaseConductor="<strong>Pago Conductor (Base):</strong> ".$viajeModel['monto_esp_conductor']." Bs";

    $r.=$datosini."<br><br>".$pasajeros."<br><br>".$movilizaciones."<br><br><br>".$precioBase."<br>".$retornoEmpresa."<br>"
    .$monto_horas_espera."<br>".$montoMovilizacionesEmpresa.$horarioEmpresa."<br>".$montoAdicionalEmpresa."<br>".$encomienda." <br><br>"."<strong>TOTAL VIAJE :</strong>  ".$viajeModel['monto_viaje']." Bs<br><br><br><br>";

    $r.=$precioBaseConductor."<br>".$retornoConductor."<br>".$monto_horas_conductores."<br>".$montoMovilizacionesConductor."<br>".$montoAdicionalConductor."<br><br><strong>TOTAL PAGO :</strong>  ".$viajeModel['monto_pago']."Bs <br><br><strong>Observaciones: </strong> ".$observaciones." <br><br>";
    
}else{
    $r="<td>No existe el viaje</td>";
}

cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

