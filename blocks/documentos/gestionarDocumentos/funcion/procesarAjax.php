<?php
// namespace calendario\permisoCalendario;
namespace calendario\permisoCalendario;

use calendario\calendarioLista;
use component\Calendar\Componente;

include_once ('component/Calendar/Componente.php');
$miComponente = new Componente ();

// Decodificar las variables del campo tipo hiden formSaraData
$saradata = $this->miConfigurador->fabricaConexiones->crypto->decodificar_url ( $_REQUEST ['valor'] );

// Decodificar el campo de usuario del checkbox
$usuarioCampoSeguro = $this->miConfigurador->fabricaConexiones->crypto->decodificar ( $_REQUEST ['id_usuario'] );
$id_usuario = substr ( $usuarioCampoSeguro, 0, strlen ( $usuarioCampoSeguro ) - strlen ( $_REQUEST ['campoSeguro'] ) );

$datos ['tipo_objeto'] = $_REQUEST ['tipo_objeto'];
$datos ['id_objeto'] = $_REQUEST ['id_calendario'];
$datos ['id_usuario'] = $id_usuario;
$datos ['permiso'] = $_REQUEST ['permiso'];
$datosJson = json_encode ( $datos );

if (isset ( $_REQUEST ['chequeado'] )) {
	
	$miComponente->registrarPermisoCalendario ( $datosJson );
} else {
	
	$miComponente->eliminarPermisoCalendario ( $datosJson );
}

exit ();
class procesarAjax {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje) {
		include_once ("core/builder/FormularioHtml.class.php");
		
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		
		$this->miFormulario = new \FormularioHtml ();
		
		$this->lenguaje = $lenguaje;
		
		switch ($_REQUEST ['opcion']) {
			
			case 'registrarPermiso' :
				
				echo 'una opcion';
				exit ();
				break;
			
			case '2' :
				include ($this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' ) . 'formulario/actualizarCalendario.php');
				break;
			
			case '3' :
				include ($this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' ) . 'formulario/borrarCalendario.php');
				break;
			
			case '4' :
				include ($this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' ) . 'formulario/consultarCalendario.php');
				break;
		}
	}
	function registrarPermiso() {
		echo 'esta es la función en procesar ajax';
		exit ();
	}
}

$miProcesarAjax = new procesarAjax ( $this->lenguaje );

?>