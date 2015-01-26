<?php
namespace component\GestorProcesos\interfaz;

interface IModelarProceso{
    
	public function consultarFlujo($idProceso) ;
	
	public function consultarActividad($idActividad,$nombreActividad, $aliasActividad, $idElementoBpmn, $idTipoEjecucion, $estadoRegistroId, $fechaRegistro) ;
	
	
	
	
	
}


?>