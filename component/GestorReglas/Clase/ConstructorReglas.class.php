<?php

namespace component\GestorReglas\Clase;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}


include_once ("core/builder/Mensaje.class.php");
use \Mensaje as Mensaje;
include_once ("core/connection/DAL.class.php");
use \DAL as DAL;

use component\GestorUsuarios\Componente as GestorUsuariosComponentes;

class ConstructorReglas{
    
	const ID_OBJETO = 4;

	private $parametros ;
    private $registrador;
    private $usuario;
    public $mensaje;
    private $verificadorAcceso ;
    
    function __construct(){
    	$this->registrador = new DAL();
    	$this->mensaje =  Mensaje::singleton();
    	
    	//configurar usuario
    	$this->usuario = $_REQUEST['usuario'];
    	$this->registrador->setUsuario($this->usuario);
    	$this->verificadorAcceso = new  GestorUsuariosComponentes();
    	
    	
    }
    
    
    
    public function crearRegla($nombre ='',$descripcion='',$proceso='',$tipo = '',$valor='',$estado=''){

    	
    	if(!$this->verificadorAcceso->validarAcceso(0,1,self::ID_OBJETO)) return false;
    	
    	if($nombre===''||$proceso===''||$valor===''){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    	
    	if($estado=='') $estado = 3;
    	else $estado = 3;
    	if($tipo=='') $tipo = 1;
    	
    	$parametros['nombre'] = $nombre;
    	if($descripcion!='')	$parametros['descripcion'] = $descripcion;
    	$parametros['proceso'] = $proceso;
    	$parametros['tipo'] = 1;
    	$parametros['valor'] = $valor;
    	$parametros['estado'] = 3;
    	
    	 
    	$ejecutar = $this->registrador->crearRegla($parametros);
    	
    	if(!$ejecutar){
    	
    		
    		return false;
    	}
    	 
    	return $ejecutar;
    	
    }
    
    public function actualizarRegla($id = '',$nombre ='',$descripcion='',$proceso='',$tipo = '',$valor='',$estado='',$justificacion=''){
    	 
    	if(!$this->verificadorAcceso->validarAcceso($id,3,self::ID_OBJETO)) return false;
    	
    	if($id==''||is_null($id)||$justificacion == ''||is_null($justificacion)){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    	 
    	if($nombre!='')	$parametros['nombre'] = $nombre; 
    	if($descripcion!='')	$parametros['descripcion'] = $descripcion;
    	if($proceso!='')	$parametros['proceso'] = $proceso;
    	$parametros['tipo'] = 1;
    	if($valor!='')	$parametros['valor'] = $valor;
    	if($estado!='')	$parametros['estado'] = $estado;
    	$parametros['id'] = $id;
    	$parametros['justificacion'] = $justificacion;
    	 
    	if(!$this->registrador->actualizarRegla($parametros)){
    
    		
    		return false;
    	}
    	 
    	return true;
    	 
    }
    
    public function consultarRegla($id = '',$nombre ='',$proceso='',$tipo = '',$estado='', $fecha=''){
    
    	
    	if(!$this->verificadorAcceso->validarAcceso($id,2,self::ID_OBJETO)) return false;
    	
    	$parametros =  array();
    	if($nombre!='')	$parametros['nombre'] = $nombre; 
    	if($proceso!='')	$parametros['proceso'] = $proceso;
    	if($tipo!='')	$parametros['tipo'] = $tipo;
    	if($estado!='')	$parametros['estado'] = $estado;
    	if($id!='') $parametros['id'] = $id;
    	
    	if($fecha!='') $parametros['fecha_registro'] = $fecha;
    	
        
    	$consulta = $this->registrador->consultarRegla($parametros);
    	
    	if(!$consulta){
    
    		
    		return false;
    	}
    
    	return $this->verificadorAcceso->filtrarPermitidos($consulta);
    
    }
    
    public function activarInactivarRegla($id = ''){
    
    	if(!$this->verificadorAcceso->validarAcceso($id,3,self::ID_OBJETO)) return false;
    	
    	if($id==''||is_null($id)){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    
    	$parametros =  array();
    	$parametros['id'] = $id;
    
    	
    	 
    	if(!$this->registrador->activarInactivarRegla($parametros)){
    
    		
    		return false;
    	}
    
    	return true;
    
    }
    
    public function duplicarRegla($id = ''){
    
    	if(!$this->verificadorAcceso->validarAcceso($id,1,self::ID_OBJETO)) return false;
    	
    	if($id==''||is_null($id)){
    		$this->mensaje->addMensaje("101","errorEntradaParametrosGeneral",'error');
    		return false;
    	}
    
    	$parametros =  array();
    	$parametros['id'] = $id;
    
    	 
    
    	$ejecutar = $this->registrador->duplicarRegla($parametros);
     	if(!$ejecutar){
    		
    		
    		return false;
    	}
    	
    	return $ejecutar;
    
    }
    


}

?>
