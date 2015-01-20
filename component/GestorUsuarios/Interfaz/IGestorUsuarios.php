<?php
namespace component\GestorUsuarios\interfaz;

interface IGestionarUsuarios{
    /**
     *  Realiza el registo de un nuevo calendarioR
     *  nombre_calendario,
     *  descripcion_calendario,
     *  propietario,
     *  zona_horaria,
     *  estado
     * @param \JsonSerializable $datos contine: nombre_calendario,descripcion_calendario, propietario, zona_horaria, estado
     */
    function consultarUsuarios($datos);
	
}


?>