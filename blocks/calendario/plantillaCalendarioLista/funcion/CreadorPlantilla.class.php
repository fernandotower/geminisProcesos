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

		session_start ();
		// La veariable $_SESSION['verifica'] viene del formulario
		// se evita reenviar el formulario al enviar la página o ejecutar la instrucciones
		// sin pasar por el formulario
		if (isset ( $_SESSION ['verificaReevio'] ) && $_SESSION ['verificaReevio'] == $_REQUEST ['campoSeguro']) {
			unset ( $_SESSION ['verificaReevio'] );
			
		$datos ['nombre_plantilla'] = $_REQUEST ['nombre_plantilla'];
		$datos ['descripcion_plantilla'] = $_REQUEST ['descripcion_plantilla'];
		$datos ['propietario'] = $_REQUEST ['propietario'];
		$datos ['estado'] = 1; // Toda plantilla se crea como activa
		$datos ['id_proceso'] = $_REQUEST ['id_proceso'];
		$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
		
		$datosPlantilla = json_encode ( $datos );
				
		
		$miComponente = new Componente ();
		
		$resultadoPlantilla = $miComponente->crearPlantilla ( $datosPlantilla );		
		
		if ($resultadoPlantilla == true) {
			// consulto el id_plantilla asignado en el registro
			$secuencia = 'plantillacalendario_id_plantillacalendario_seq';
			$id_plantilla = $resultadoSecuencia = $miComponente->consultarSecuencia ( $secuencia );
			
			$datos ['id_calendario'] = $id_plantilla; // utilizado para la redirección					
			$datos ['id_objeto'] = $id_plantilla; // se agrega el valor de calendario insertado en el arreglo $datos
			$datos ['tipo_objeto'] = '3';//Plantilla
			$datos ['permiso'] = 'p';//propietario		

			$datosPlantillaPermiso = json_encode ( $datos );
			
			$resultadoPermisoPlantilla = $miComponente->registrarPermisoCalendario ( $datosPlantillaPermiso );
			
			if ($resultadoPlantilla==TRUE AND $resultadoPermisoPlantilla==TRUE) {
				$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'plantillaCreada' );
			}else{
				$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', 'errorPlantillaCreada' );
			}
						
		} 		
		
		Redireccionador::redireccionar ( "creacionPlantillaOK", $datos );
		}else{
			
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
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
	function mostrarDatosCalendario($calendario) {
		var_dump ( $calendario );
	}
}

$miRegistrador = new RegistradorCalendario ( $this->lenguaje, $this->sql );

$resultado = $miRegistrador->procesarFormulario ();



