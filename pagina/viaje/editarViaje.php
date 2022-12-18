<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';

unset($_SESSION['pasajeros']);
unset($_SESSION['movilizaciones']);

$model=new model();
abrirConexion();
unset($_SESSION['viajeEditar']);


$viaje=$model->getModelCondicionado("viajes", "id=".$_GET['id']);
$_SESSION['viajeEditar']=$viaje;
$_SESSION['viajeIdEdit']=$_GET['id'];
$fecha=date("d-m-Y");

if($viaje['recargo_porc']=="" || $viaje['recargo_porc']<1){
	$porc=0;
}else{
	$porc=$viaje['recargo_porc'];
}




?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: VIAJES ::</title>
        <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
        <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
        <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
        <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
        <script src="../../js/jquery/jquery-ui-1.8.js"></script>
        <script src="../../js/jquery/colorbox.js"></script>
        <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>

        <script type="text/javascript">

            var npasajeros=1;
            var costoOpcionalViaje=0;
            var encomienda=0;
            var montoAdicional=0;
            var viaje_id = <?php echo $_GET['id'] ?>

            $().ready(function(){

                monto_especifico="<?php echo $viaje['monto_especifico']; ?>"
                adicional="<?php echo $viaje['adicional']; ?>"
                encomienda_viaje="<?php echo $viaje['encomienda']; ?>"
                encomiendacheck=<?php echo $viaje['encomienda'] ?>
                
                
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
                
                


                $('#tablaCostoViaje').hide();
                $('#trEncomienda').hide();
                $('#tablaAdicional').hide();
                $('#txtFechaViaje').datepicker({ dateFormat: 'dd-mm-yy',changeYear: true,changeMonth:true,dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec']});
                $('#txtFechaViaje').datepicker();


                $('#tablaCostoAdicionalViaje').hide();
                //$('#btnRegistrarViaje').attr("disabled", "true");
                $('#txtEncomienda').val(0);


                if(encomiendacheck==1){
                    $('#trEncomienda').show();
                }

                $('#chkEncomienda').click(function(){
                    if(encomienda==0){
                        $('#divPasajeros').hide();
                        $('#btnRegistrarViaje').removeAttr("disabled");
                        encomienda=1;
                    }else{
                        $('#divPasajeros').show();
                        $('#btnRegistrarViaje').attr("disabled", "true");
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

                if(monto_especifico==1){
                    $('#chkMontoEspecifico').click();
                }
                if(encomienda_viaje==1){
                    $('#chkEncomienda').click();
                }
                if(adicional!=0){
                    $('#chkMontoAdicional').click();
                }


                $.post("../../request/viaje/ajaxComboConductoresEditar.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#selectConductor').html(r);
                });
                $.post("../../request/viaje/ajaxComboListaEditar.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#selectLista').html(r);
                });
                $.post("../../request/viaje/ajaxComboHorarioEditar.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#selectHorario').html(r);
                });

                $.post("../../request/viaje/ajaxComboRutasEditar.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#selectRuta').html(r);
                });

                $.post("../../request/viaje/ajaxComboEmpresasEditar.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#selectEmpresa').html(r);
                });
                $.post("../../request/viaje/ajaxComboDepartamentoEditar.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#selectDepartamento').html(r);
                });

                $.post("../../request/viaje/ajaxComboEstatusEditar.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#selectEstatus').html(r);
                });

                $.post("../../request/viaje/ajaxGetFecha.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#txtFechaViaje').val(r);
                });

                $.post("../../request/viaje/ajaxGetPasajeros.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#tablaPasajeros').append(r);
                });

                $.post("../../request/viaje/ajaxGetMovilizaciones.php", {viaje:<?php echo $_GET['id'] ?>}, function(r){
                    $('#tablaMovilizaciones').append(r);
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


                $('a#nuevoPasajero').colorbox({transition:'fade', speed:800,width:"450px", height:"250px",onComplete:function(){

                    
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
                                required: true,remote:{url:"../../request/viaje/ajaxCheckPasajeroEditar.php",type:"post"},
                                messages: {
                                    required: "<br>Este campo es requerido",
                                    remote:"Este pasajero ya ha sido registrado"
                                }
                            });

                            if($('#frmPasajero').validate().element("#selectPasajero")){
                                $('#btnRegistrarPasajero').attr("disabled","true");
                                $.post("../../request/viaje/ajaxRegistrarPasajeroEditar.php", $('#frmPasajero').serialize(), function(r){
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
                                $.post("../../request/viaje/ajaxRegistrarMovilizacionEditar.php", $('#frmMovilizacion').serialize(), function(r){
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
                        $.post("../../request/viaje/ajaxEliminarPasajeroEditar.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Pasajero eliminado satisfactoriamente');
                                $("tr[id=pasajero"+id+"]").remove();

                                npasajeros-=1;
                                if(npasajeros<=0){
                                   // $('#btnRegistrarViaje').attr("disabled", "true");
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
                        $.post("../../request/viaje/ajaxEliminarMovilizacionEditar.php",{id:id},function(r){
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
                            $('#frmViaje').validate().element("#txtPagoViaje")){
                            $('#btnRegistrarViaje').attr("disabled","true");
                            $('#txtFechaViaje').removeAttr("disabled");
                            $.post("../../request/viaje/ajaxGuardarViajeEditado.php", $('#frmViaje').serialize()+"&id_viaje="+viaje_id, function(r){
                                if(r=="ok")
                                {
									$.post("../../request/viaje/ajaxViajeTerminado.php", {id:<?php echo $_GET['id'] ?>,editar:1,txtNSolicitud:$("#txtNSolicitud").val()}, function(r){
										document.location="registroSatisfactorioEditar.php"
                                    });
                                    
                                }else{
                                    alert("No se puedo registrar el Viaje");
                                    //document.location=document.location;
                                }
                            });
                        }

                    }else{

                        if($('#frmViaje').validate().element("#txtDestinoFinal") &
                            $('#frmViaje').validate().element("#txtFechaViaje")){
                            $('#btnRegistrarViaje').attr("disabled","true");
                            $('#txtFechaViaje').removeAttr("disabled");
                            $.post("../../request/viaje/ajaxGuardarViajeEditado.php", $('#frmViaje').serialize()+"&id_viaje="+viaje_id, function(r){
                                if(r=="ok")
                                {
                                    $.post("../../request/viaje/ajaxViajeTerminado.php", {id:<?php echo $_GET['id'] ?>,editar:1,txtNSolicitud:$("#txtNSolicitud").val()}, function(r){
                                        document.location="registroSatisfactorioEditar.php"
                                    });
                                    
                                    
                                }else{
                                    alert("No se puedo registrar el Viaje");
                                    //document.location=document.location;
                                }
                            });
                        }
                    }

                });

                $('#frmViaje').validate({errorPlacement: function(error, element) {
                        error.appendTo(element.parent());

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

            $('#btnRegistrarViaje').removeAttr("disabled");

        </script>
    </head>
    <body>
        <div id="main">
            <div id="header"><?php require_once HEADER ?></div>
            <div id="contenido">
                <div id="maincontenido">
                    <br><br><br>
                    <span class="titulo">&nbsp;&nbsp;EDITANDO VIAJE <?php echo $_GET['id'] ?></span><br><br><br>

                    <form id="frmViaje">

                        <input id="txtEncomienda" name="txtEncomienda" type="hidden">
                        
                        <table class="testilo" width="900px" cellspacing="0">
                                <tr>
                                    <th colspan="2">Datos del viaje</th>
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
                                        <input id="txtDestinoFinal" name="txtDestinoFinal" type="text" size="60" value="<?php echo $viaje['destino_final'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Como llegar:</strong></td>
                                    <td>
                                        <textarea id="txtComoLlegar" name="txtComoLlegar" type="text" cols="60" rows="6"><?php echo $viaje['como_llegar'] ?></textarea>
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
                                        <input id="txtEncomienda" name="txtEncomienda" type="text" size="45" value="<?php echo $viaje['observaciones'] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Estatus:</strong></td>
                                    <td>
                                        <select id='selectEstatus' name='selectEstatus'>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Recargo (%)</strong></td>
                                    <td>
                                        <input id="txtRecargo" name="txtRecargo" type="text" size="15" value="<?php echo $porc ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Leyenda</strong></td>
                                    <td>
                                        <input id="txtLeyenda" name="txtLeyenda" type="text" size="15" value="<?php echo $viaje['leyenda'] ?>">
                                    </td>
                                </tr>
                                
                                
                                <tr>
                                    <td><strong>Con Retorno</strong></td>
                                    <td>
                                        <?php
                                        if($viaje['retorno']==1) {
                                            echo "<input id=\"chkRetorno\" name=\"chkRetorno\" type=\"checkbox\" value=\"1\" checked>";
                                        }else {
                                            echo "<input id=\"chkRetorno\" name=\"chkRetorno\" type=\"checkbox\" value=\"1\">";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        
                        <div id="divPasajeros">
                            <br><br><br><br>
                            <strong class="titulo">&nbsp;&nbsp;PASAJEROS</strong><br><br>
                            <a id="nuevoPasajero" href="npasajero.php">Nuevo Pasajero</a><br><br>
                            <table class="testilo" width="900px" border="0" cellspacing="0" id="tablaPasajeros">
                                <tr class="tableTitle">
                                    <th width="234" height="25">Pasajero</th>
                                    <th width="267">Teléfono</th>
                                    <th width="267">Eliminar</th>
                                </tr>
                            </table>
                        </div>
                        <br><br><br><br>
                        <strong class="titulo">&nbsp;&nbsp;MOVILIZACIONES</strong><br><br>
                        <a id="nuevaMovilizacion" href="nmovilizacion.php">Nueva Movilización</a><br><br>
                        <table class="testilo" width="900px" border="0" cellspacing="0" id="tablaMovilizaciones">
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
                                        <td>

                                            <?php
                                            if($viaje['monto_especifico']==1) {
                                                echo "<input id=txtCostoViaje name=\"txtCostoViaje\" type=\"text\" value='".$viaje['monto_esp_empresa']."'>&nbsp;&nbsp;&nbsp;(No incluir horas de espera y costo de movilizaciones)";
                                            }else {
                                                echo "<input id=txtCostoViaje name=\"txtCostoViaje\" type=\"text\" value=0>&nbsp;&nbsp;&nbsp;(No incluir horas de espera y costo de movilizaciones)";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pago del Viaje <br>(a Conductor):</strong></td>
                                        <td>

                                            <?php
                                            if($viaje['monto_especifico']==1) {
                                                echo "<input id=\"txtPagoViaje\" name=\"txtPagoViaje\" type=\"text\" value='".$viaje['monto_esp_conductor']."'>";
                                            }else {
                                                echo "<input id=\"txtPagoViaje\" name=\"txtPagoViaje\" type=\"text\" value=0>";
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                </table><br>
                                <input type="checkbox" id="chkMontoAdicional" name="chkMontoAdicional" value="1">&nbsp;&nbsp;&nbsp;Monto Adicional
                                <table id="tablaAdicional">
                                    <tr>
                                        <td><strong>Monto Adicional:</strong></td>
                                        <td>

                                            <?php
                                            if($viaje['adicional']!=0) {
                                                echo "<input id=\"txtAdicional\" name=\"txtAdicional\" type=\"text\" value='".$viaje['adicional']."'>";
                                            }else {
                                                echo "<input id=\"txtAdicional\" name=\"txtAdicional\" type=\"text\" value=0>";
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Monto Adicional (Conductor):</strong></td>
                                        <td>

                                            <?php
                                            if($viaje['adicional_conductor']!=0) {
                                                echo "<input id=\"txtAdicionalConductor\" name=\"txtAdicionalConductor\" type=\"text\" value='".$viaje['adicional_conductor']."'>";
                                            }else {
                                                echo "<input id=\"txtAdicionalConductor\" name=\"txtAdicionalConductor\" type=\"text\" value=0>";
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                </table><br>
                                <input type="checkbox" id="chkHoras" name="chkHoras" value="1">&nbsp;&nbsp;&nbsp;Horas de espera
                                <table id="tablaHoras">
                                    <tr>
                                        <td><strong>Horas de espera:</strong></td>
                                        <td><input id="txtHoras" name="txtHoras" type="text" value="<?php echo $viaje['horas_espera'] ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Horas de espera (Conductor):</strong></td>
                                        <td><input id="txtHorasConductor" name="txtHorasConductor" type="text" value="<?php echo $viaje['horas_conductor'] ?>"></td>
                                    </tr>
									<tr>
                                        <td><strong>Nº Solicitud</strong></td>
                                        <td><input id="txtNSolicitud" name="txtNSolicitud" type="text" value="<?php echo $viaje['nsolicitud'] ?>"></td>
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