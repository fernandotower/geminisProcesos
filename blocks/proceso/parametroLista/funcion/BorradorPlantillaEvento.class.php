<?php

namespace calendar;

use component\Calendar\Componente;
use calendario\calendarioLista\Redireccionador;

include_once ('Redireccionador.php');
include_once ('component/Calendar/Componente.php');
class RegistradorEvento {
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
		session_start ();
		// La veariable $_SESSION['verifica'] viene del formulario
		// se evita reenviar el formulario al enviar la página o ejecutar la instrucciones
		// sin pasar por el formulario
		if (isset ( $_SESSION ['verificaReevio'] ) && $_SESSION ['verificaReevio'] == $_REQUEST ['campoSeguro']) {
			unset ( $_SESSION ['verificaReevio'] );
			
			$datos ['id_plantilla'] = $_REQUEST ['id_plantilla'];
			$datos ['id_plantillaevento'] = $_REQUEST ['id_plantillaevento'];
			$datos ['id_plantillaevento_orden'] = $_REQUEST ['id_plantillaevento_orden'];
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			
			$datosJson = json_encode ( $datos );
			
			$miComponente = new Componente ();
			
			$resultadoPlantillaEvento = $miComponente->borrarEventoPlantilla ( $datosJson );
			
			if ($resultadoPlantillaEvento == TRUE) {
				$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'eventoPlantillaBorrado' );
			} else {
				$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorEventoPlantillaBorrado' );
			}
			
			Redireccionador::redireccionar ( "borradoEventoPlantillaOK", $datos );
		} else {
			$datos ['id_plantilla'] = $_REQUEST ['id_plantilla'];			
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			Redireccionador::redireccionar ( "borradoEventoPlantillaOK", $datos );
		}
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
		var_dump ( $calendario );
	}
}

$miRegistrador = new RegistradorEvento ( $this->lenguaje, $this->sql );

$resultado = $miRegistrador->procesarFormulario ();



