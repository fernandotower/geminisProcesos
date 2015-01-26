<?php

namespace component\GestorProcesos\Clase;

<<<<<<< HEAD
use component\GestorUsuarios\interfaz\IGestionarUsuarios;
use component\GestorUsuarios\Sql;
use component\GestorProcesos\interfaz\IRegistrar;
=======
>>>>>>> branch 'master' of https://github.com/fernandotower/geminisProcesos.git

include_once ('component/GestorProcesos/Interfaz/IRegistrador.php');
use  component\GestorProcesos\Interfaz\IRegistrar as IRegistrar;


class Registrador implements IRegistrar {
	var $miSql;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see \component\Calendar\interfaz\IGestionarCalendario::crearCalendario()
	 */

	
	/**
	 *
	 * Actualiza el estado de un paso
	 * @param $idTrabajo , integer obligatorio
	 * @param $idActividad , integer obligatorio
	 * @param $idEstadoPaso , integer obligatorio
	 * @return bool
	 *
	 */
	public function actualizarEstadoPaso($idTrabajo, $idActividad ,$idEstadoPaso) {
		return true;
	}
	
	/**
	 *
	 * Crea un trabajo
	 * @param $idProceso
	 * @return integer , $idTrabajo
	 *
	 */
	public function crearTrabajo($idProceso) {
		return 1;
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
	public function consultarPasos($idTrabajo, $idActividad, $idEstadoPaso, $idEstadoRegistro, $fechaRegistro) {
		$idEstadoRegistro = 1;
		return array();
	
	}

}
