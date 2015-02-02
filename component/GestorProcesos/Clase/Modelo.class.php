<?php


namespace component\GestorProcesos\Clase;


include_once ('component/GestorProcesos/Modelo/Base.class.php');
include_once ('component/GestorProcesos/Modelo/Actividad.class.php');
include_once ('component/GestorProcesos/Modelo/Flujo.class.php');
include_once ('component/GestorProcesos/Modelo/Proceso.class.php');
include_once ('component/GestorProcesos/Modelo/Trabajo.class.php');
include_once ('component/GestorProcesos/Modelo/PasosTrabajo.class.php');

use component\GestorProcesos\Modelo\Base as Base;
use component\GestorProcesos\Modelo\Actividad as Actividad;
use component\GestorProcesos\Modelo\Flujo as Flujo;
use component\GestorProcesos\Modelo\Proceso as Proceso;
use component\GestorProcesos\Modelo\Trabajo as Trabajo;
use component\GestorProcesos\Modelo\PasosTrabajo as PasosTrabajo;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}


class Modelo{
	
	CONST conexion = 'academica';
	
	CONST nameBase = 'component\\GestorProcesos\\Modelo\\';
	
	private $objeto =  null;
	private $nombre;
	private $consultas;
	


	public function __construct($nombre = 'Base'){
		
		
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
		$class = new \ReflectionClass(self::nameBase.$nombre);
		$this->objeto = $class->newInstanceArgs(array(self::conexion));
		$this->objeto->setDataAccessObject(self::conexion) ;
		
		if(is_object($this->objeto)) return true;
		return false;
		
	}	
	
	
	public function __call($method_name, $arguments){
		
		
		if(!isset($this->objeto)||is_null($this->objeto)) return false;
		
		
		$ejecucion = call_user_func_array(array($this->objeto , $method_name), $arguments);
		$this->consulta[] = $this->objeto->getQuery();
		//$this->objeto->unsetDao();
		//unset($this->objeto);
		return $ejecucion;
		
	}


}
