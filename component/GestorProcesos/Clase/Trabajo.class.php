<?php
namespace component\GestorProcesos\Clase;

include_once ('core/connection/DAL.class.php');


class Trabajo{
    
    
    public function __construct(){
    	
    }
    
    public function crearTrabajo($idProceso =''){
    	
    	if(is_null($idProceso)||$idProceso =='') return false;
    	
    	$parametros = array();
    	
    	$parametros['proceso_id'] = $idProceso;
    	$parametros['estado_registro_id'] = 1;
    	
    	$obj =  new \DAL();
    	$obj->setConexion('academica');
    	return $obj->crearTrabajo($parametros);
    	 
    	 
    	
    }
    
    public function actualizarTrabajo(){
    	
    }
    
    public function consultarTrabajo(){
    	
    }
    
    
    
    
    
}