<?php

namespace component\GestorProcesos\interfaz;

interface ICoordinadorFlujo {
	
	/**
	 *
	 * Ejecuta una actividad, true: se ejcuto con exito, falso: se ejecuto con errores o no se pudo ejecutar
	 * @param $idActividad
	 * @return bool
	 *
	 */
	public function ejecutarActividad($idActividad);
	
	/**
	 *
	 * Crea un trabajo ,
	 * envia se�al de ejecucion del paso de inicio y
	 * y retorna el id del trabajo
	 * @param $idProceso , integer id del proceso del cual se quiere ejecutar el flujo
	 * @param $ejecucionAutomatica , bool true:comienza a ejecutar actividades hasta que se encuentre con un paso manual , false:solo ejecuta la actividad de inicio.
	 * @return integer , $idTrabajo
	 *
	 */
	public function ejecutarProceso($idProceso,$ejecucionAutomatica);
}


?>
