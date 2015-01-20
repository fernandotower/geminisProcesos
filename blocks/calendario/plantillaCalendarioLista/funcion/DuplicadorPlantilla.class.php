<?php

namespace calendar;

use component\Calendar\Componente;
use calendario\calendarioLista\Redireccionador;

include_once ('Redireccionador.php');
include_once ('component/Calendar/Componente.php');
class DuplicadorCalendario {
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
		
		/**
		 * echo 'Esta el la funcion Duplicador, pasos:<br>
		 * 1.
		 * Registrar plantilla,<br>
		 * 2. Registrar usuario plantilla, <br>
		 * 3. Consultar los eventos, <br>
		 * 4. insertar los eventos,<br>
		 * 5. Consultar relaciones,<br>
		 * 6. Insertar relaciones<br>
		 * ';
		 */
		
		// 1. Registrar plantilla
		$datos ['id_plantilla_base'] = $_REQUEST ['id_plantilla'];
		$datos ['nombre_plantilla'] = $_REQUEST ['nombre_plantilla'];
		$datos ['descripcion_plantilla'] = $_REQUEST ['descripcion_plantilla'];
		$datos ['propietario'] = $_REQUEST ['propietario'];
		$datos ['estado'] = 1; // Toda plantilla nueva se crea como borrador
		$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
		$datos ['id_proceso'] = $_REQUEST ['id_proceso'];
		$datos ['permiso'] = $_REQUEST ['permiso'];
		$datos ['tipo_objeto'] = 3; // plantilla
		
		$datosPlantilla = json_encode ( $datos );
		
		$miComponente = new Componente ();
		
		$resultadoPlantilla = $miComponente->crearPlantilla ( $datosPlantilla );
		
		// 2. Registrar usuario plantilla,
		if ($resultadoPlantilla == true) {
			// consulto el id_calendario asignado en el registro
			$secuencia = 'plantillacalendario_id_plantillacalendario_seq';
			$id_plantilla = $resultadoSecuencia = $miComponente->consultarSecuencia ( $secuencia );
			
			$datos ['id_objeto'] = $id_plantilla; // se agrega el valor de plantilla insertado en el arreglo $datos
			
			$datosPlantillaUsuario = json_encode ( $datos );
			
			$resultadoPermisoPlantilla = $miComponente->registrarPlantillaUsuario ( $datosPlantillaUsuario );
			
			// 3. Consultar los eventos,
			
			if ($resultadoPermisoPlantilla == true) {
				// consulta los eventos del calendario base
				$eventosPlantillaBase = $miComponente->consultarEventosPlantilla ( $datos ['id_plantilla_base'] );
				
				// 4. insertar los eventos
				if ($eventosPlantillaBase) {
					foreach ( $eventosPlantillaBase as $evento => $valor ) {
						// $datosEvento ['id_evento']= $eventosPlantillaBase[$evento]['id_evento'];
						$datosEvento ['id_plantilla'] = $id_plantilla; // se refiere a la plantilla nueva
						$datosEvento ['nombre_plantillaevento'] = $eventosPlantillaBase [$evento] ['nombre_plantillaevento'];
						$datosEvento ['descripcion_plantillaevento'] = $eventosPlantillaBase [$evento] ['descripcion_plantillaevento'];
						$datosEvento ['tipo'] = $eventosPlantillaBase [$evento] ['tipo'];
						$datosEvento ['estado'] = $eventosPlantillaBase [$evento] ['estado'];
						
						$datosEvento = json_encode ( $datosEvento );
						
						$resultadoEvento = $miComponente->crearEventoPlantilla ( $datosEvento );
						if ($resultadoEvento) {
						} else {
							echo 'Error en la creación de los avento de la plantilla';
							exit ();
						}
						unset ( $datosEvento );
					}
				}
				
				// 5. Consultar relaciones
				$relacionEventosBase = $miComponente->consultarRelacionEventos ( $datos ['id_plantilla_base'] );
				// 6. Insertar relaciones
				if ($relacionEventosBase) {
					foreach ( $relacionEventosBase as $relacion => $valor ) {
						$datosRelacion ['id_plantilla'] = $id_plantilla; // se refiere a la plantilla nueva
						$datosRelacion ['posicion'] = $relacionEventosBase [$relacion] ['posicion'];
						$datosRelacion ['id_evento1'] = $relacionEventosBase [$relacion] ['id_evento1'];
						$datosRelacion ['id_evento2'] = $relacionEventosBase [$relacion] ['id_evento2'];
						$datosRelacion ['intervalo'] = $relacionEventosBase [$relacion] ['intervalo'];
						
						$datosRelacion = json_encode ( $datosRelacion );
						
						$resultadoRelacion = $miComponente->crearRelacionEventos ( $datosRelacion );
						
						if ($resultadoRelacion) {
						} else {
							echo 'Error en registro de las relaciones entre los eventos de plantilla';
							exit ();
						}
						unset ( $datosRelacion );
					}
				}
			} else {
				echo "no se realizó el registro de la plantilla";
			}
		}
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'plantillaDuplicada' );
		Redireccionador::redireccionar ( "creacionPlantillaOK", $datos );
		}else{
			
			
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			$datos ['id_plantilla'] = '';
			$datos ['permiso'] = $_REQUEST ['permiso'];
			
			Redireccionador::redireccionar ( "creacionPlantillaOK", $datos );
			
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
}

$miDuplicador = new DuplicadorCalendario ( $this->lenguaje, $this->sql );

$resultado = $miDuplicador->procesarFormulario ();



