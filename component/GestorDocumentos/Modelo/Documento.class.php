<?php
namespace component\GestorDocumentos\Modelo;

include_once ('component/GestorDocumentos/Modelo/Base.class.php');


class Documento extends Base{
    
    
    public function __construct(){
    	
    }
    
    public function crearDocumento($nombre = '', $alias = '',$nombreReal = '',$descripcion = '', $etiquetas = '',$rutaId = '',  $estadoRegistroId = ''){
    	
    	$parametros = array();
    	
    	
    	if(is_null($nombre)||$nombre== '') return false;
    	
    	if(is_null($nombreReal)||$nombreReal== '') return false;
    	
    	if(is_null($etiquetas)||$etiquetas== '') return false;
    	if(is_null($rutaId)||$rutaId== '') return false;
    	
    	 
    	if(!is_null($nombre)&&$nombre!= '') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!= '') $parametros['alias'] = $alias;
    	if(!is_null($nombreReal)&&$nombreReal!= '') $parametros['nombre_real'] = $nombreReal;
    	if(!is_null($etiquetas)&&$etiquetas!= '') $parametros['etiquetas'] = $etiquetas;
    	if(!is_null($rutaId)&&$rutaId!= '') $parametros['ruta_id'] = $rutaId;
    	if(!is_null($descripcion)&&$descripcion!= '') $parametros['descripcion'] = $descripcion;
    	 
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	
    	return $this->dao-> crearDocumento($parametros);
    	 
    	
    }
    
    public function actualizarDocumento($id = '',$nombre = '', $alias = '',$nombreReal = '',$descripcion = '', $etiquetas = '',$rutaId = '',  $estadoRegistroId = ''){

    	$parametros = array();
    	
    	if(is_null($id)||$id== '') return false; 
    	$parametros['id'] = $id;
    	
    	 
    	if(!is_null($nombre)&&$nombre!= '') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!= '') $parametros['alias'] = $alias;
    	if(!is_null($nombreReal)&&$nombreReal!= '') $parametros['nombre_real'] = $nombreReal;
    	if(!is_null($etiquetas)&&$etiquetas!= '') $parametros['etiquetas'] = $etiquetas;
    	if(!is_null($rutaId)&&$rutaId!= '') $parametros['ruta_id'] = $rutaId;
    	if(!is_null($descripcion)&&$descripcion!= '') $parametros['descripcion'] = $descripcion;
    	
    	
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	
    	
    	
    	return $this->dao-> actualizarDocumento($parametros);
    	
    }
    
    public function consultarDocumento($id = '',$nombre = '', $alias = '',$nombreReal = '', $etiquetas = '',$rutaId = '',  $estadoRegistroId = '', $fechaRegistro = ''){

    	$parametros = array();
    	 
    	if(!is_null($id)&&$id!= '') $parametros['id'] = $id;

    	if(!is_null($nombre)&&$nombre!= '') $parametros['nombre'] = $nombre;
    	if(!is_null($alias)&&$alias!= '') $parametros['alias'] = $alias;
    	if(!is_null($nombreReal)&&$nombreReal!= '') $parametros['nombre_real'] = $nombreReal;
    	if(!is_null($etiquetas)&&$etiquetas!= '') $parametros['etiquetas'] = $etiquetas;
    	if(!is_null($rutaId)&&$rutaId!= '') $parametros['ruta_id'] = $rutaId;
    	
    	 
    	
    	if(!is_null($estadoRegistroId)&&$estadoRegistroId!= '') $parametros['estado_registro_id'] = $estadoRegistroId;
    	if(!is_null($estadoRegistroId)&&$fechaRegistro!='') $parametros['fecha_registro'] = $fechaRegistro;
    	 
    	
    	return $this->dao-> consultarDocumento($parametros);
    	
    }
    
    public function activarInactivarDocumento($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> activarInactivarDocumento($parametros);
    
    }
    
    public function duplicarDocumento($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> duplicarDocumento($parametros);
    
    }
    
    
    public function eliminarDocumento($id ){
    
    	if(is_null($id)||$id=='') return false;
    
    	$parametros = array();
    
    	$parametros['id'] = $id;
    
    	return $this->dao-> eliminarDocumento($parametros);
    
    }
    
    
    
    
    
}