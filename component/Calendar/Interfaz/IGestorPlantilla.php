<?php
namespace component\Calendar\interfaz;

interface IGestionarPlantilla{
    /**
     *  Realiza el registo de un nuevo calendarioR
     *  nombre_calendario,
     *  descripcion_calendario,
     *  propietario,
     *  zona_horaria,
     *  estado
     * @param \JsonSerializable $datos contine: nombre_calendario,descripcion_calendario, propietario, zona_horaria, estado
     */
    function crearPlantilla($datos);
	/**
	 * 
	 * @param unknown $secuencia
	 */
    //function consultarSecuenciaPlantilla($secuencia);
    /**
     * 
     * @param \JsonSerializable $datos
     */
    function registrarPlantillaUsuario($datos);
    /**
     * 
     * @param \JsonSerializable $datos
     */
    function actualizarPlantilla($datos);
    /**
     * 
     * @param \JsonSerializable $datos
     */
    //function borrarPlantilla($datos);
    /**
     * 
     * @param unknown $id_calendario
     */
    //function consultarPlantilla($id_calendario);
    /**
     * 
     * @param unknown $id_usuario
     */
    function consultarPlantillaUsuario($id_usuario);
    
    public function consultarPlantilla($id_plantilla);
         

}


?>