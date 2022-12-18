<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
require_once CLASES.'/viaje.php';
$model=new viaje();
abrirConexion();

date_default_timezone_set("America/Caracas");

$movilizaciones_str="";
$retorno="";
$encomienda="";
$horario="";
$i=1;

$viaje=$model->getModel($_GET['id'], "viajes");


?>

<script>
    
    var viaje;
    
    $(document).ready(function(){

        viaje_id=<?php echo $_GET['id'] ?>
        

        $('#txtFechaViaje').datepicker({ dateFormat: 'yy-mm-dd',changeYear: true,changeMonth:true,dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec']});
        $('#txtFechaViaje').datepicker();
        
        
        $.post("../../request/general/getModelJSON.php", {modelo:"viajes",id:viaje_id}, function(r){
            
            viaje = JSON.parse(r);
            
            
           
            $("#txtFechaViaje").val(viaje.fecha);
            $("#selectConductor").val(viaje.conductor_id);
            $("#txtRecargo").val(viaje.recargo_porc);
            $("#selectDepartamento").val(viaje.departamento_id);
            
            $("#selectRuta").val(viaje.ruta_id)
            
                  $("#selectRuta").autocomplete({
                    source: "../../request/general/autocomplete_rutas.php?lista="+viaje.lista_id,
                    minLength: 2,
                    select: function(event,ui){
                        
                        
                         $("#selectRutaLabel").text(ui.item.label)
                           // console.log($("#selectRuta").val())
                        
                        }
                    });
            
        });
        
        $("#selectConductor").autocomplete({
                    source: "../../request/general/autocomplete.php",
                    minLength: 2,
                    select: function(event,ui){
                        
                            $("#selectConductor").val(ui.item.id)
                            $("#selectConductorLabel").text(ui.item.label)
                        
                        
                        }
         });
         
         $("#selectDepartamento").autocomplete({
                    source: "../../request/general/autocomplete_departamentos.php",
                    minLength: 2,
                    select: function(event,ui){
                        
                         $("#selectDepartamento").val(ui.item.id)
                        
                             $("#selectDepartamentoLabel").text(ui.item.label)
                        
                        }
                    });
         
   


    });

</script>

<div id="divPopUp">
    <div id="divNuevoPasajero">
        <br><br>
        <span class="titulo">&nbsp;&nbsp;CLONANDO VIAJE <?php echo $_GET['id'] ?></span><br><br>
        <form id="frmClonar">
            <table width="500px">
                
                <tr>
                        <td><strong>Conductor:</strong></td>
                        <td>
                            <input id="selectConductor" name="selectConductor" type="text" >
                            <span id="selectConductorLabel"></span>
                        </td>
                 </tr>
                <tr>
                            <td><strong>Ruta:</strong></td>
                            <td>
                                <input id="selectRuta" name="selectRuta" type="text" >
                                <span id="selectRutaLabel"></span>
                            </td>
                  </tr>
                
                
                <tr>
                    <td><strong>Fecha:</strong></td>
                    <td>
                        <input id="txtFechaViaje" name="txtFechaViaje" type="text">
                    </td>
                </tr>
                
                <tr>
                        <td><strong>Recargo (%)</strong></td>
                        <td>
                            <input id="txtRecargo" name="txtRecargo" type="text" size="15" value="0">
                        </td>
                </tr>
                <tr>
                            <td><strong>Departamento:</strong></td>
                            <td>
                                <input id="selectDepartamento" name="selectDepartamento" type="text" >
                                <span id="selectDepartamentoLabel"></span>
                            </td>
                        </tr>
                        
                <tr>
                        <td><strong>Nº Solicitud</strong></td>
                        <td>
                            <input id="txtSolicitud" name="txtSolicitud" type="text" size="15" value="0">
                        </td>
                </tr>
                <tr>
                        <td><strong>Retorno</strong></td>
                        <td>
                            <input id="retorno" name="retorno" type="checkbox">
                        </td>
                </tr>
                <tr>
                        <td><strong>Encomienda</strong></td>
                        <td>
                            <input id="encomienda" name="encomienda" type="checkbox">
                        </td>
                </tr>



            </table><br>
            <table id="tablaPasajeros" width="600px">
				<tr class="tableTitle">
					<th>Pasajeros</th>
				</tr>
            </table> 
            
            <br>
        </form>
        <a  name="actionClonarViaje" class="boton">Clonar</a>

    </div>
</div>
