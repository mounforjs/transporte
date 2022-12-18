<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of movilizacion
 *
 * @author aarenas
 */

require_once CLASES.'/model.php';

class Movilizacion extends model {

    function totalMovilizaciones($viajeId,$campo)
    {
        $total=$this->getTotal("movilizaciones",$campo,$viajeId,"viaje_id");
        if($total==""){
            $total=0;
        }
        return $total;
    }

}
?>
