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
		
		$datos ['nombre_calendario'] = $_REQUEST ['nombre_calendario'];
		$datos ['descripcion_calendario'] = $_REQUEST ['descripcion_calendario'];
		$datos ['propietario'] = $_REQUEST ['propietario'];
		$datos ['zona_horaria'] = $_REQUEST ['zona_horaria'];
		$datos ['estado'] = 1; // Todo calendario nuevo se crea como borrador
		$datos ['id_plantilla'] = $_REQUEST ['id_plantilla'];
		$datos ['id_proceso'] = $_REQUEST ['id_proceso'];
		$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
		
		$datosCalendario = json_encode ( $datos );		
		
		$miComponente = new Componente ();
		
		$resultadoCalendario = $miComponente->crearCalendario ( $datosCalendario );
		
		if ($resultadoCalendario == true) {
			// consulto el id_calendario asignado en el registro
			$secuencia = 'calendario_id_calendario_seq';
			$id_calendario = $resultadoSecuencia = $miComponente->consultarSecuencia ( $secuencia );					
			
			$datos ['id_objeto'] = $id_calendario; // se agrega el valor de calendario insertado en el arreglo $datos
			$datos ['id_calendario'] = $id_calendario; // se agrega el valor de calendario insertado en el arreglo $datos
			$datos ['tipo_objeto'] = '1';//calendario
			$datos ['permiso'] = 'p';//propietario
			
			$datosCalendarioPermiso = json_encode ( $datos );
			
			$resultadoCalendario = $miComponente->registrarPermisoCalendario ( $datosCalendarioPermiso );
			
		} else {
			echo "no se realizó el registro calendario";
		}
		
		// clonar eventos de la plantilla
		/**
		 * echo "1.
		 * consultar las posiciones,
		 * para cada posición:
		 * 2consultar evento1,
		 * 3insertar con fecha actual,
		 * 4consultar evento2,
		 * 5calcular fecha
		 * 6insertar evento
		 * ";
		 */
		
		// Consultar posiciones en la tabla orden
		
		$resultadoRelacionEventos = $miComponente->consultarRelacionEventos ( $datos ['id_plantilla'] );
		if (isset ( $resultadoRelacionEventos )) {
			
			foreach ( $resultadoRelacionEventos as $relacion ) {
				$posiciones [] = $relacion ['posicion'];
			}
			$posiciones = array_unique ( $posiciones );
			asort ( $posiciones );
			
			foreach ( $posiciones as $posicion ) {
				foreach ( $resultadoRelacionEventos as $relacion ) {
					if ($posicion == $relacion ['posicion']) {
						// consultar evento1
						$plantillaevento1 = $miComponente->consultarEventoPlantilla ( $relacion ['id_evento1'] );
						
						$datosEvento1 ['id_calendario'] = $datos ['id_calendario'];
						$datosEvento1 ['nombre_evento'] = $plantillaevento1 ['nombre_plantillaevento'];
						$datosEvento1 ['descripcion_evento'] = $plantillaevento1 ['descripcion_plantillaevento'];
						$datosEvento1 ['tipo'] = $plantillaevento1 ['tipo'];
						if ($posicion == 1) {
							$datosEvento1 ['fecha_inicio'] = date ( 'Y-m-d' );
							$datosEvento1 ['fecha_fin'] = date ( 'Y-m-d' );
						} else {
							$datosEvento1 ['fecha_inicio'] = $fechaEvento [$relacion ['id_evento1']];
							$datosEvento1 ['fecha_fin'] = $fechaEvento [$relacion ['id_evento1']];
						}
						
						$datosEvento1 ['ubicacion'] = "";
						$datosEvento1 ['estado'] = "1";
						
						// Almacenar en memoria la fecha donde id_evento es el indice y la fecha valor: id_evento=>fecha
						if (! isset ( $fechaEvento [$relacion ['id_evento1']] )) {
							$fechaEvento [$relacion ['id_evento1']] = $datosEvento1 ['fecha_inicio'];
							
							$datosJsonEvento1 = json_encode ( $datosEvento1 );
							
							$miComponente->crearEvento ( $datosJsonEvento1 );
						} else {
						}
						
						// evento 2
						
						$plantillaevento2 = $miComponente->consultarEventoPlantilla ( $relacion ['id_evento2'] );
						// armar la fecha
						$fecha = new \DateTime ( $fechaEvento [$relacion ['id_evento1']] );
						$intervalo = $relacion ['intervalo'];
						$fecha->add ( new \DateInterval ( $intervalo ) );
						$fechaEvento2 = $fechaEvento [$relacion ['id_evento2']] = $fecha->format ( 'Y-m-d' );
						
						$datosEvento2 ['id_calendario'] = $datos ['id_calendario'];
						$datosEvento2 ['nombre_evento'] = $plantillaevento2 ['nombre_plantillaevento'];
						$datosEvento2 ['descripcion_evento'] = $plantillaevento2 ['descripcion_plantillaevento'];
						$datosEvento2 ['tipo'] = $plantillaevento2 ['tipo'];
						$datosEvento2 ['fecha_inicio'] = $fechaEvento2;
						$datosEvento2 ['fecha_fin'] = $fechaEvento2;
						$datosEvento2 ['ubicacion'] = "";
						$datosEvento2 ['estado'] = "1";
						
						$datosEvento2 = json_encode ( $datosEvento2 );
						
						$miComponente->crearEvento ( $datosEvento2 );
						
						unset ( $plantillaevento1 );
						unset ( $datosEvento1 );
						unset ( $plantillaevento2 );
						unset ( $datosEvento2 );
					}
					;
				}
			}
		}else{
			echo 'No existe secuencia de eventos en la plantilla';
		}
		Redireccionador::redireccionar ( "creacionCalendarioOK", $datos );
		}else{
			$datos ['id_calendario'] = '';
			$datos ['permiso'] = '';
			$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
			Redireccionador::redireccionar ( "creacionCalendarioOK", $datos );
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



