<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lista
 *
 * @author aarenas
 */

require_once CLASES.'/model.php';

class Lista extends model {


    public function listaActiva()
    {
        $id=$this->getId("listas", "estado", 1);
        return $id;
    }

    public function clonarLista($lista, $descripcion = "NUEVA LISTA", $porcentaje_incremento = 0)
    {
      
      $options =  array('fecha' =>  "'".date("Y-m-d")."'",
                        'descripcion' =>  "'".$descripcion."'",
                        'estado'  =>  0);

      //nueva Lista
      $id_lista = $this->nuevaLista($options);

      if($id_lista)
      {

        //Se consultan las rutas de la lista a clonar
        $list = $this->getListCondicional("listas_rutas",500,"lista_id=$lista ORDER BY ruta ASC");

        if($list!=false){

            while($row= pg_fetch_array($list)){
                
                extract($row);

                $precio_nuevo = $precio + ($precio * $porcentaje_incremento);
                $precio_conductores_nuevo = $precio_conductores + ($precio * $porcentaje_incremento);

                $ruta = array('lista_id'  =>  $id_lista,
                              'ruta_id' =>  $ruta_id,
                              'ruta'  =>  "'".$ruta."'",
                              'precio'  =>  $precio_nuevo,
                              'precio_conductores'  =>  $precio_conductores_nuevo);

                $this->save("listas_rutas",  $ruta);



            }
        }
      }


    }

    public function nuevaLista($options)
    {
      $result = $this->saveId("listas",$options);

      if($result)
      {
        return $result->id;
      }else
      {
        return false;
      }
      
    }

    public function ItemExist(String $rutaId)
    {
     
      
      $result = $this->getModelCondicionado("listas_rutas", "ruta_id = ".$rutaId);

      if(!empty($result))
      {
        return $result;
      }else{
        return false;
      }

    }




}
?>
