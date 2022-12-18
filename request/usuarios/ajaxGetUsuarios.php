<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/user.php';
require_once DB;
abrirConexion();

$r="";
$user=new User();
$list=$user->getList("users",0);

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        if($estado==1){
            $estado="Activo";
        }else{
            $estado="Inactivo";
        }

        $r.="<tr>
        <td>$id</td>
        <td>$nombre</td>
        <td>$username</td>
        <td>$rol</td>
        <td>$estado</td>
        <td><a id='".$id."' name='editarUsuario' href='../pagina/editUsuario.php?idUsuario=".$id."&nombre=".$nombre."&username=".$username."&estado=".$estado."&rol=".$rol."'>Editar</a>&nbsp;&nbsp;<a id='".$id."' name='cambiarEstado'>Cambiar Estado</a></td>
      </tr>";
    }
}
cerrarConexion();

echo $r;
?>