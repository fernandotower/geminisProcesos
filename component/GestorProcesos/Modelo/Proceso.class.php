<?php
namespace component\GestorProcesos\Modelo;

include_once ('component/GestorProcesos/Modelo/Base.class.php');


class Proceso extends Base{
    
    
    public function __construct(){
    	
    }
    
    public function crearProceso($nombre, $alias = ' ', $descripcion = '', $estadoRegistroId = 1){
    	
    	if(is_null($nombre)|$nombre=='') return false;
    	if(is_null($alias)|$alias=='') return false;
    	
    	$parametros = array();
    	
    	$parametros['nombre'] = $nombre;
    	$parametros['alias'] = $alias;
    	if(!is_null($descripcion)&&$descripcion!='') $parametros['descripcion'] = $descripcion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!='') $parametros['estado_registro_id'] = $estadoRegistroId;
    	
    	return $this->dao-> crearProceso($parametros);
    	
    }
    
    public function actualizarProceso($id ,$nombre, $alias, $descripcion = '', $estadoRegistroId = 1){
    	
    	if(is_null($id)||$id=='') return false;
    	
    	$parametros = array();
    	
    	$parametros['id'] = $id;
    	if(!is_null($nombre)&&$nombre!='') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!='') $parametros['alias'] = $alias;
    	if(!is_null($descripcion)&&$descripcion!='') $parametros['descripcion'] = $descripcion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!='') $parametros['estado_registro_id'] = $estadoRegistroId;
    	 
    	return $this->dao-> actualizarProceso($parametros);
    	
    }
    
    public function consultarProceso($id = '' ,$nombre = '', $alias = '', $descripcion = '', $estadoRegistroId = '', $fecha = ''){
    	$parametros = array();
    	
    	if(!is_null($id)&&$id!='') $parametros['id'] = $id;
    	if(!is_null($nombre)&&$nombre!='') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!='') $parametros['alias'] = $alias;
    	if(!is_null($descripcion)&&$descripcion!='') $parametros['descripcion'] = $descripcion;
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!='') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($fecha)&&$fecha!='') $parametros['fecha_registro'] = $fecha;
    	
    	return $this->dao-> consultarProceso($parametros);
    	 
    }
    
    public function activarInactivarProceso($id ){
    	 
    	if(is_null($id)||$id=='') return false;
    	 
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> activarInactivarProceso($parametros);
    	 
    }
    
    public function duplicarProceso($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> duplicarProceso($parametros);
    
    }
    
    
    public function eliminarProceso($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> eliminarProceso($parametros);
    
    }
    
    
    
    
    
}