<?php
namespace component\Calendar\interfaz;

interface IGestionarCalendario{
    /**
     *  Realiza el registo de un nuevo calendarioR
     *  nombre_calendario,
     *  descripcion_calendario,
     *  propietario,
     *  zona_horaria,
     *  estado
     * @param \JsonSerializable $datos contine: nombre_calendario,descripcion_calendario, propietario, zona_horaria, estado
     */
    function crearCalendario($datos);
	/**
	 * 
	 * @param unknown $secuencia
	 */
    function consultarSecuencia($secuencia);
    /**
     * 
     * @param \JsonSerializable $datos
     */
    function registrarPermisoCalendario($datos);
    /**
     * 
     * @param unknown $datos
     */
    function eliminarPermisoCalendario($datos);
    
    /**
     * 
     * @param \JsonSerializable $datos
     */
    function actualizarCalendario($datos);
    /**
     * 
     * @param \JsonSerializable $datos
     */
    function borrarCalendario($datos);
    /**
     * 
     * @param unknown $id_calendario
     */
    function consultarCalendario($id_calendario);
    /**
     * 
     * @param unknown $id_usuario
     */
    function consultarCalendariosUsuario($id_usuario);

}


?>