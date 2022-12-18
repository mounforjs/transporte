<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';

unset($_SESSION['pasajerosGuardar']);
unset($_SESSION['movilizaciones']);

$model=new model();
abrirConexion();
date_default_timezone_set("America/Caracas");
$fecha=date("d-m-Y");

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: NUEVO VIAJE ::</title>
            <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
            <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
            <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
            <script src="../../js/jquery/jquery-ui-1.8.js"></script>
            <script src="../../js/jquery/colorbox.js"></script>
            <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>
            <script src="../../js/jquery/jquery.jkey-1.1.js"></script>
            <link href="../../css/jquery.tagsinput.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery.tagsinput.js"></script>
            <script src="../../js/jquery/init.js"></script>
        <script type="text/javascript">

            var npasajeros=0;
            var costoOpcionalViaje=0;
            var encomienda=0;
            var montoAdicional=0;
	    var viaje_id;

            $().ready(function(){
                
                $('#tablaCostoViaje').hide();
                $('#trEncomienda').hide();
                $('#tablaAdicional').hide();
                $('#tablaHoras').hide();
                $('#txtFechaViaje').datepicker({ dateFormat: 'dd-mm-yy',changeYear: true,changeMonth:true,dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec']});
                $('#txtFechaViaje').datepicker();
                $('#txtFechaViaje').val(<?php echo "'".$fecha."'" ?>);

                $('#tablaCostoAdicionalViaje').hide();
                $('#btnRegistrarViaje').attr("disabled", "true");
                $('#txtEncomienda').val(0);

                $('#chkEncomienda').click(function(){
                    if(encomienda==0){
                       $('#divPasajeros').hide();
                       $('#btnRegistrarViaje').removeAttr("disabled");
                       $('#trEncomienda').show();
                       encomienda=1;
                    }else{
                        $('#divPasajeros').show();
                        $('#btnRegistrarViaje').attr("disabled", "true");
                        $('#trEncomienda').hide();
                        encomienda=0;
                    }

                });

                $('#selectHorario').change(function(){
                   if($('#selectHorario').val()==3){
                       $('#chkRetorno').click();
                   }
                });

                $('#chkMontoEspecifico').click(function(){
                    if(costoOpcionalViaje==0){
                       $('#tablaCostoViaje').show();
                        costoOpcionalViaje=1;
                    }else{
                        $('#tablaCostoViaje').hide();
                        costoOpcionalViaje=0;
                    }
                });

                $('#chkMontoAdicional').click(function(){
                    if(montoAdicional==0){
                       $('#tablaAdicional').show();
                        montoAdicional=1;
                    }else{
                        $('#tablaAdicional').hide();
                        montoAdicional=0;
                    }
                });

                $('#chkHoras').click(function(){
                    if($(this).is(":checked")){
                       $('#tablaHoras').show();
                    }else{
                        $('#tablaHoras').hide();
                    }
                });
		
                $.post("../../request/viaje/ajaxRegistrarViaje.php", null, function(r){
			viaje = JSON.parse(r);
			console.log(viaje.id);
			viaje_id = viaje.id;

			$("#idViaje").html("<span style='font-size:15px'>"+viaje_id+"</span>");
                });


		/*$.post("../../request/general/json_conductores.php", null, function(r){
			json_conductores = JSON.parse(r);
			console.log(json_conductores);
                });*/

                $.post("../../request/viaje/ajaxComboRutasLista.php", {lista:$("#selectLista").val()}, function(r){
                        $('#selectRuta').html(r);
                });
                

                $('#selectEstatus').change(function(){
                    if(this.value==2){
                        $('#txtFechaViaje').val(<?php echo "'".$fecha."'" ?>);
                        $('#txtFechaViaje').attr("disabled","true");
                    }
                    if(this.value==1){

                        $('#txtFechaViaje').removeAttr("disabled");
                    }
                });


                $('a#nuevoPasajero').colorbox({transition:'fade', speed:800,width:"550px", height:"280px",onComplete:function(){

                    
                    
                        $.post("../../request/viaje/ajaxGetPasajerosSelect.php", {empresa:$('#selectEmpresa').val()}, function(r){
                            $('#selectPasajero').html(r);
                        });
                        
                        
                  $("#selectPasajero").autocomplete({
                    source: "../../request/general/autocomplete_pasajeros.php",
                    minLength: 2,
                    select: function(event,ui){
                        
                        $("#selectPasajeroLabel").text(ui.item.label)
                        
                        }
                    });
                    
                   
                    $('#btnRegistrarPasajero').click(function(){

                        $("#selectPasajero").rules("add", {
                         required: true,remote:{url:"../../request/viaje/ajaxCheckPasajero.php",type:"post"},
                         messages: {
                           required: "<br>Este campo es requerido",
                           remote:"Este pasajero ya ha sido registrado"
                         }
                        });

                        if($('#frmPasajero').validate().element("#selectPasajero")){
                            $('#btnRegistrarPasajero').attr("disabled","true");
                            $.post("../../request/viaje/ajaxRegistrarPasajero.php", $('#frmPasajero').serialize(), function(r){
                                $.fn.colorbox.close();
                                $('#tablaPasajeros').append(r);
                                $('#btnRegistrarViaje').removeAttr("disabled");
                                npasajeros+=1;

                            });
                        }

                    })

                    $('#frmPasajero').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
     
                     }});
                }});

                $('a#nuevaMovilizacion').colorbox({transition:'fade', speed:800,width:"750px", height:"370px",onComplete:function(){

                    $('#btnRegistrarMovilizacion').click(function(){

                        $("#txtDescripcion").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtPrecio").rules("add", {
                         required: true,number:true,
                         messages: {
                           required: "<br>Este campo es requerido",
                           number:"<br>Este campo solo admite caracteres numericos"
                         }
                        });

                        $("#txtPago").rules("add", {
                         required: true,number:true,
                         messages: {
                           required: "<br>Este campo es requerido",
                           number:"<br>Este campo solo admite caracteres numericos"
                         }
                        });

                        if($('#frmMovilizacion').validate().element("#txtDescripcion") &
                           $('#frmMovilizacion').validate().element("#txtPrecio") &
                           $('#frmMovilizacion').validate().element("#txtPago")){
                           $('#btnRegistrarMovilizacion').attr("disabled","true");
                            $.post("../../request/viaje/ajaxRegistrarMovilizacion.php", $('#frmMovilizacion').serialize(), function(r){
                                $.fn.colorbox.close();
                                $('#tablaMovilizaciones').append(r);
                            });
                        }

                    })

                    $('#frmMovilizacion').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                     }});
                }});

                $("a[name='eliminarPasajero']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar este pasajero?")){
                        $.post("../../request/viaje/ajaxEliminarPasajero.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Pasajero eliminado satisfactoriamente');
                                $("tr[id=pasajero"+id+"]").remove();
                  
                                npasajeros-=1;
                                if(npasajeros<=0){
                                    $('#btnRegistrarViaje').attr("disabled", "true");
                                }

                           

                            }else{
                                alert("No se pudo eliminar este Pasajero");
                            }
                        });
                    }
                });

                $("a[name='eliminarMovilizacion']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar esta movilizacion?")){
                        $.post("../../request/viaje/ajaxEliminarMovilizacion.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Movilizacion eliminada satisfactoriamente');
                                $("tr[id=movilizacion"+id+"]").remove();
                            }else{
                                alert("No se pudo eliminar esta movilizacion");
                            }
                        });
                    }
                });
            
                $('#btnRegistrarViaje').click(function(){


                    $("#txtDestinoFinal").rules("add", {
                             required: true,
                             messages: {
                               required: "Este campo es requerido<br>"
                             }
                     });
                     
                     
                     
                     $("#txtRecargo").rules("add", {
                             required: true,number:true,
                             messages: {
                               required: "Este campo es requerido<br>",
                               number:"Este campo solo acepta datos númericos"
                             }
                     });

                     $("#selectLista").rules("add", {
                             required: true,
                             messages: {
                               required: "Este campo es requerido<br>"
                             }
                     });

                     $("#selectConductor").rules("add", {
                             required: true,
                             messages: {
                               required: "Este campo es requerido<br>"
                             }
                     });

                     $("#selectRuta").rules("add", {
                             required: true,
                             messages: {
                               required: "Este campo es requerido<br>"
                             }
                     });

                     $("#selectEmpresa").rules("add", {
                             required: true,
                             messages: {
                               required: "Este campo es requerido<br>"
                             }
                     });

                     $("#txtFechaViaje").rules("add", {
                             required: true,
                             messages: {
                               required: "Este campo es requerido"
                             }
                     });

                    if(costoOpcionalViaje==1){

                            $("#txtCostoViaje").rules("add", {
                                 required: true,
                                 messages: {
                                   required: "Este campo es requerido"
                                 }
                            });

                            $("#txtPagoViaje").rules("add", {
                                 required: true,
                                 messages: {
                                   required: "Este campo es requerido"
                                 }
                            });
            
                         if($('#frmViaje').validate().element("#txtDestinoFinal") &
                            $('#frmViaje').validate().element("#txtFechaViaje") &
                            $('#frmViaje').validate().element("#txtCostoViaje") &
                            $('#frmViaje').validate().element("#txtPagoViaje") &
                            $('#frmViaje').validate().element("#selectLista")&
                            $('#frmViaje').validate().element("#selectRuta")&
                            $('#frmViaje').validate().element("#selectEmpresa")&
                            $('#frmViaje').validate().element("#txtRecargo") &
                            $('#frmViaje').validate().element("#selectConductor")){
                               // $('#btnRegistrarViaje').attr("disabled","true");
                                $('#txtFechaViaje').removeAttr("disabled");
                                $.post("../../request/viaje/ajaxGuardarViaje.php", $('#frmViaje').serialize(), function(r){
                                    if(r=="ok")
                                    {	
                                        //document.location="registroSatisfactorio.php"
					


                                    }else{
                                        alert("No se puedo registrar el Viaje");
                                        //document.location=document.location;
                                    }
                                });
                         }

                    }else{

                         if($('#frmViaje').validate().element("#txtDestinoFinal") &
                            $('#frmViaje').validate().element("#txtFechaViaje") &
                            $('#frmViaje').validate().element("#selectLista")&
                            $('#frmViaje').validate().element("#selectRuta")&
                            $('#frmViaje').validate().element("#txtRecargo")&
                            $('#frmViaje').validate().element("#selectEmpresa")&
                            $('#frmViaje').validate().element("#selectConductor")){
                                //$('#btnRegistrarViaje').attr("disabled","true");
                               // $('#txtFechaViaje').removeAttr("disabled");
                                $.post("../../request/viaje/ajaxGuardarViaje.php", $('#frmViaje').serialize(), function(r){
                                    if(r=="ok")
                                    {
                                        //document.location="registroSatisfactorio.php";

					

					$.post("../../request/viaje/ajaxViajeTerminado.php", {id:viaje_id,editar:1,txtNSolicitud:0}, function(r){
                                        

                                    	});

                                    }else{
                                        alert("No se puedo registrar el Viaje");
                                       // document.location=document.location;
                                    }
                                });
                         }
                    }

                });

                $('#frmViaje').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                 }});


                 $('#ultimosViajes').colorbox({transition:'fade', speed:800,width:"750px", height:"600px",onComplete:function(){
                     var n=0;
                     $.post("../../request/viaje/ajaxGetUltimosViajes.php", null, function(r){

                        if(r!="false"){
                            $('#tablaUltimosViajes').append(r);
                            var n=0;
                            $("tr.trclass").each(function(){
                                n++;
                                $(this).toggleClass("trGris",n%2==0)
                            });

                        }else{
                            alert("No hay viajes registrados");
                        }
                     });

                 }});

                 $('#selectLista').change(function(){
                    $.post("../../request/viaje/ajaxComboRutasLista.php", {lista:$(this).val()}, function(r){
                        $('#selectRuta').html(r);
                    });
                    
                    $("#selectRuta").autocomplete({
                    source: "../../request/general/autocomplete_rutas.php?lista="+$("#selectLista").val(),
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
                    
                    $("#selectRuta").autocomplete({
                    source: "../../request/general/autocomplete_rutas.php?lista="+$("#selectLista").val(),
                    minLength: 2,
                    select: function(event,ui){
                        
                        
                         $("#selectRutaLabel").text(ui.item.label)
                           // console.log($("#selectRuta").val())
                        
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
    </head>
    <body>
        <div id="main">
        <div id="header"><?php require_once HEADER ?></div>
        <div id="contenido">
        <div id="maincontenido">
        <br><br><br>
        <span class="titulo">&nbsp;&nbsp;NUEVO VIAJE</span><br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;<a id="ultimosViajes" href="ultimosViajes.php">Ver últimos viajes</a>
        <br><br><br>
             <span id="idViaje"></span><br><br>
            <form id="frmViaje">
                <input id="txtEncomienda" name="txtEncomienda" type="hidden">
                
                <table class="testilo" width="900px" cellspacing="0px">
                        <tr>
                            <th colspan="2">Datos principales</th>
                        </tr>
                        <tr>
                            <td><strong>Conductor:</strong></td>
                            <td>
                                <input id="selectConductor" name="selectConductor" type="text" >
                                <span id="selectConductorLabel"></span>
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Lista:</strong></td>
                            <td>
                                <select id='selectLista' name='selectLista'>
                                    
                                    <?php //echo $model->getCombolModelCondicional("listas", "descripcion","estado=1")
                                    
                                          $lista = $model->getModelCondicionado("listas", "estado=1");
                                    	  echo $model->getComboSelected("listas", "descripcion",$lista['id']);
                                     ?>
                                </select>
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
                            <td><strong>Empresa:</strong></td>
                            <td>
                                <select id='selectEmpresa' name='selectEmpresa'>
                                    <option></option>
                                    <?php $model->getComboSelected("empresas", "nombre",1) ?>
                                </select>
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
                            <td><strong>Destino Final:</strong></td>
                            <td>
                                <input id="txtDestinoFinal" name="txtDestinoFinal" type="text" size="60">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Como llegar:</strong></td>
                            <td>
                                <textarea id="txtComoLlegar" name="txtComoLlegar" type="text" cols="60" rows="6"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Estatus:</strong></td>
                            <td>
                                <select id='selectEstatus' name='selectEstatus'>
                                    <option value="1">Planificado</option>
                                    <option value="2" selected>En Curso</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Fecha:</strong></td>
                            <td>
                                <input id="txtFechaViaje" name="txtFechaViaje" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Encomienda:</strong></td>
                            <td>
                                <input id="chkEncomienda" name="chkEncomienda" type="checkbox" value="1">
                            </td>
                        </tr>
                        <tr id="trEncomienda">
                            <td><strong>Encomienda (solicitada por):</strong></td>
                            <td>
                                <input id="txtEncomienda" name="txtEncomienda" type="text" size="45">
                            </td>
                        </tr>
                         
                        <tr>
                            <td><strong>Con Retorno:</strong></td>
                            <td>
                                <input id="chkRetorno" name="chkRetorno" type="checkbox" value="1">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Recargo (%)</strong></td>
                            <td>
                                <input id="txtRecargo" name="txtRecargo" type="text" size="15" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Lote</strong></td>
                            <td>
                                <select id="selectLote" name="selectLote">
                                    <?php
                                    
                                        echo $model->getCombolModelCondicional("lotes", "descripcion", "EXTRACT(MONTH FROM fecha)=".date("m")." AND EXTRACT(YEAR FROM fecha)=".date("Y"));
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Leyenda</strong></td>
                            <td>
                                <input id="txtLeyenda" name="txtLeyenda" type="text" size="15">
                            </td>
                        </tr>
                    </table>
                
                <div id="divPasajeros">
                    <br><br><br><br>
                    <strong class="titulo">&nbsp;&nbsp;PASAJEROS</strong><br><br>
                    <a id="nuevoPasajero" href="npasajero.php">Nuevo Pasajero</a><br><br>
                    <table class="testilo" width="900px" border="0" cellspacing="0" id="tablaPasajeros">
                          
                          <tr>
                            <th width="234" height="25">Pasajero</th>
                            <th width="267">Teléfono</th>
                            <th width="267">Eliminar</th>
                          </tr>
                       </table>
                </div>
                <br><br><br><br>
                <strong class="titulo">&nbsp;&nbsp;MOVILIZACIONES</strong><br><br>
                <a id="nuevaMovilizacion" href="nmovilizacion.php">Nueva Movilización</a><br><br>
                <table class="testilo" width="900px" border="0" cellspacing="0" id="tablaMovilizaciones" >

                      <tr>
                        <th width="234" height="25">Descripción</th>
                        <th width="267">Eliminar</th>
                      </tr>

                  </table>

                  <br><br><br><br><br><br>
                  <div id="opcionales">
                        <fieldset>
                            <legend>
                                <strong>DATOS OPCIONALES</strong>
                            </legend>

                            <input type="checkbox" id="chkMontoEspecifico" name="chkMontoEspecifico" value="1">&nbsp;&nbsp;&nbsp;Especificar otro costo para el viaje
                            <table id="tablaCostoViaje">
                                <tr>
                                    <td><strong>Precio del Viaje (Empresa):</strong></td>
                                    <td><input id="txtCostoViaje" name="txtCostoViaje" type="text" value="0">&nbsp;&nbsp;&nbsp;(No incluir horas de espera y costo de movilizaciones)</td>
                                </tr>
                                <tr>
                                    <td><strong>Pago del Viaje <br>(a Conductor):</strong></td>
                                    <td><input id="txtPagoViaje" name="txtPagoViaje" type="text" value="0"></td>
                                </tr>
                            </table><br>
                            <input type="checkbox" id="chkMontoAdicional" name="chkMontoAdicional" value="1">&nbsp;&nbsp;&nbsp;Monto adicional
                            <table id="tablaAdicional">
                                <tr>
                                    <td><strong>Monto Adicional:</strong></td>
                                    <td><input id="txtAdicional" name="txtAdicional" type="text" value="0"></td>
                                </tr>
                                <tr>
                                    <td><strong>Monto Adicional (Conductor):</strong></td>
                                    <td><input id="txtAdicionalConductor" name="txtAdicionalConductor" type="text" value="0"></td>
                                </tr>
                            </table><br>
                            <input type="checkbox" id="chkHoras" name="chkHoras" value="1">&nbsp;&nbsp;&nbsp;Horas de espera
                            <table id="tablaHoras">
                                <tr>
                                    <td><strong>Horas de espera:</strong></td>
                                    <td><input id="txtHoras" name="txtHoras" type="text" value="0"></td>
                                </tr>
                                <tr>
                                    <td><strong>Horas de espera (Conductor):</strong></td>
                                    <td><input id="txtHorasConductor" name="txtHorasConductor" type="text" value="0"></td>
                                </tr>
                            </table>
                        </fieldset>
                  </div>
            </form>

            <br><br><br>
            &nbsp;&nbsp;&nbsp;<button id="btnRegistrarViaje">REGISTRAR VIAJE</button>
            <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
