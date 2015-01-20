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
    function consultarProcesos($datos);
	
}


?>