<?php


namespace component\GestorDocumentos\Modelo;


include_once ('component/GestorDocumentos/Modelo/Base.class.php');
include_once ('component/GestorDocumentos/Modelo/Documento.class.php');
include_once ('component/GestorDocumentos/Modelo/DocumentoTipoMIME.class.php');

use component\GestorDocumentos\Modelo\Base as Base;
use component\GestorDocumentos\Modelo\Documento as Documento;
use component\GestorDocumentos\Modelo\DocumentoTipoMIME as DocumentoTipoMIME;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}


class Modelo{
	
	CONST conexion = 'academica';
	
	private $nameBase  ;
	
	private $objeto =  null;
	private $nombre;
	private $consultas;
	


	public function __construct($nombre = 'Base'){
		
		$this->nameBase = __NAMESPACE__.'\\';
		
		
		if(!$this->seleccionarClase($nombre)) return false;
		 
	}
	
	public function getConsultas(){
		return $this->consultas;
	}
	
	public function setConexion(){
		
	}
	
	private function seleccionarClase($nombre){
		if($nombre =='') return false;
		
		$nombre = ucfirst(strtolower($nombre));
		$this->nombre =  $nombre;
		$class = new \ReflectionClass($this->nameBase.$nombre);
		$this->objeto = $class->newInstanceArgs(array(self::conexion));
		$this->objeto->setDataAccessObject(self::conexion) ;
		
		if(is_object($this->objeto)) return true;
		return false;
		
	}	
	
	
	public function __call($method_name, $arguments){
		
		
		if(!isset($this->objeto)||is_null($this->objeto)) return false;
		
		$this->objeto->setDataAccessObject(self::conexion) ;
		$ejecucion = call_user_func_array(array($this->objeto , $method_name), $arguments);
		$this->consulta[] = $this->objeto->getQuery();
		//$this->objeto->unsetDao();
		//unset($this->objeto);
		return $ejecucion;
		
	}


}
