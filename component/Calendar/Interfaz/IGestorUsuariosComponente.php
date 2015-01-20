<?php
namespace component\Calendar\interfaz;

interface IGestionarUsuariosComponente{
    /**
     * Consulta los permisos de usuario sobre un objeto específico (Calendario, evento, plantilla, evento de plantilla)
     *   
     * @param \JsonSerializable $datos contine: id_calendario_permiso, tipo_objeto, id_objeto, id_usuario, permiso
     */
    function consultarRelacion($datos);
	/**
	 * 
	 * @param unknown $secuencia
	 */
    //function consultarRelacion($secuencia);
    /**
     * 
     * @param \JsonSerializable $datos
     */
    //function actualizarRelacion($datos);
    /**
     * 
     * @param \JsonSerializable $datos
     */
    //function CambiarEstadoRelacion($datos);
    
}


?>