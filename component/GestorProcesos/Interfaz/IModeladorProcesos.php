<?php
namespace component\GestorProcesos\interfaz;

interface IModelarProceso{
    
	/**
	 *
	 * consulta el flujo asociado a un proceso
	 * @param $idProceso, integer obligatorio
	 * @return array , array de la consulta
	 *
	 */
	public function consultarFlujo($idProceso) ;
	
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
	public function consultarActividad($idActividad,$nombreActividad, $aliasActividad, $idElementoBpmn, $idTipoEjecucion, $estadoRegistroId, $fechaRegistro) ;
	
	
	
	
	
}


?>