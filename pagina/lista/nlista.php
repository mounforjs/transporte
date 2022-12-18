<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model = new model();
abrirConexion();
?>

<script type="text/javascript">

$(document).ready(function(){


        $("#inputEstructuraLista").autocomplete({

            source: "../../request/general/autocomplete_listas.php",
            minLength: 2,
            select: function(event,ui){
                //$("#inputPasajero").text(ui.item.label)
            }
        });

});

</script>

<div id="divPopUp">
    <div id="divNuevoLista">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVA LISTA</span><br><br>
        <form id="frmLista">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtDescripcion" name="txtDescripcion"></td>
                </tr>
                <tr>
                    <td> Valor Hora espera (Bs):</td>
                    <td><input id="txtHora" name="txtHora"></td>
                </tr>
                <tr>
                    <td>Valor Hora espera (Conductor) Bs:</td>
                    <td><input id="txtHoraConductor" name="txtHoraConductor"></td>
                </tr>
                <tr>
                    <td>Basar Estrucutra de rutas en Lista (Anterior):</td>
                    <td><input id="inputEstructuraLista" name="inputEstructuraLista"></td>
                </tr>
                <tr>
                    <td>Incremento (%)</td>
                    <td><select id="selectIncremento" name="selectIncremento">
                        <option value="0">0%</option>
                        <option value="10">10%</option>
                        <option value="15">15%</option>
                        <option value="20">20%</option>
                        <option value="25">25%</option>
                        <option value="30">30%</option>
                        <option value="35">35%</option>
                        <option value="40">40%</option>
                        <option value="50">50%</option>
                        <option value="60">60%</option>
                    </select></td>
                </tr>
            </table>
                
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>