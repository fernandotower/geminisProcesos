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

		//var_dump($_REQUEST);exit;
		$datos ['nombre_plantilla'] = $_REQUEST ['nombre_plantilla'];
		$datos ['descripcion_plantilla'] = $_REQUEST ['descripcion_plantilla'];
		$datos ['propietario'] = $_REQUEST ['propietario'];
		$datos ['estado'] = 1; // Toda plantilla se crea como activa
		
		$datosPlantilla = json_encode ( $datos );
		
		$usuario = $_REQUEST ['id_usuario'];
		
		$miComponente = new Componente ();
		
		$resultadoPlantilla = $miComponente->crearPlantilla ( $datosPlantilla );
		
		if ($resultadoPlantilla == true) {
			// consulto el id_plantilla asignado en el registro
			$secuencia = 'plantillacalendario_id_plantillacalendario_seq';
			$id_plantilla = $resultadoSecuencia = $miComponente->consultarSecuencia ( $secuencia );
			
			$datos ['id_plantilla'] = $id_plantilla; // se agrega el valor de plantilla insertado en el arreglo $datos
			$datos ['privilegio'] = $_REQUEST ['privilegio'];
			$datos ['id_proceso'] = $_REQUEST ['id_proceso'];
			$datos ['estado_plantilla_usuario'] = $_REQUEST ['estado_plantilla_usuario'];
			
			$datosPlantillaUsuario = json_encode ( $datos );
			
			$resultadoPlantilla = $miComponente->registrarPlantillaUsuario ( $datosPlantillaUsuario );
			
			if ($resultadoPlantilla == true) {
				echo 'registro exitoso';
			}else{
				echo 'no se realizó el registro calendariousuario';
			}
		} else {
			echo "no se realizó el registro del calendario";
		}
		
		
		Redireccionador::redireccionar ( "creacionPlantillaOK", $usuario );
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



