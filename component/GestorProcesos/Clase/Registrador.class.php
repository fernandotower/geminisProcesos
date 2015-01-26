<?php

namespace component\GestorProcesos\Clase;


include_once ('component/GestorProcesos/Interfaz/IRegistrador.php');
use  component\GestorProcesos\Interfaz\IRegistrar as IRegistrar;


include_once ('component/GestorProcesos/Clase/PasosTrabajo.class.php');
include_once ('component/GestorProcesos/Clase/Trabajo.class.php');

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
		$pasos =  new PasosTrabajo();
		return $pasos->actualizarEstadoPaso($idTrabajo, $idActividad ,$idEstadoPaso);
	}
	
	/**
	 *
	 * Crea un trabajo
	 * @param $idProceso
	 * @return integer , $idTrabajo
	 *
	 */
	public function crearTrabajo($idProceso = '') {
		$trabajo =  new Trabajo();
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
		
		$pasos =  new PasosTrabajo();
		return $pasos->consultarPasosTrabajo($idTrabajo, $idActividad, $idEstadoPaso, $idEstadoRegistro, $fechaRegistro);
	
	}

}
