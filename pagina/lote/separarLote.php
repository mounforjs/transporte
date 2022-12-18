<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoLote">
        <form id="frmSeparar">
            <br>
            <div style="padding-bottom: 3px;border-bottom-style: 1px;border-bottom-style: solid;border-bottom-color: #454545">
                <span class="titulo">&nbsp;&nbsp;SEPARAR LOTE</span><br>&nbsp;<br>
                <input id="nuevo" type="radio" name="chkseparar" value="nuevo">&nbsp;Nuevo&nbsp;&nbsp;&nbsp;
                <input id="existente" type="radio" name="chkseparar" value="existente">&nbsp;Existente<br>
            </div>
            <div id="nuevoLote">

                    <table>
                        <tr>
                            <td>Nombre:</td>
                            <td><input id="txtDescripcion" name="txtDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Nº Factura:</td>
                            <td><input id="txtFactura" name="txtFactura"></td>
                        </tr>
                        <tr>
                            <td><strong>Empresa:</strong></td>
                            <td>
                                <select id='selectEmpresa' name='selectEmpresa'>
                                    <?php $model->getCombolModel("empresas", "nombre") ?>
                                </select>
                            </td>
                        </tr>
                    </table>

            </div>
            <div id="loteExistente">
                <br><br>
                Seleccione el lote:&nbsp;
                <select id='selectLote' name='selectLote'>
                      <?php echo $model->getCombolModelDESC("lotes", "descripcion") ?>
                </select>
            </div>
        </form>
        <br>
        <div id="registrar">&nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button></div>
    </div>
</div>