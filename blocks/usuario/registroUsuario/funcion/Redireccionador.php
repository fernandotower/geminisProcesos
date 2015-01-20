<?

namespace usuario\registroUsuario;

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
				
				$variable = "pagina=calendarioLista";
				$variable .= "&opcion=mostrarCalendario";
				$variable .= "&usuario=" . $valor;

				
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