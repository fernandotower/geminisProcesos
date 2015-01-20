<?

namespace calendario\permisoCalendario;

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
    var $miFormulario;
    
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
        $this->miFormulario = $formulario;
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
    
    	$this->ruta = $this->miConfigurador->getVariableConfiguracion ( "rutaBloque" );    	
        	
    	$resultado = $this->miConfigurador->getVariableConfiguracion ( 'errorFormulario' );
    
    	//sin este if no funciona la redireccion con Redireccionador,
    	//carga el formulario antes de iniciar la declaración de la página
    	if (! isset ( $_REQUEST ['opcion'] )) {
    		$_REQUEST ['opcion'] = '';	
    	}
    	    
    	switch ($_REQUEST ['opcion']) {
    		case 'crearPermisos' :
    			include_once ($this->ruta . "/formulario/crearPermisos.php");
    			break;
    		
    	}
    }


}
?>
