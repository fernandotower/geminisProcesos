<?php
namespace component\GestorProcesos\Modelo;

include_once ('component/GestorProcesos/Modelo/Base.class.php');


class Trabajo extends Base{
    
    
    public function __construct($conexion){
    	
    }
    
    
    
    public function crearTrabajo($idProceso =''){
    	
    	if(is_null($idProceso)||$idProceso =='') return false;
    	
    	$parametros = array();
    	
    	$parametros['proceso_id'] = $idProceso;
    	$parametros['estado_registro_id'] = 1;
    	
    	return $this->dao->crearTrabajo($parametros);
    	 
    	 
    	
    }
    
    public function finalizarTrabajo($idTrabajo = ''){
    	if($idTrabajo==''||is_null($idTrabajo)) return false;
    	$parametros = array();
    	 
    	$parametros['id'] = $idTrabajo;
    	$parametros['estado_registro_id'] = 2;
    	 
    	return $this->dao->actualizarTrabajo($parametros);

    }
    
    public function actualizarTrabajo($id , $idProceso ='' , $estadoRegistro =''){

    	if(is_null($id)||$id=='') return false;
    	
    	$parametros = array();
    	
    	$parametros['id'] = $id;
    	if(!is_null($idProceso)&&$idProceso!='') $parametros['proceso_id'] = $idProceso;
    	if(!is_null($estadoRegistro)&&$estadoRegistro!='') $parametros['estado_registro_id'] = $estadoRegistro;
    	
    	return $this->dao-> actualizarTrabajo($parametros);
    	
    }
    
    public function consultarTrabajo($id , $idProceso , $estadoRegistro, $fecha){
    	
    	
    	 
    	$parametros = array();
    	 
    	if(!is_null($id)&&$id!='') $parametros['id'] = $id;
    	if(!is_null($idProceso)&&$idProceso!='') $parametros['proceso_id'] = $idProceso;
    	if(!is_null($estadoRegistro)&&$estadoRegistro!='') $parametros['estado_registro_id'] = $estadoRegistro;
    	if(!is_null($fecha)&&$fecha!='') $parametros['fecha_registro'] = $fecha;
    	   	
    	
    	return $this->dao-> consultarTrabajo($parametros);
    	
    }
    
    
    public function activarInactivarTrabajo($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> activarInactivarTrabajo($parametros);
    
    }
    
    public function duplicarTrabajo($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> duplicarTrabajo($parametros);
    
    }
    
    
    public function eliminarTrabajo($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> eliminarTrabajo($parametros);
    
    }
    
    
    
    
    
}