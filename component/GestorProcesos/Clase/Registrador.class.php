<?php

namespace component\GestorProcesos\Clase;

use component\GestorUsuarios\interfaz\IGestionarUsuarios;
use component\GestorUsuarios\Sql;

include_once ('component/GestorUsuarios/Interfaz/IGestorUsuarios.php');
include_once ("core/manager/Configurador.class.php");
include_once ("component/GestorUsuarios/Sql.class.php");
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
