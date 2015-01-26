<?php

namespace component\GestorProcesos\Clase;

<<<<<<< HEAD
use component\GestorUsuarios\interfaz\IGestionarUsuarios;
use component\GestorUsuarios\Sql;
use component\GestorProcesos\interfaz\IModelarProceso;
=======
>>>>>>> branch 'master' of https://github.com/fernandotower/geminisProcesos.git


include_once ('component/GestorProcesos/Interfaz/IModeladorProcesos.php');
use component\GestorProcesos\Interfaz\IModelarProceso  as IModelarProceso;

class ModeladorProceso implements IModelarProceso {
	var $miSql;
	
	/**
	 * (non-PHPdoc)
	 *
	 * @see omponent\GestorProcesos\interfaz\IGestionarCalendario::crearCalendario()
	 */

    
    /**
	 *
	 * consulta el flujo asociado a un proceso
	 * @param $idProceso, integer obligatorio
	 * @return array , array de la consulta 
	 *
	 */
	public function consultarFlujo($idProceso) {
		return array();
	}
	
	/**
	 *
	 * Crea un trabajo
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
	public function consultarActividad($idActividad,$nombreActividad, $aliasActividad, $idElementoBpmn, $idTipoEjecucion, $estadoRegistroId, $fechaRegistro) {
	    	return array();
	}
}
