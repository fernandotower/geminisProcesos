<?php

namespace calendario\permisoCalendario;

use component\Calendar\Componente as ComponenteCalendario;
use component\GestorUsuarios\Componente as ComponenteUsuario;

include_once ('component/Calendar/Componente.php');
include_once ('component/GestorUsuarios/Componente.php');

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
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
	function formCrearPermiso() {
				
		$id_usuario = $_REQUEST ['id_usuario'];
		$calendario = $this->miComponente->consultarCalendariosUsuario ( $id_usuario );
		$plantilla = $this->miComponente->consultarPlantillaUsuario ( $id_usuario );

		$listaUsuario = $this->miComponenteUsuario->consultarUsuarios ( 'no necesita' );
		
		if ($calendario ) {
			foreach ( $calendario as $unCalendario ) {
				$objeto ['calendario' . $unCalendario ['id_calendario']] ['tipo'] = $unCalendario ['tipo_objeto'];
				$objeto ['calendario' . $unCalendario ['id_calendario']] ['id'] = $unCalendario ['id_calendario'];
				$objeto ['calendario' . $unCalendario ['id_calendario']] ['nombre'] = $unCalendario ['nombre_calendario'];
			}
		}
		if (isset ( $plantilla )) {
			foreach ( $plantilla as $unaPlantilla ) {
				$objeto ['plantilla' . $unaPlantilla ['id_plantilla']] ['tipo'] = $unaPlantilla ['tipo_objeto'];
				$objeto ['plantilla' . $unaPlantilla ['id_plantilla']] ['id'] = $unaPlantilla ['id_plantilla'];
				$objeto ['plantilla' . $unaPlantilla ['id_plantilla']] ['nombre'] = $unaPlantilla ['nombre_plantilla'];
			}
		}
		
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
		$_REQUEST ['tiempo'] = time ();
		
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
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		?>
<div>
	<div style="float: right">
		<?php
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'botonEnviar';
		$atributos ["id"] = $esteCampo;
		$atributos ["tabIndex"] = $tab;
		$atributos ["tipo"] = 'boton';
		// submit: no se coloca si se desea un tipo button genérico
		$atributos ['submit'] = true;
		$atributos ["estiloMarco"] = '';
		$atributos ["estiloBoton"] = 'jqueryui';
		// verificar: true para verificar el formulario antes de pasarlo al servidor.
		$atributos ["verificar"] = '';
		$atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoBoton ( $atributos );
		unset ( $atributos );
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		?>
		</div>
</div>
<div style="clear: right; padding: 10px">
	<div style="float: left; padding: 5px; ; width: 60%;" id=columna1>
		<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Tipo</th>
					<th>Nro.</th>
					<th>Nombre</th>
					<th>Lectura</th>
					<th>Escritura</th>
				</tr>
			</thead>

			<tbody>
				<?php
		if (isset ( $objeto )) {
			foreach ( $objeto as $unObjeto ) {
				?>
						
				<tr>
					<td><?$this->mostrarTipoObjeto ( $unObjeto ['tipo'] );?></td>
					<td><?echo $unObjeto['id'] ?></td>
					<td><?echo $unObjeto['nombre'] ?></td>
					<td align='center'>
					<?php
				
				// el id del campo se pasa como un string json con los dato necesarios
				$campoLectura ['tipo'] = $unObjeto ['tipo'];
				$campoLectura ['id'] = $unObjeto ['id'];
				$campoLectura ['permiso'] = 'r';
				$campoLecturaJson = json_encode ( $campoLectura );
				
				// ---------------- CONTROL: checkBox --------------------------------------------------------
				$esteCampo = $campoLecturaJson;
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				// $atributos ['tipo'] = 'text';
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
				// --------------- FIN CONTROL : checkBox --------------------------------------------------
				
				?>
					</td>
					<td align='center'>
					
					<?php
				
				// el id del campo se pasa como un string json con los dato necesarios
				$campoEscritura ['tipo'] = $unObjeto ['tipo'];
				$campoEscritura ['id'] = $unObjeto ['id'];
				$campoEscritura ['permiso'] = 'w';
				$campoEscrituraJson = json_encode ( $campoEscritura );
				// ---------------- CONTROL: checkBox --------------------------------------------------------
				$esteCampo = $campoEscrituraJson;
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				// $atributos ['tipo'] = 'text';
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
				// --------------- FIN CONTROL : checkBox --------------------------------------------------
				
				?>
					
					</td>
				</tr>


				</td>
				</tr>
							<?php
			}
		}
		?>
					
				</tbody>
		</table>

	</div>
	<!--<div align=center style="float: left; padding: 10px">Asignar=></div>  -->
	<div style="float: right; padding: 5px; width: 35%;" id=columna2>
		<table id="example1" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Documento</th>
					<th>Nombre</th>
					<th>Seleccionar</th>
				</tr>
			</thead>

			<tbody>
				<?php
		if (isset ( $listaUsuario )) {
			
			foreach ( $listaUsuario as $unUsuario ) {
				?>
					<tr>
					<td><?echo $unUsuario['id_usuario'] ?></td>
					<td><?echo $unUsuario['nombre_usuario'] ?></td>
					<td align='center'>
					
					<?php
				
				// ---------------- CONTROL: checkBox --------------------------------------------------------
				$esteCampo = $unUsuario ['id_usuario'];
				$atributos ['id'] = $esteCampo;
				$atributos ['nombre'] = $esteCampo;
				// $atributos ['tipo'] = 'text';
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
				
				?>
					
					</td>
				</tr>
					<?php
			}
		}
		?>
				</tbody>
		</table>
	</div>
</div>

<?
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		/**
		 * $esteCampo = 'botonCancelar';
		 * $atributos ["id"] = $esteCampo;
		 * $atributos ["tabIndex"] = $tab;
		 * $atributos ["tipo"] = 'boton';
		 * // submit: no se coloca si se desea un tipo button genérico
		 * $atributos ['submit'] = true;
		 * $atributos ["estiloMarco"] = '';
		 * $atributos ["estiloBoton"] = 'jqueryui';
		 * // verificar: true para verificar el formulario antes de pasarlo al servidor.
		 * $atributos ["verificar"] = '';
		 * $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
		 * $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
		 * $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
		 * $tab ++;
		 *
		 * // Aplica atributos globales al control
		 * $atributos = array_merge ( $atributos, $atributosGlobales );
		 * echo $this->miFormulario->campoBoton ( $atributos );
		 */
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
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
		$valorCodificado .= "&opcion=crearPermiso";
		$valorCodificado .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		
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
		
		return true;
	}
	function mostrarTipoObjeto($tipo) {
		switch ($tipo) {
			case 1 :
				echo 'Calendario';
				break;
			case 2 :
				echo 'Evento';
				break;
			case 3 :
				echo 'Plantilla';
				break;
			
			case 4 :
				echo 'Evento de Plantilla';
				break;
			
			default :
				
				echo 'N/D';
				break;
		}
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
		
		return true;
	}
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario );

$miFormulario->formCrearPermiso ();
//$miFormulario->mensaje ();

?>