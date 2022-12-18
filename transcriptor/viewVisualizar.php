<?php
require_once '../rutas.php';
require_once DB;
require_once CLASES . '/user.php';
require_once CLASES . '/model.php';
require_once '../pagina/functions.php';
session_start();

abrirConexion();

if(comprobarSessionTranscriptor($_SESSION['username'], $_SESSION['password']))
{
    $user=new User();
    $user=$_SESSION['user'];
    cerrarConexion();
}else
{
    cerrarConexion();
    header("location:../pagina/login.php");
}

$idLote = $_GET['id'];
$empresa_id = $_GET['empresa'];


abrirConexion();
$model = new model();


$lote = $model->getModelCondicionado("lotes", "id=".$idLote);
$lista_default = $model->getModelCondicionado("listas", "id=".$lote['default_list']);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>:: LOTE ::</title>

    <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
    <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
    <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="../../js/jquery/jquery-1.4.2.min.js"></script> 
    
    


    <script src="../../js/jquery/jquery-ui-1.8.js"></script>
    <script src="../../js/jquery/colorbox.js"></script>
   
    <script src="../../js/jquery/jquery.jkey-1.1.js"></script>
    <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>
    <script src="../../js/jquery/jquery.jkey-1.1.js"></script>
    <link href="../../css/jquery.tagsinput.css" type="text/css" rel="stylesheet">
    <script src="../../js/jquery/jquery.tagsinput.js"></script>
    <script src="../../js/jquery/init.js"></script>
    <script src="../../js/jquery/sessvars.js"></script>

    <script type="text/javascript">


        $().ready(function() {


          jQuery.extend(jQuery.validator.messages, {
              required: "Este campo es requerido",
              number: "Este campo solo acepta datos numericos"
          });


          empresa_id =<?php echo $_GET['empresa'] ?>;
          var lote_id =<?php echo $_GET['id'] ?>;

          if (empresa_id == 1) {
            $.post("./request/ajaxGetLoteEmpresaClasificado.php", {id:<?php echo $_GET['id'] ?>}, function(r) {
                $('#tablaViajes').append(r);
            });


        } else {
            $.post("./request/ajaxGetViajesLote.php", {id: lote_id}, function(r) {
                $('#tablaViajes').append(r);
            });
        }

        $.post("../request/lote/ajaxGetLoteDescripcion.php", {id: lote_id}, function(r) {
            $('#divLoteDescripcion').append(r);
        });

        $('#btnConfirmar').click(function() {
            $.post("../request/viaje/ajaxConfirmarSolicitudes.php", $('#frmViajesLote').serialize(), function() {
                document.location = document.location;
            })
        });

        $("a[name='sinSolicitud']").live("click", function() {
            $.post("../request/viaje/ajaxSinSolicitud.php", {id: this.id}, function() {
                document.location = document.location;
            });
        });

        $("a[name='eliminar-viaje']").live("click", function() {
            if (confirm("¿Esta seguro de que desea eliminar este viaje?2")) {
                $.post("../request/viaje/ajaxEliminarViaje.php", {id: this.id}, function(r) {
                    if (r == "ok") {
                        document.location = document.location;
                    }
                });
            }
        });


        $("a[name='eliminar']").live("click", function() {
            id = this.id;
            if (confirm("¿Esta seguro que desea sacar este viaje del lote?")) {
                $.post("../request/lote/ajaxEliminarViajeLote.php", {id: id}, function(r) {
                    if (r == "ok") {
                        alert('Operación realizada satisfactoriamente');
                        $("tr[id=" + id + "]").remove();
                    } else {
                        alert("No se pudo realizar la operación solicitada");
                    }
                });
            }
        });

        $("input[type='checkbox']").live("click", function() {

            if ($(this).is(":checked")) {
                $('#separar').show();
                $('#sacar').show();
                $('#ss').show();
                $('#cs').show();
            } else {

                if ($("input[type='checkbox']:checked").length <= 0) {
                    $('#separar').hide();
                    $('#sacar').hide();
                    $('#ss').hide();
                    $('#cs').hide();
                }
            }
        });

        $('a#separar').colorbox({transition: 'fade', speed: 400, width: "570px", height: "350px", onComplete: function() {
            $('#nuevoLote').hide();
            $('#loteExistente').hide();
            $('#registrar').hide();

            $('#nuevo').click(function() {
                $('#nuevoLote').show();
                $('#loteExistente').hide();
                $('#registrar').show();

                $("#selectLote").rules("remove");


                $("#txtDescripcion").rules("add", {
                    required: true,
                    messages: {
                        required: "<br>Este campo es requerido"
                    }
                });

                $("#selectEmpresa").rules("add", {
                    required: true,
                    messages: {
                        required: "<br>Este campo es requerido"
                    }
                });

                $("#txtFactura").rules("add", {
                    required: true, number: true,
                    messages: {
                        required: "<br>Este campo es requerido",
                        number: "<br>ESte campo solo admite caracteres numericos"
                    }
                });

            });




            $('#existente').click(function() {
                $('#nuevoLote').hide();
                $('#loteExistente').show();
                $('#registrar').show();

                $("#txtDescripcion").rules("remove");
                $("#selectEmpresa").rules("remove");
                $("#selectEmpresa").rules("remove");
                $("#txtFactura").rules("remove");

                $("#selectLote").rules("add", {
                    required: true,
                    messages: {
                        required: "<br>Este campo es requerido"
                    }
                });

            });

            $('#btnRegistrar').click(function() {




                if ($('#frmSeparar').validate().element("#txtDescripcion") &
                    $('#frmSeparar').validate().element("#txtFactura") &
                    $('#frmSeparar').validate().element("#selectEmpresa") &
                    $('#frmSeparar').validate().element("#selectLote")) {

                    $.post("../request/lote/ajaxSeparar.php", $('#frmViajesLote').serialize() + "&" + $('#frmSeparar').serialize(), function(r) {

                        if (r == "ok") {
                            alert("Lote separado satisfactoriamente");
                            document.location = document.location;
                        } else {
                            alert("No fue posible separar el lote");
                        }
                    });
            }


        });

            $('#frmSeparar').validate({errorPlacement: function(error, element) {
                error.appendTo(element.parent());

            }});


        }});

        $("#sacar").click(function() {
            $.post("../request/lote/ajaxSacar.php", $('#frmViajesLote').serialize(), function(r) {
                if (r == "ok") {
                    alert("Viajes sacados satisfactoriamente");
                    document.location = document.location;
                } else {
                    alert("No se ha podido sacar los viajes");
                }
            });
        });

        $("#ss").click(function() {
            $.post("../request/lote/ajaxSS.php", $('#frmViajesLote').serialize(), function(r) {
                if (r == "ok") {
                    alert("Viajes marcados sin solicitud satisfactoriamente");
                    document.location = document.location;
                } else {
                    alert("No se ha podido marcar los viajes");
                }
            });
        });

        $("#cs").click(function() {
            $.post("../request/lote/ajaxCS.php", $('#frmViajesLote').serialize(), function(r) {
                if (r == "ok") {
                    alert("Viajes marcados con solicitud satisfactoriamente");
                    document.location = document.location;
                } else {
                    alert("No se ha podido marcar los viajes");
                }
            });
        });



       /* $("a[name='viewviaje']").live("click", function() {
            $(this).colorbox({open: true, href: "../viaje/viewViaje.php?id=" + $(this).attr("id"), transition: 'fade', speed: 200, width: "620px", height: "495px", onComplete: function() {
                $("tr[class='trhide']").hide();
            }});
        });*/

        $("a[name='clonarViaje']").live("click", function() {

            idViaje = $(this).attr("id");
            $.colorbox({href: "../viaje/clonarViaje.php?id=" + $(this).attr("id"), transition: 'fade', speed: 400, width: "780px", height: "680px", onComplete: function() {


             $.post("../../request/viaje/ajaxGetPasajerosJSON.php", {viaje:idViaje}, function(r) {

                json_pasajeros = JSON.parse(r);

                $.each(json_pasajeros, function(i,pasajero){

                   console.log(pasajero.pasajero_id);



                   $("#tablaPasajeros").append("<tr><td><input id='inputPasajero' type='text' size='60' name='pasajerosviaje[]' value='"+pasajero.pasajero_id+"'></td></tr>");

               });

                $("#inputPasajero").autocomplete({
                   source: "../../request/general/autocomplete_pasajeros.php",
                   minLength: 2,
                   select: function(event,ui){

                      $("#inputPasajero").text(ui.item.label)

                  }
              });

            });




             $("a[name='actionClonarViaje']").click(function() {

                $.post("../../request/viaje/ajaxClonarViaje.php", $("#frmClonar").serialize() + "&idViaje=" + idViaje, function(r) {

                    result = JSON.parse(r);

                    if(result.success=="true"){

                        $.post("../../request/viaje/ajaxViajeTerminado.php", {id:result.viaje,editar:1}, function(r){

                            alert("Viaje clonado satisfactoriamente, el ID del nuevo viaje es:"+result.viaje);
                                           // document.location = document.location;

                                       });


                    }


                });
            });





         }});

        });


        $("a[name='clonarViaje2']").live("click", function() {

            idViaje = $(this).attr("id");
            $.colorbox({href: "../viaje/clonarViaje2.php?id=" + $(this).attr("id"), transition: 'fade', speed: 400, width: "780px", height: "680px", onComplete: function() {


                $.post("../../request/viaje/ajaxGetPasajerosJSON.php", {viaje:idViaje}, function(r) {

                    json_pasajeros = JSON.parse(r);

                    $.each(json_pasajeros, function(i,pasajero){

                        console.log(pasajero.pasajero_id);





                        $("#tablaPasajeros").append("<tr><td><input id='inputPasajero' type='text' size='60' name='pasajerosviaje[]' value='"+pasajero.pasajero_id+"'></td></tr>");

                    });

                    $("#inputPasajero").autocomplete({
                        source: "../../request/general/autocomplete_pasajeros.php",
                        minLength: 2,
                        select: function(event,ui){

                            $("#inputPasajero").text(ui.item.label)

                        }
                    });

                });





                $("a[name='actionClonarViaje']").click(function() {

                    if($("#frmClonar2").valid()){

                        $.post("../../request/viaje/ajaxClonarViaje3.php", $("#frmClonar2").serialize() + "&idViaje=" + idViaje, function(r) {

                            result = JSON.parse(r);

                            if(result.success=="true"){

                                $.post("../../request/viaje/ajaxViajeTerminado2.php", {id:result.viaje,editar:1}, function(r){

                                    alert("Viaje clonado satisfactoriamente, el ID del nuevo viaje es:"+result.viaje);
                                                   // document.location = document.location;

                                               });


                            }


                        });

                    }

                });





            }});

        });



        $("a[name='clonarViaje3']").live("click", function() {

            idViaje = $(this).attr("id");
            $.colorbox({href: "./clonarViaje3.php?id=" + $(this).attr("id"), transition: 'fade', speed: 480, width: "800px", height: "730px", onComplete: function() {


                $.post("../../request/viaje/ajaxGetPasajerosJSON.php", {viaje:idViaje}, function(r) {

                    json_pasajeros = JSON.parse(r);

                    $.each(json_pasajeros, function(i,pasajero){

                        $("#tablaPasajeros").append("<tr><td><input id='inputPasajero' type='text' size='60' name='pasajerosviaje[]' value='"+pasajero.pasajero_id+"'></td></tr>");

                    });

                    $("#inputPasajero").autocomplete({
                        source: "../../request/general/autocomplete_pasajeros.php",
                        minLength: 2,
                        select: function(event,ui){

                            $("#inputPasajero").text(ui.item.label)

                        }
                    });

                });





                $("a[name='actionClonarViaje']").click(function() {

                    if($("#frmClonar2").valid()){

                        $.post("./request/ajaxClonarViaje3.php", $("#frmClonar2").serialize() + "&idViaje=" + idViaje, function(r) {

                            result = JSON.parse(r);

                            if(result.success=="true"){

                                $.post("../../request/viaje/ajaxViajeTerminado2.php", {id:result.viaje,editar:1}, function(r){

                                    alert("Viaje clonado satisfactoriamente, el ID del nuevo viaje es:"+result.viaje);
                                                   // document.location = document.location;

                                               });


                            }


                        });

                    }

                });





            }});

        });





        $("a[name='editarViaje2']").live("click", function() {

            idViaje = $(this).attr("id");
            $.colorbox({href: "../viaje/editarViajeLBox.php?id=" + $(this).attr("id"), transition: 'fade', speed: 400, width: "780px", height: "680px", onComplete: function() {


                $.post("../../request/viaje/ajaxGetPasajerosJSON.php", {viaje:idViaje}, function(r) {

                    json_pasajeros = JSON.parse(r);

                    $.each(json_pasajeros, function(i,pasajero){

                        console.log(pasajero.pasajero_id);


                    });


                });





                $("a[name='actionEditarViaje']").click(function() {

                    if($("#frmClonar2").valid()){

                        $.post("../../request/viaje/ajaxEditarViajeClonado.php", $("#frmClonar2").serialize() + "&idViaje=" + idViaje, function(r) {

                            result = JSON.parse(r);

                            if(result.success=="true"){

                                $.post("../../request/viaje/ajaxViajeTerminado2.php", {id:result.viaje,editar:1}, function(r){

                                    alert("Viaje Editado satisfactoriamente");
                                                   // document.location = document.location;

                                               });


                            }


                        });

                    }

                });





            }});

        });



        $("a[name='editarViaje3']").live("click", function() {

            idViaje = $(this).attr("id");
            $.colorbox({href: "./editarViajeLBox3.php?id=" + $(this).attr("id")+"&lote="+lote_id, transition: 'fade', speed: 400, width: "800px", height: "730px", onComplete: function() {



                $.post("../../request/viaje/ajaxGetPasajerosJSON.php", {viaje:idViaje}, function(r) {

                    json_pasajeros = JSON.parse(r);

                    $.each(json_pasajeros, function(i,pasajero){

                        //console.log(pasajero.pasajero_id);


                    });


                });







                $("a[name='actionEditarViaje']").click(function() {

                    if($("#frmClonar2").valid()){

                        $.post("./request/ajaxEditarViajeClonado3.php", $("#frmClonar2").serialize() + "&idViaje=" + idViaje, function(r) {

                            result = JSON.parse(r);

                            if(result.success=="true"){

                                $.post("../../request/viaje/ajaxViajeTerminado2.php", {id:result.viaje,editar:1}, function(r){

                                    alert("Viaje Editado satisfactoriamente");
                                                   // document.location = document.location;

                                               });


                            }


                        });

                    }

                });





            }});

        });


        $("a[name='nviaje']").live("click", function() {

            lote = $(this).attr("lote");

            $.colorbox({href: "./nviaje.php?lote="+lote, transition: 'fade', speed: 400, width: "800px", height: "730px", onComplete: function() {


                /*$.post("../request/viaje/ajaxGetPasajerosJSON.php", {viaje:idViaje}, function(r) {

                    json_pasajeros = JSON.parse(r);

                    $.each(json_pasajeros, function(i,pasajero){

                        console.log(pasajero.pasajero_id);

                    });
                });*/


                $("a[name='nuevoviaje']").click(function() {

                    if($("#frmClonar2").valid()){

                        $.post("./request/ajaxNuevoViaje.php", $("#frmClonar2").serialize() + "&lote=" + lote, function(r) {

                            result = JSON.parse(r);

                            if(result.success=="true"){

                                $.post("../request/viaje/ajaxViajeTerminado2.php", {id:result.viaje,editar:1}, function(r){

                                    alert("Viaje Editado satisfactoriamente");
                                        // document.location = document.location;

                                    });


                            }


                        });

                    }

                });

            }});


        });






        idClonado =<?php
        if (isset($_GET['idClonado'])
            )
            echo $_GET['idClonado'];else {
                echo "0";
            }
            ?>;

            if (idClonado != 0) {
                alert("Viaje Clonado ! ID " + idClonado);
                $("#" + idClonado + " > td").css("background-color", "green");
            }



            $('#separar').hide();
            $('#sacar').hide();
            $('#ss').hide();
            $('#cs').hide();


            $("#selectDepartamentos").change(function() {

                if ($(this).val() == "Todos") {
                    $.post("../../request/lote/ajaxGetViajesDepartamentoLote.php", {id: lote_id}, function(r) {
                        $('#tablaViajes').html(r);
                    })
                } else {
                    $.post("../../request/lote/ajaxGetViajesDepartamentoLote.php", {departamento: $("#selectDepartamentos").val(), id: lote_id}, function(r) {
                        $('#tablaViajes').html(r);
                    })
                }

            });

            if (empresa_id == 1) {

                $.post("../../request/lote/ajaxGetViajesSinDepartamentos.php", {empresa: empresa_id, lote: lote_id}, function(q) {

                    if (q != 1) {

                        $.colorbox({open: "true", href: "viajesSinDepartamentos.php", transition: 'fade', speed: 400, width: "890px", height: "600px", onComplete: function() {

                            $("#good").html(q);


                            $(".selectConductor").autocomplete({
                                source: "../../request/general/autocomplete.php",
                                minLength: 2,
                                select: function(event, ui) {

                                    this.value = $(this).attr("viaje") + "-" + ui.item.id;

                                    return false;


                                }


                            });

                            $(".selectDepartamento").autocomplete({
                                source: "../../request/general/autocomplete_departamentos.php",
                                minLength: 2,
                                select: function(event, ui) {


                                    this.value = $(this).attr("viaje") + "-" + ui.item.id;
                                    return false;

                                }
                            });



                            $("#btnRegistrarSinDepartamentos").click(function() {
                                $("#btnRegistrarSinDepartamentos").attr("disabled", "disabled");
                                if ($("select[class='departamento'] option:selected[value='']").length == 0) {

                                    $.post("../../request/lote/ajaxRegistrarViajesSinDepartamento.php", $("#frmViajesSinDepartamento").serialize(), function(r) {
                                        if (r == "true") {
                                            alert("Registrado satisfactoriamente");
                                            document.location = document.location;
                                        } else {
                                            alert("No se pudo realizar la acción, intente nuevamente");
                                                    //document.location=document.location;
                                                }
                                            });

                                } else {
                                    alert("Asegurece de haber seleccionado los departamentos correspondientes")
                                }

                            });

                            $('#frmViajesSinDepartamento').validate({errorPlacement: function(error, element) {
                                error.appendTo(element.parent());

                            }});


                        }});


                    }


                });


            }


            $("#selectLista").change(function(){

                $.post(
                   "/request/lote/ajaxSetDefaultList.php", 
                   { lista: $("#selectLista").val(), lote:lote_id },
                       function(r){

                        json = JSON.parse(r);
                        alert(json.msg);

                       }
                );
              
            });




        });

    </script>
</head>
<body>
    <div id="main">
        <div id="header"><?php require_once HEADER_TRANSCRIPTOR ?></div>
        <div id="contenido">
            <div id="maincontenido">
                <br><br><br>
                <span class="titulo">DETALLE DE LOTE</span>
                <br><br><br>
                <div id="divLoteDescripcion"></div><br><br>
                <br>
                <fieldset>
                    <legend>Selección de viajes</legend>
                    Departamento:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <select id="selectDepartamentos">
                        <option value="Todos" selected>Todos</option>
                        <?php $model->getCombolModel("departamentos", "nombre") ?>
                    </select><BR>

                </fieldset><br>
                <br><br>

                <div style="width:1100px">
                    <div style="float:left"><a name='nviaje' class="btn btn-warning" lote="<?php echo $_GET['id'] ?>">Nuevo Viaje</a></div>
                    <div style="float:right">
                        Lista por defecto: <select id='selectLista' name='selectLista'>
                            
                            <?php 
                                 $lote = $model->getModelCondicionado("lotes", "id=".$_GET['id']);
                                  echo $model->getComboSelectedListas("listas", "descripcion", $lote['default_list'] );
                             ?>
                        </select>&nbsp;&nbsp;&nbsp;<?php echo "<a target='_blank' href='/transcriptor/visualizarLista.php?id=".$lote['default_list']."'>Ver Lista</a>"; ?>

                    </div>
                </div>

                
                <br><br>
                <a id="separar" href="/pagina/lote/separarLote.php">SEPARAR</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="sacar">SACAR</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="ss">MARCAR SIN SOLICITUD</a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="cs">MARCAR CON SOLICITUD</a><br>
                <form id="frmViajesLote">
                    <br>
                    <table id="tablaViajes" cellspacing="0" width="1100px" class="testilo">

                    </table>
                </form>
                <br><br>
                <input id="btnConfirmar" type="button" value="CONFIRMAR EXISTENCIA DE SOLICITUD">
                <br><br><br>
            </div>
        </div>
    </div>
</body>
</html>
