<?php

namespace component\GestorProcesos\Clase;

use component\GestorProcesos\interfaz\IRegistrar;

include_once ('component/GestorProcesos/Interfaz/IRegistrador.php');




include_once ('core/connection/DAL.class.php');

use component\GestorProcesos\Modelo\Modelo as Modelo;

class Registrador implements IRegistrar {
	var $miSql;
	
	
	

	
	/**
	 *
	 * Actualiza el estado de un paso
	 * @param $idTrabajo , integer obligatorio
	 * @param $idActividad , integer obligatorio
	 * @param $idEstadoPaso , integer obligatorio
	 * @return bool
	 *
	 */
	public function actualizarEstadoPaso($idTrabajo = '', $idActividad = '' ,$idEstadoPaso = '') {
		$pasos =  new Modelo('PasosTrabajo');
		return $pasos->actualizarEstadoPaso($idTrabajo, $idActividad ,$idEstadoPaso);
	}
	
	public function crearPaso($idTrabajo = '', $idActividad = '' ,$idEstadoPaso = '') {
		$pasos =  new Modelo('PasosTrabajo');
		return $pasos->crearPaso($idTrabajo, $idActividad ,$idEstadoPaso);
	}
	
	/**
	 *
	 * Crea un trabajo
	 * @param $idProceso
	 * @return integer , $idTrabajo
	 *
	 */
	public function crearTrabajo($idProceso = '') {
		$trabajo =  new Modelo('Trabajo');
		return $trabajo->crearTrabajo($idProceso);
	}
	
	/**
	 *
	 * Consulta pasos , es decir lo que se ha ejecutado y que no en el trabajo
	 * @param $idTrabajo , integer obligatorio
	 * @param $idActividad , integer opcional
	 * @param $idEstadoPaso , integer opcional
	 * @param $idEstadoRegistro , integer opcional
	 * @param $fechaRegistro , string opcional
	 * @return array , array de la consulta
	 *
	 */
	public function consultarPasos($idTrabajo = '', $idActividad = '', $idEstadoPaso = '', $idEstadoRegistro= '', $fechaRegistro= '') {
		
		$pasos =  new Modelo('PasosTrabajo');
		return $pasos->consultarPasosTrabajo($idTrabajo, $idActividad, $idEstadoPaso, $idEstadoRegistro, $fechaRegistro);
	
	}
	
	public function getElementoBpmn($idElementoBpmn,$dado,$buscar){
		$dal =  new Modelo();
	
		return $dal->getElementoBpmn($idElementoBpmn,$dado,$buscar); 
		;
	}
	
	public function finalizarPasosTrabajo($idTrabajo = ''){
		$pasos =  new Modelo('PasosTrabajo');
		return $pasos->finalizarPasosTrabajo($idTrabajo);
	}
	
	public function borrarPasosTrabajo($idTrabajo = ''){
		$pasos =  new Modelo('PasosTrabajo');
		return $pasos->borrarPasosTrabajo($idTrabajo);
	}

}
