<?php
namespace component\GestorProcesos\Clase;

include_once ('core/connection/DAL.class.php');


class Proceso{
    
    
    public function __construct(){
    	
    }
    
    public function crearProceso($nombre, $alias, $descripcion = '', $estadoRegistroId = 1){
    	
    	$parametros = array();
    	
    	$dal =  new \DAL();
    	$dal->setConexion('academica');
    	
    	$parametros['nombre'] = $nombre;
    	$parametros['alias'] = $alias;
    	$parametros['descripcion'] = $descripcion;
    	$parametros['estado_registro_id'] = $estadoRegistroId;
    	
    	return $dal-> crearProceso($parametros);
    	
    }
    
    public function actualizarProceso($id ,$nombre, $alias, $descripcion = '', $estadoRegistroId = 1){
    	
    	if(is_null($id)||$id=='') return false;
    	
    	$parametros = array();
    	 
    	$dal =  new \DAL();
    	$dal->setConexion('academica');
    	 
    	$parametros['nombre'] = $nombre;
    	$parametros['alias'] = $alias;
    	$parametros['descripcion'] = $descripcion;
    	$parametros['estado_registro_id'] = $estadoRegistroId;
    	 
    	return $dal-> actualizarProceso($parametros);
    	
    }
    
    public function consultarProceso($id = '' ,$nombre = '', $alias = '', $descripcion = '', $estadoRegistroId = '', $fecha = ''){
    	$parametros = array();
    	
    	$dal =  new \DAL();
    	$dal->setConexion('academica');
    	
    	if(!is_null($nombre)&&$nombre!='') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!='') $parametros['alias'] = $alias;
    	if(!is_null($descripcion)&&$descripcion!='') $parametros['descripcion'] = $descripcion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!='') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($fecha)&&$fecha!='') $parametros['fecha_registro'] = $fecha;
    	
    	return $dal-> actualizarProceso($parametros);
    	 
    }
    
    
    
    
    
}