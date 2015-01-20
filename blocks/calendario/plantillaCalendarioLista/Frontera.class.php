<?

namespace calendario\plantillaCalendarioLista;

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
			case '5' :
				include_once ($this->ruta . "/formulario/consultarPlantillaCalendario.php");
				break;
			case 'mostrarPlatillaCalendario' :
				include_once ($this->ruta . "/formulario/mostrarPlantillas.php");
				break;
			
			case 'editarPlantilla' :
				include_once ($this->ruta . "/formulario/editarPlantilla.php");
				break;
			/**
			 * case 'editarEvento' :
			 * include_once ($this->ruta .
			 *
			 *
			 *
			 *
			 * "/formulario/editarEvento.php");
			 * break;
			 */
			case 'crearPlantilla' :
				include_once ($this->ruta . "/formulario/crearPlantilla.php");
				break;
			
			case 'configurarPlantilla' :
				include_once ($this->ruta . "/formulario/configurarPlantilla.php");
				break;
			
			case 'duplicarPlantilla' :
				include_once ($this->ruta . "/formulario/duplicarPlantilla.php");
				break;
			
			case 'crearPlantillaEvento' :
				include_once ($this->ruta . "/formulario/crearPlantillaEvento.php");
				break;
			
			case 'editarPlantillaEvento' :
				include_once ($this->ruta . "/formulario/editarPlantillaEvento.php");
				break;
			
			case 'borrarPlantillaEvento' :
				include_once ($this->ruta . "/formulario/borrarPlantillaEvento.php");
				break;
			
			case 'editarPermiso' :				
				include_once ($this->ruta . "/formulario/editarPermiso.php");
				break;
		/**
		 * case 'borrarEvento' :
		 * include_once ($this->ruta .
		 *
		 *
		 *
		 *
		 * "/formulario/borrarEvento.php");
		 * break;
		 */
		}
	}
}
?>
