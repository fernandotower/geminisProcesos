<?php
namespace component\GestorProcesos\interfaz;

interface IRegistrar{
    /**
     *  Realiza el registo de un nuevo calendarioR
     *  nombre_calendario,
     *  descripcion_calendario,
     *  propietario,
     *  zona_horaria,
     *  estado
     * @param \JsonSerializable $datos contine: nombre_calendario,descripcion_calendario, propietario, zona_horaria, estado
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
	public function actualizarEstadoPaso($idTrabajo, $idActividad ,$idEstadoPaso);
	
	/**
	 *
	 * Crea un trabajo
	 * @param $idProceso
	 * @return integer , $idTrabajo
	 *
	 */
	public function crearTrabajo($idProceso);
	
	
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
	public function consultarPasos($idTrabajo, $idActividad, $idEstadoPaso, $idEstadoRegistro, $fechaRegistro);
	
}


?>