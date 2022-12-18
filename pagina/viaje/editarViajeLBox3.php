<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
require_once CLASES.'/viaje.php';
$model = new viaje();
abrirConexion();

date_default_timezone_set("America/Caracas");

$movilizaciones_str = "";
$retorno = "";
$encomienda = "";
$horario = "";
$i = 1;

$viaje = $model->getModel($_GET['id'], "viajes");


?>

<script>

    
        var viaje;
        var lista_id = <?php echo $viaje['lista_id'] ?>;

    
        $(document).ready(function(){


        $('input').keydown(function (e) {

        if (event.which === 13 || event.keyCode === 13) {
                event.stopPropagation();
                event.preventDefault();
                var position = $(this).index('input');
                $("input").eq(position+1).focus();
            }
               
         });



        viaje_id=<?php echo $_GET['id'] ?>
        

        $('#txtFechaViaje').datepicker({ dateFormat: 'yy-mm-dd',changeYear: true,changeMonth:true,dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec']});
        $('#txtFechaViaje').datepicker();
        
        
        $.post("../../request/general/getModelJSON.php", {modelo:"viajes",id:viaje_id}, function(r){
            
            viaje = JSON.parse(r);
            

            $("#txtFechaViaje").val(viaje.fecha);
            $("#selectConductor").val(viaje.conductor_id);
            $("#txtRecargo").val(viaje.recargo_porc);
            $("#selectDepartamento").val(viaje.departamento_id);
            $("#txtHoras").val(viaje.horas_espera);

            $("#txtSolicitud").val(viaje.nsolicitud)


            $("#npasajeros").val(viaje.numero_pasajeros);
            $("#nmovilizaciones").val(viaje.numero_movilizaciones);
            $("#totalmovilizaciones").val(viaje.total_monto_movilizaciones);
            $("#selectRutaBusqueda").val(viaje.ruta_busqueda_id);

            if(viaje.retorno == 1)
            {
                $("#retorno").attr("checked", "checked");
            }

            if(viaje.encomienda == 1)
            {
                $("#encomienda").attr("checked", "checked");
            }

            
            
        $("#selectRuta").val(viaje.ruta_id);



            
        
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


        $("#selectRuta").autocomplete({

            source: function(request, response){

                $.ajax({
                  url: "../../request/general/autocomplete_rutas.php",
                  dataType: "json",
                  data: {
                    term : request.term,
                    lista : $("#selectLista").val()
                  },
                  success: function(data) {
                    response(data);
                  }
                });

            },
            minLength: 2,
            select: function(event,ui){
                
                 $("#selectRutaLabel").text(ui.item.label)
                   // console.log($("#selectRuta").val())
            }


         });



        $("#selectRutaBusqueda").autocomplete({
            source: function(request, response){

                $.ajax({
                  url: "../../request/general/autocomplete_rutas.php",
                  dataType: "json",
                  data: {
                    term : request.term,
                    lista : $("#selectLista").val()
                  },
                  success: function(data) {
                    response(data);
                  }
                });

            },
            minLength: 2,
            select: function(event,ui){
                    $("#selectRutaLabelBusqueda").text(ui.item.label)
                   $.post( "../../request/general/ruta_model.php", {ruta:$(this).val(),lista:$("#selectLista").val()} ,function(r) {
                     
                     var ruta = JSON.parse(r);
                   
                   });

                
                }
            });


            $("#selectLista").change(function(){

                $("#selectRuta").val("");
                $("#selectRuta").focus();

            });

            var valorm;

             $.post("../../request/general/getModelJSON.php", {modelo:"listas",id:lista_id}, function(r){

                json = JSON.parse(r);

                

                valorm =  json.movilizaciones ;
                console.log(valorm)
            

            });

            /* setTimeout(function(){

                if($("#nmovilizaciones").val() > 0){

                    if(!isNaN(valorm)){
                        $("#totalmovilizaciones").val(valorm * $("#nmovilizaciones").val());
                    }else{
                        $("#totalmovilizaciones").val(0);
                    }

                }else{
                    $("#totalmovilizaciones").val(0);
                }

                


             }, 2000)*/

             


    });

</script>

<div id="divPopUp">
    <div id="divNuevoPasajero">
        <br><br>
        <span class="titulo">&nbsp;&nbsp;EDITANDO VIAJE <?php echo $_GET['id'] ?></span><br><br>
        <form id="frmClonar2">
            <table width="500px">
                
                <tr>
                        <td><strong>Conductor:</strong></td>
                        <td>
                            <input id="selectConductor" name="selectConductor" type="text" class="required" >
                            <span id="selectConductorLabel"></span>
                        </td>
                 </tr>
                <tr>
                    <td><strong>Lista:</strong></td>
                    <td>
                        <select id='selectLista' name='selectLista'>
                            
                            <?php 
                                 $viaje = $model->getModelCondicionado("viajes", "id=".$_GET['id']);
                                  echo $model->getComboSelectedListas("listas", "descripcion", $viaje['lista_id'] );
                             ?>
                        </select>
                    </td>
                </tr>
                <tr>
                            <td><strong>Ruta:</strong></td>
                            <td>
                                <input id="selectRuta" name="selectRuta" type="text" class="required" >
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
                                <input id="selectDepartamento" name="selectDepartamento" type="text" class="required" >
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
                <tr>
                        <td><strong>Horas de Espera:</strong></td>
                        <td>
                            <input id="txtHoras" name="txtHoras" type="text" size="15" value="0" class="required">
                        </td>
                </tr>

                <tr>
                        <td><strong>Nº Pasajeros</strong></td>
                        <td>
                            <input id="npasajeros" name="npasajeros" type="text" size="15" value="0" class="required">
                        </td>
                </tr>
                <tr>
                        <td><strong>Número de Movilizaciones</strong></td>
                        <td>
                            <input id="nmovilizaciones" name="nmovilizaciones" type="text" size="15" value="0" class="required">
                        </td>
                </tr>
                <tr>
                        <td><strong>Total Monto Movilizaciones:</strong></td>
                        <td>
                            <input id="totalmovilizaciones" name="totalmovilizaciones" type="text" size="15" value="0" class="required">
                        </td>
                </tr>
                <tr>
                            <td><strong>Ruta Busqueda:</strong></td>
                            <td>
                                <input id="selectRutaBusqueda" name="selectRutaBusqueda" type="text" class="required" value="0" >
                                <span id="selectRutaLabelBusqueda"></span>
                            </td>
                  </tr>

            </table><br>
           <!-- <table id="tablaPasajeros" width="600px">
            <tr class="tableTitle">
              <th>Pasajeros</th>
            </tr>
            </table>  -->
            
            <br>
        </form>
        <a  name="actionEditarViaje" class="boton">Editar</a>

    </div>
</div>
