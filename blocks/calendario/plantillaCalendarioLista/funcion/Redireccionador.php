<?

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
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mostrarCalendario";
				$variable .= "&id_usuario=" . $valor;
				
				break;
			
			case "actualizacionPlantillaOK" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mostrarPlatillaCalendario";
				$variable .= "&id_usuario=" . $valor;
				
				break;
			
			case "creacionPlantillaOK" :
				
				$variable = "pagina=plantillaCalendarioLista";
				$variable .= "&opcion=mostrarPlatillaCalendario";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				
				break;
			
			case "creacionEventoPlantillaOK" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=configurarPlantilla";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&id_plantilla=" . $valor ['id_plantilla'];
				break;
			
			case "borradoEventoPlantillaOK" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=configurarPlantilla";
				$variable .= "&id_usuario=" . $valor ['id_usuario'];
				$variable .= "&id_plantilla=" . $valor ['id_plantilla'];
				break;
			
			case "botonCancelar" :
				
				if ($_REQUEST ['pagina'] == 'plantilla') {
					$variable = "pagina=plantilla";
					$variable .= "&opcion=configurarPlantilla";
					$variable .= "&id_plantilla=" . $valor['id_plantilla'];
				} else {
					$variable = "pagina=" . $miPaginaActual;
					$variable .= "&opcion=mostrarPlatillaCalendario";
				}
				$variable .= "&id_usuario=" . $valor['id_usuario'];
				
				break;
			
			case "consultaPlantillaOK" :
				
				$variable = "pagina=" . $miPaginaActual;
				$variable .= "&opcion=mostrarPlatillaCalendario";
				$variable .= "&id_usuario=" . $valor;
				
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