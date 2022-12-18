<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
unset($_SESSION['idLista']);
$_SESSION['idLista']=$id;
$lista=$model->getModel($id, "listas");
?>

<div id="divPopUp">
    <div id="divNuevoLista">
        <br>
        <span class="titulo">&nbsp;&nbsp;EDITAR LISTA</span><br><br>
        <form id="frmLista">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtDescripcion" name="txtDescripcion" value="<?php echo $lista['descripcion'] ?>"></td>
                </tr>
                <tr>
                    <td> Valor Hora espera (Bs):</td>
                    <td><input id="txtHora" name="txtHora" value="<?php echo $lista['hora_espera'] ?>"></td>
                </tr>
                <tr>
                    <td>Valor Hora espera (Conductor) Bs:</td>
                    <td><input id="txtHoraConductor" name="txtHoraConductor" value="<?php echo $lista['hora_espera_conductor'] ?>"></td>
                </tr>
                <tr>
                    <td>Valor de Movilizaciones:</td>
                    <td><input id="movilizaciones" name="movilizaciones" value="<?php echo $lista['movilizaciones'] ?>"></td>
                </tr>
            </table>
                
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>