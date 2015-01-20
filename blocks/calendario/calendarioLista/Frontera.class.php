<?

namespace calendario\calendarioLista;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
class Frontera {
	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $formulario;
	var 

	$miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->formulario = $formulario;
	}
	function frontera() {
		$this->html ();
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	function html() {
		include_once ("core/builder/FormularioHtml.class.php");
		
		$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );
		$this->miFormulario = new \FormularioHtml ();
		
		$miBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );
		$resultado = $this->miConfigurador->getVariableConfiguracion ( 'errorFormulario' );
		
		if (! isset ( $_REQUEST ['opcion'] )) {
			$_REQUEST ['opcion'] = '5';
		}
		switch ($_REQUEST ['opcion']) {
			case 'consultarCalendario' :
				include_once ($this->ruta . "/formulario/consultarCalendario.php");
				break;
			case 'mostrarCalendario' :
				include_once ($this->ruta . "/formulario/mostrarCalendarios.php");
				break;
			
			case 'editarCalendario' :
				include_once ($this->ruta . "/formulario/editarCalendario.php");
				break;
			
			case 'editarEvento' :
				include_once ($this->ruta . "/formulario/editarEvento.php");
				break;
			
			case 'crearCalendario' :
				include_once ($this->ruta . "/formulario/crearCalendario.php");
				break;
			
			case 'crearCalendarioConPlantilla' :
				include_once ($this->ruta . "/formulario/crearCalendarioConPlantilla.php");
				break;
			
			case 'duplicarCalendario' :
				include_once ($this->ruta . "/formulario/duplicarCalendario.php");
				break;
			
			case 'crearEvento' :
				include_once ($this->ruta . "/formulario/crearEvento.php");
				break;
			
			case 'borrarEvento' :
				include_once ($this->ruta . "/formulario/borrarEvento.php");
				break;
			
			case 'editarPermiso' :
				include_once ($this->ruta . "/formulario/editarPermiso.php");
				break;
		}
	}
}
?>
