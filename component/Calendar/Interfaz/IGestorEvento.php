<?php
namespace component\Calendar\interfaz;

interface IGestorEvento{	
    
    function crearEvento($datos);
    
    function actualizarEvento($datos);
    
    function borrarEvento($datos);
    
    function consultarEvento($id_calendario);
}


?>