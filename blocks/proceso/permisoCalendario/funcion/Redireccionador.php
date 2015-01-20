<?php

namespace calendario\permisoCalendario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
						
			case "creacionPermisosOK" :
				
				$variable = "pagina=permisoCalendario";
				$variable .= "&opcion=crearPermisos";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&paso=paso";									
				
				break;			
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				
				break;
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$enlace = $miConfigurador->getVariableConfiguracion ( "enlace" );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		
		$_REQUEST [$enlace] = $variable;
		$_REQUEST ["recargar"] = true;
		
		return true;
	}
}
?>