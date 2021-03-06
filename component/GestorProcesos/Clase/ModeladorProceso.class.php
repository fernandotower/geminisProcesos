<?php

namespace component\GestorProcesos\Clase;


use component\GestorProcesos\interfaz\IModelarProceso;


include_once ('component/GestorProcesos/Interfaz/IModeladorProcesos.php');



use component\GestorProcesos\Modelo\Modelo as Modelo;

class ModeladorProceso implements IModelarProceso {
	
	var $DAL ;
	
	public function __construct(){
		
	}
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see omponent\GestorProcesos\interfaz\IGestionarCalendario::crearCalendario()
	 */

	/*public function __call($metodo, $argumentos){
		var_dump($_REQUEST);
		return $metodo;
		return array($metodo, $argumentos);
		
	}*/
    
    /**
	 *
	 * consulta el flujo asociado a un proceso
	 * @param $idProceso, integer obligatorio
	 * @return array , array de la consulta 
	 *
	 */
	public function consultarFlujo($idProceso) {
		
		if(is_null($idProceso)||$idProceso=='') return false;
		
		$objFlujo =  new Modelo('Flujo');
		
		return $objFlujo->consultarFlujo('',$idProceso);
		
	}
	
	/**
	 *
	 * 
	 * @param $idActividad , integer obligatorio
	 * @param $nombreActividad , string opcional
	 * @param $aliasActividad , string opcional
	 * @param $idElementoBpmn , integer opcional
	 * @param $idTipoEjecucion , integer opcional
	 * @param $estadoRegistroId , integer opcional
	 * @param $fechaRegistro , string opcional
	 * @return array , consulta array
	 *
	 */
	public function consultarActividad($idActividad = '',$nombreActividad = '', $aliasActividad = '', $idElementoBpmn = '', $idTipoEjecucion = '', $estadoRegistroId = '', $fechaRegistro= '') {
		$obj =   new Modelo('Actividad');
		return $obj->consultarActividad($idActividad,$nombreActividad, $aliasActividad, $idElementoBpmn, $idTipoEjecucion, $estadoRegistroId, $fechaRegistro);
	}
}
