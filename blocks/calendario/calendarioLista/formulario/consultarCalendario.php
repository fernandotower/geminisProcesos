<?php
use component\Calendar\Componente;
include_once ('component/Calendar/Componente.php');

class ConsultorCalendario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		// 1. Invocar al componente calendario
		$this->miComponente = new Componente ();
	}
	function mostrarCalendario() {
		$id_calendario = $_REQUEST ['id_calendario'];
		$resultadoCalendario = $this->miComponente->consultarCalendario ( $id_calendario );
		
		$eventos = $this->miComponente->consultarEvento ( $id_calendario );
		
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Calendario " .$resultadoCalendario ['id_calendario'].': '. $resultadoCalendario ['nombre_calendario'];
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		echo '<br>' . $resultadoCalendario ['descripcion_calendario'] . '<br><hr>Estado: ';
		switch ($resultadoCalendario ['estado']) {
			case 1 :
				echo 'Borrador';
				break;
			case 2 :
				echo 'Activo';
				break;
			case 3 :
				echo 'Finalizado';
				break;
			case 4 :
				echo 'Inactivo';
				break;
			case 5 :
				echo 'Eliminado';
				break;
		}
		
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		
		echo '<br>';
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Eventos";
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		if ($eventos) {
			?>


<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Evento</th>
			<th>Descripción</th>
			<th>Ubicación</th>
			<th>Estado</th>
			<th>Editar</th>
			<th>Eliminar</th>

		</tr>
	</thead>

	<tbody>
	
	        <?
			// Presenta los calendarios
			foreach ( $eventos as $clave => $valor ) {
				if ($eventos [$clave] ['estado'] != 0) {
					?>
		<td><?echo $eventos [$clave] ['fecha_inicio'] ?></td>
		<td><?echo $eventos [$clave] ['nombre_evento'] ?></td>
		<td><?echo $eventos [$clave] ['descripcion_evento'] ?></td>
		<td><?echo $eventos [$clave] ['ubicacion'] ?></td>
		<td align='center'><?echo $eventos [$clave] ['estado'] ?></td>
		<?php
					
					if (stristr ( $resultadoCalendario ['permiso'], 'p' ) || stristr ( $resultadoCalendario ['permiso'], 'w' )) {
						?>
					<td align='center'><?echo $this->crearEnlaceEditarEvento($eventos[$clave])?></td>
					<td align='center'><?echo $this->crearEnlaceBorrarEvento($eventos[$clave])?></td>
					<?
					}else {
						?>						
					<td align='center'>-</td>
					<td align='center'>-</td>						
						<?
					}
					?>
		
		
		</tr>
			<?php
				}
			}
			?>		
		</tbody>

</table>



<?
			
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
			unset ( $variable );
		} else
			echo 'No existen eventos registrados para el calendario!';
	}
	function crearEnlaceEditarEvento($evento) {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=editarEvento"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&permiso=" . $_REQUEST ['permiso'];//el permiso del calendario
		$variable .= "&id_evento=" . $evento ['id_evento'];
		$variable .= "&id_calendario=" . $evento ['id_calendario'];
		$variable .= "&nombre_evento=" . $evento ['nombre_evento'];
		$variable .= "&descripcion_evento=" . $evento ['descripcion_evento'];
		$variable .= "&tipo=" . $evento ['tipo'];
		$variable .= "&fecha_inicio=" . $evento ['fecha_fin'];
		$variable .= "&fecha_fin=" . $evento ['fecha_inicio'];
		$variable .= "&ubicacion=" . $evento ['ubicacion'];
		$variable .= "&estado=" . $evento ['estado'];		
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<a href='<? echo $variable?>'
	title='<?php echo $evento['descripcion_evento']?>'> <img
	src='<? echo $this->urlImagenes?>images/edit.png' width='25px'>
</a>

<?php
	}
	function crearEnlaceBorrarEvento($evento) {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=borrarEvento"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&permiso=" . $_REQUEST ['permiso'];
		$variable .= "&id_evento=" . $evento ['id_evento'];
		$variable .= "&id_calendario=" . $evento ['id_calendario'];
		$variable .= "&nombre_evento=" . $evento ['nombre_evento'];	
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<a href='<? echo $variable?>'> <img
	src='<? echo $this->urlImagenes?>images/borrar_redondo.png'
	width='25px'>
</a><?php
	}
	function formConsultarCalendario() {
		
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
		$atributos ['estiloMarco'] = '';
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'id_usuario';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ['estiloMarco'] = '';
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = false;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ["validar"] = 'required,maxSize[50]';
		
		if (isset ( $_REQUEST [$esteCampo] )) {
			$atributos ['valor'] = $_REQUEST [$esteCampo];
		} else {
			$atributos ['valor'] = '';
		}
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = false;
		$atributos ['tamanno'] = 50;
		$atributos ['maximoTamanno'] = '';
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'botonConsultar';
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
		// -----------------FIN CONTROL: Botón -----------------------------------------------------------
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'botonCancelar';
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
		$valorCodificado .= "&opcion=consultarCalendario";
		
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
		$atributos ['estiloMarco'] = '';
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['estiloMarco'] = '';
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		// return $cadenaHTML;
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

$miRegistrador = new ConsultorCalendario ( $this->lenguaje, $this->miFormulario );
$miRegistrador->mensaje ();
$miRegistrador->mostrarCalendario ();

?>