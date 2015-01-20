<?php

namespace calendario\calendarioLista;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			case "consultaOK" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mostrarCalendario";
				$variable .= "&id_usuario=" . $valor;
				
				break;
			
			case "actualizacionEventoOK" :
				
				$variable = "pagina=calendario";
				$variable .= "&opcion=consultarCalendario";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&id_calendario=" . $valor ['id_calendario'];
				$variable .= "&permiso=" . $valor ['permiso'];
				
				break;
			
			case "actualizacionCalendarioOK" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=consultarCalendario";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&id_calendario=" . $valor ['id_calendario'];
				$variable .= "&permiso=" . $valor ['permiso'];
				
				break;
			
			case "creacionCalendarioOK" :
				$variable = "pagina=" . $miPaginaActual;			
				$variable .= "&opcion=mostrarCalendario";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&id_calendario=" . $valor ['id_calendario'];
				$variable .= "&permiso=" . $valor ['permiso'];
				
				
				break;
			
			case "creacionEventoOK" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=consultarCalendario";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&id_calendario=" . $valor ['id_calendario'];
				$variable .= "&permiso=" . $valor ['permiso'];
				
				break;
			
			case "botonCancelar" :
				
				
				//redirecciona dependiendo de la página donde se encuentre
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&permiso=0";
				if ($miPaginaActual == 'calendarioLista') {
					$variable .= "&opcion=mostrarCalendario";
				}
				if ($miPaginaActual == 'calendario') {
					if (isset ( $valor ['id_calendario'] )) {
						$variable .= "&opcion=consultarCalendario";
						$variable .= "&id_calendario=" . $valor ['id_calendario'];
						$variable .= "&permiso=" . $valor ['permiso'];
						
					}
				}
				
				break;
			
			case "noInserto" :
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&solicitud=mensaje";
				$variable .= "&mensaje=error";
				if ($datos != "") {
					$variable .= "&docente=" . $datos;
				}
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