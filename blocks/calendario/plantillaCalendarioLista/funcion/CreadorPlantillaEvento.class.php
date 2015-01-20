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
			$datos ['nombre_plantillaevento'] = $_REQUEST ['nombre_plantillaevento'];
			$datos ['descripcion_plantillaevento'] = $_REQUEST ['descripcion_plantillaevento'];
			$datos ['tipo'] = 1; // No se requere para este desarrollo
			$datos ['estado'] = 1; // $_REQUEST['estado']; por defecto se crea activo
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			
			// registra en el la tabla plantillaevento los datos del evento
			
			$datosJson = json_encode ( $datos );
			
			$miComponente = new Componente ();
			
			$resultadoPlantillaEvento = $miComponente->crearEventoPlantilla ( $datosJson );
			
			if ($resultadoPlantillaEvento == TRUE && isset ( $_REQUEST ['evento_precedente'] )) {
				
				// Registra la relación de los eventos en la tabla plantillaevento_orden
				
				// Obtener el id_plantillaevento de la secuencia
				$secuencia = 'plantillaevento_id_plantillaevento_seq';
				$id_evento2 = $miComponente->consultarSecuencia ( $secuencia );
				
				$datos ['id_evento1'] = $_REQUEST ['evento_precedente'];
				$datos ['id_evento2'] = $id_evento2;
				$intervaloTiempo = $this->armarIntervaloTiempo ();
				
				$datos ['intervalo'] = $intervaloTiempo;
				
				$datosRelacionJson = json_encode ( $datos );
				
				$resultadoRelacion = $miComponente->crearRelacionEventos ( $datosRelacionJson );
				
				if ($resultadoRelacion == TRUE) {
					$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'eventoPlantillaCreado' );
				} else {
					$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorEventoPlantillaCreado' );
				}
			}
			
			Redireccionador::redireccionar ( "creacionEventoPlantillaOK", $datos );
		} else {
			$datos ['id_plantilla'] = $_REQUEST ['id_plantilla'];
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			Redireccionador::redireccionar ( "creacionEventoPlantillaOK", $datos );
		}
	}
	
	/**
	 * Crea un obleto DateInterval de php y con serializa con Json
	 *
	 * @return string
	 */
	function armarIntervaloTiempo() {
		if (isset ( $_REQUEST ['evento_precedente'] )) {
			$datos ['posicion'] = 1;
			$datos ['evento_precedente'] = $_REQUEST ['evento_precedente'];
			
			$intervaloTiempo = "P";
			
			if (isset ( $_REQUEST ['anos'] ) and $_REQUEST ['anos'] !== "" and $_REQUEST ['anos'] !== "0") {
				$intervaloTiempo .= $_REQUEST ['anos'] . "Y";
			}
			if (isset ( $_REQUEST ['meses'] ) and $_REQUEST ['meses'] !== "" and $_REQUEST ['meses'] !== "0") {
				$intervaloTiempo .= $_REQUEST ['meses'] . "M";
			}
			if (isset ( $_REQUEST ['dias'] ) and $_REQUEST ['dias'] !== "" and $_REQUEST ['dias'] !== "0") {
				$intervaloTiempo .= $_REQUEST ['dias'] . "D";
			}
			if ($_REQUEST ['horas'] || $_REQUEST ['minutos'] || $_REQUEST ['segundos']) {
				$intervaloTiempo .= "T";
			}
			if (isset ( $_REQUEST ['horas'] ) and $_REQUEST ['horas'] !== "" and $_REQUEST ['horas'] !== "0") {
				$intervaloTiempo .= $_REQUEST ['horas'] . "H";
			}
			if (isset ( $_REQUEST ['minutos'] ) and $_REQUEST ['minutos'] !== "" and $_REQUEST ['minutos'] !== "0") {
				$intervaloTiempo .= $_REQUEST ['horas'] . "M";
			}
			if (isset ( $_REQUEST ['segundos'] ) and $_REQUEST ['segundos'] !== "" and $_REQUEST ['segundos'] !== "0") {
				$intervaloTiempo .= $_REQUEST ['segundos'] . "S";
			}
			
			// pasa la cadena intervalo de tiempo P0Y0M0DT0H0M0S para despues se creado el objeto DateInterval ej:
			// $intervaloTiempo = new \DateInterval ( $intervaloTiempo ); // P0Y0M0DT0H0M0S
			
			if ($intervaloTiempo == 'P') {
				$intervaloTiempo = 'P0Y';
			}
			
			return $intervaloTiempo;
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



