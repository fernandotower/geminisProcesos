<?php
namespace calendar;
use component\Calendar\Componente;
use calendario\calendarioLista\Redireccionador;

include_once ('Redireccionador.php');
include_once ('component/Calendar/Componente.php');
class RegistradorCalendario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
		
		if (isset ( $_REQUEST ['id_calendario'] )) {
			$datos ['id_calendario'] = $_REQUEST ['id_calendario'];
			$datos ['permiso'] = $_REQUEST ['permiso'];
		}		
		
		$this->resetForm();//borra variables del formulario
		
		Redireccionador::redireccionar ( "botonCancelar", $datos );
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
	function mostarFormularioCalendario($calendario) {
		$miBloque = $this->miConfigurador->getVariableConfiguracion ( 'esteBloque' );
		$resultado = $this->miConfigurador->getVariableConfiguracion ( 'errorFormulario' );
		include ($this->miConfigurador->getVariableConfiguracion ( 'rutaBloque' ) . 'formulario/consultorDatosCalendario.php');
	/**
	 * echo $calendario['id_calendario']."-";
	 * echo $calendario['nombre_calendario']."-";
	 * echo $calendario['descripcion_calendario']."-";
	 * echo $calendario['estado'];
	 * echo "<br><br>";
	 */
	}
	function mostrarDatosCalendario($calendario) {
		
	}
}

$miRegistrador = new RegistradorCalendario ( $this->lenguaje, $this->sql );

$resultado = $miRegistrador->procesarFormulario ();



