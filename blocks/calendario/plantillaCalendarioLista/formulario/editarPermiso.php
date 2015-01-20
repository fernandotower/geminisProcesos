<?php

namespace calendario\permisoPlantilla;

use component\Calendar\Componente as ComponenteCalendario;
use component\GestorUsuarios\Componente as ComponenteUsuario;


include_once ('component/Calendar/Componente.php');
include_once ('component/GestorUsuarios/Componente.php');
session_start();
$_REQUEST ['tiempo'] = time ();
$_SESSION["verificaReevio"] = $_REQUEST ['tiempo'];
class EditorPermiso {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		// 1. Invocar al componente calendario
		$this->miComponente = new ComponenteCalendario ();
		$this->miComponenteUsuario = new ComponenteUsuario ();
	}
	function formEditarPermiso() {
		// echo '[x] Consultar datos de plantilla<br>';
		 //echo '[x] Consultar datos de usuario<br>';
		 //echo '[x] Consultar permisos<br>';
		 //echo '[x] Mostrar datos del calendario<br>';
		 //echo '[x] Mostrar formulario con datatable con id_usuario, nombre usuario, privilegios (2 checbox)<br>';
		 //echo '[ ] Crear archivo ajax.php e incluirlo en script <br>';
		 //echo '[ ] Crear archivo procesarAjax.php<br>';
		 //echo '[ ] Decodificar el valor obtenido en el ready <br>';
		 //echo '[ ] Enviar valor a archivo de consulta';
		 		
		// Mostrar datos básicos del calendario
		$id_plantilla = $_REQUEST ['id_plantilla'];
		$plantilla = $this->miComponente->consultarPlantilla ( $id_plantilla );	
		$usuarios = $this->miComponenteUsuario->consultarUsuarios ( 'no necesita' );		
		
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Plantilla ".$plantilla ['id_plantilla'].": ". $plantilla ['nombre_plantilla'];
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		echo '<br>' . $plantilla ['descripcion_plantilla'];	
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		
		// Mostrar tabla para aditar permisos de usuario sobre el calendario
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		//$_REQUEST ['tiempo'] = time ();
		
		// -------------------------------------------------------------------------------------------------
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = '';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Permisos: " . $plantilla ['nombre_plantilla'];
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		
		if ($usuarios) {
			
			?>


<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Documento</th>
			<th>Nombre</th>
			<th>Lectura</th>
			<th>Escritura</th>
		</tr>
	</thead>

	<tbody>			
				       <?
			// Presenta los usuarios
			foreach ( $usuarios as $clave => $valor ) {
				
				echo '<tr>';
				echo '<td>' . $usuarios [$clave] ['id_usuario'] . '</td>';
				echo '<td>' . $usuarios [$clave] ['nombre_usuario'] . '</td>';
				// datos necesarios para obtener los permisos
				$datos ['id_objeto'] = $plantilla ['id_plantilla'];
				$datos ['tipo_objeto'] = '3'; // 1. calendario 2. evento 3. plantilla 4. eventoPlantilla
				$datos ['id_usuario'] = $usuarios [$clave] ['id_usuario'];
				$permiso = $this->miComponente->consultarRelacion ( $datos );
				
				echo '<td align="center">';
				
				
				// el id del campo se pasa como un string json con los dato necesarios
				
				// ---------------- CONTROL: checkBox --------------------------------------------------------
				$esteCampo = $usuarios [$clave] ['id_usuario'];
				$atributos ['id'] = $esteCampo;
				$atributos ['valor'] = 'r';
				$atributos ['nombre'] = $esteCampo;
				if (stristr ( $permiso ['permiso'], 'r' )) {
					$atributos ['seleccionado'] = true;
				} else {
					$atributos ['seleccionado'] = false;
				}
				$atributos ['estilo'] = 'jqueryui';
				// $atributos ['marco'] = true;
				// $atributos ['estiloMarco'] = '';
				// $atributos ['columnas'] = 1;
				// $atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = false;
				// $atributos ['valor'] = $unCalendario['id_calendario'];
				// $atributos ['titulo'] = false;
				// $atributos ['deshabilitado'] = true;
				// $atributos ['tamanno'] = 50;
				// $atributos ['maximoTamanno'] = '';
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->checkBox ( $atributos );
				unset ( $atributos );
				
				// ---------------- FIN CONTROL: checkBox --------------------------------------------------------
				
				echo '</td>';
				echo '<td align="center">';
				
				
				// el id del campo se pasa como un string json con los dato necesarios
				
				// ---------------- CONTROL: checkBox --------------------------------------------------------
				$esteCampo = $usuarios [$clave] ['id_usuario'];
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				$atributos ['valor'] = 'w';
				if (stristr ( $permiso ['permiso'], 'w' )) {
					$atributos ['seleccionado'] = true;
				} else {
					$atributos ['seleccionado'] = false;
				}
				$atributos ['estilo'] = 'jqueryui';
				// $atributos ['marco'] = true;
				// $atributos ['estiloMarco'] = '';
				// $atributos ['columnas'] = 1;
				// $atributos ['dobleLinea'] = false;
				$atributos ['tabIndex'] = $tab;
				$atributos ['etiqueta'] = false;
				// $atributos ['valor'] = $unCalendario['id_calendario'];
				// $atributos ['titulo'] = false;
				// $atributos ['deshabilitado'] = false;
				// $atributos ['tamanno'] = 50;
				// $atributos ['maximoTamanno'] = '';
				$tab ++;
				
				// Aplica atributos globales al control
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->checkBox ( $atributos );
				unset ( $atributos );
				
				// ---------------- FIN CONTROL: checkBox --------------------------------------------------------
				
				echo '</td>';
				
				echo '</tr>';
			}
			?>		
				
	</tbody>

</table>



<?
			unset ( $variable );
		} else {
			echo 'No existen eventos registrados para el calendario!';
		}
		
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		
		// ------------------Fin Division para los botones-------------------------
		echo $this->miFormulario->division ( "fin" );
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&tipo_objeto=3";//plantilla
		$valorCodificado .= "&id_plantilla=" . $_REQUEST['id_plantilla'];				
		
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
	}
	function mensaje() {
		
		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
		
		if ($mensaje) {
			
			$tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );
			
			if ($tipoMensaje == 'json') {
				
				$atributos ['mensaje'] = $mensaje;
				$atributos ['json'] = true;
			} else {
				$atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
			}
			// -------------Control texto-----------------------
			$esteCampo = 'divMensaje';
			$atributos ['id'] = $esteCampo;
			$atributos ["tamanno"] = '';
			$atributos ["estilo"] = 'information';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );
		}
	}
}

$miRegistrador = new EditorPermiso ( $this->lenguaje, $this->miFormulario );

$miRegistrador->formEditarPermiso ();
$miRegistrador->mensaje ();

?>