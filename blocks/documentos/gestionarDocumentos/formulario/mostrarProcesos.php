<?php
use component\GestorProcesos\Componente;
include_once ('component/GestorProcesos/Componente.php');
class MostradorCalendario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miComponente;
	var $urlImagenes;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'academica' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		// 1. Invocar al componente calendario
		$this->miComponente = new Componente ();
	}
	function mostrarLista() {
		
		$this->miComponente->ejecutarProceso();
		exit;
		
		$usuario = $_REQUEST ['id_usuario'];
		$resultadoMiCalendario = $this->miComponente->consultarCalendariosUsuario ( $usuario );
		$registro = $resultadoMiCalendario;
		
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Procesos";
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		
		if ($registro) {
			?>


<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Nro.</th>
			<th>Nombre</th>
			<th>Descripción</th>
			<th>Proceso padre</th>
			<th>Configurar</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>0</td>
			<td>Gestión Académica</td>
			<td>Administración de los procesos Académicos</td>
			<td></td>
			<td align='center'><div>
					<a href='' title='Editar Calendario'> <img
						src='<? echo $this->urlImagenes?>/images/configurar.png'
						width='26px'></a>
				</div></td>
		</tr>
		<tr>
			<td>1</td>
			<td>Gestión de Matrículas</td>
			<td>Administración de los procesos de Matrículas</td>
			<td>Gestión Académica</td>
			<td align='center'><div>
					<a href='' title='Editar Calendario'> <img
						src='<? echo $this->urlImagenes?>/images/configurar.png'
						width='26px'></a>
				</div></td>
		</tr>
		<tr>
			<td>2</td>
			<td>Gestión de Notas</td>
			<td>Administración de los procesos de Notas</td>
			<td>Gestión Académica</td>
			<td align='center'><div>
					<a href='' title='Editar Calendario'> <img
						src='<? echo $this->urlImagenes?>/images/configurar.png'
						width='26px'></a>
				</div></td>
		</tr>
		<tr>
			<td>3</td>
			<td>Trabajos de Grado</td>
			<td>Administración de los procesos de Trabajos de Grado</td>
			<td>Gestión Académica</td>
			<td align='center'><?php $this->crearEnlaceConsultarCalendario (3);?></td>
		</tr>

	</tbody>

</table>



<?
			
			echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		} else {
			echo 'No existen registros de calendario en el sistema!';
		}
		unset ( $variable );
	}
	/**
	 * // Posibles estados: borrador, activo, finalizado, inactivo, eliminado
	 *
	 * @param unknown $estado        	
	 */
	function mostrarEstado($estado) {
		switch ($estado) {
			case 1 :
				echo "Borrador";
				break;
			case 2 :
				echo "Activo";
				break;
			case 3 :
				echo "Finalizado";
				break;
			case 4 :
				echo "Inactivo";
				break;
			case 5 :
				echo "Eliminado";
				break;
			default :
				echo "ND";
				break;
		}
	}
	function mostrarProceso($proceso) {
		switch ($proceso) {
			case 1 :
				echo "General";
				break;
			case 2 :
				echo "Trabajos de Grado";
				break;
			case 3 :
				echo "Grados";
				break;
			case 4 :
				echo "--";
				break;
			case 5 :
				echo "--";
				break;
			default :
				echo "ND";
				break;
		}
	}
	function crearEnlaceEditarCalendario($registro) {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=editarCalendario"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_calendario=" . $registro ['id_calendario'];
		$variable .= "&nombre_calendario=" . $registro ['nombre_calendario'];
		$variable .= "&descripcion_calendario=" . $registro ['descripcion_calendario'];
		$variable .= "&propietario=" . $registro ['propietario'];
		$variable .= "&id_proceso=" . $registro ['id_proceso'];
		$variable .= "&zona_horaria=" . $registro ['zona_horaria'];
		$variable .= "&estado=" . $registro ['estado'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		?>
<div>
	<a href='<? echo $variable?>' title='Editar Calendario'> <img
		src='<? echo $this->urlImagenes?>/images/edit.png' width='26px'></a>
</div>
<?php
	}
	function crearEnlaceConsultarCalendario($calendario) {
		$url = 'index.php?data';
		$variable = "&pagina=calendario";
		$variable .= "&opcion=consultarCalendario"; // va a frontera
		$variable .= "&id_calendario=" . $calendario ['id_calendario'];
		$variable .= "&permiso=" . $calendario ['permiso'];
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<a href='<? echo $variable?>' title='Consultar eventos de calendario'> <img
	src='<? echo $this->urlImagenes?>/images/configurar.png' width='26px'></a>
<?
	}
	function crearEnlaceNuevoCalendario() {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=crearCalendario"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		return $variable;
	}
	
	/**
	 * Se crea un calendario a partir de una plantilla
	 *
	 * @param        	
	 *
	 */
	function crearEnlaceNuevoCalendarioConPlantilla() {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=crearCalendarioConPlantilla"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<div>
	<a href='<? echo $variable?>'
		title='Nuevo Calendario a partir de Plantilla'> <img
		src='<? echo $this->urlImagenes?>/images/calendario.png' width='40px'
		height="40">Nuevo con Plantilla
	</a>
</div>
<?
	}
	function crearEnlaceDuplicarCalendario($registro) {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=duplicarCalendario"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_calendario=" . $registro ['id_calendario'];
		$variable .= "&nombre_calendario=" . $registro ['nombre_calendario'];
		$variable .= "&descripcion_calendario=" . $registro ['descripcion_calendario'];
		$variable .= "&propietario=" . $registro ['propietario'];
		$variable .= "&id_proceso=" . $registro ['id_proceso'];
		$variable .= "&zona_horaria=" . $registro ['zona_horaria'];
		$variable .= "&estado=" . $registro ['estado'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<div>
	<a href='<? echo $variable?>' title='Duplicar Calendario'> <img
		src='<? echo $this->urlImagenes?>images/duplicar.png' width='25px'>
	</a>
</div>

<?
	}
	function mostrarDatosEvento($evento) {
		echo $evento ['fecha_inicio'] . ": " . $evento ['nombre_evento'] . " - " . $evento ['ubicacion'];
		// echo $evento[$clave_evento]['fecha_fin']
	}
	function crearEnlaceNuevoEvento($id_calendario) {
		$url = 'index.php?data';
		$variableNuevoEvento = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variableNuevoEvento .= "&opcion=crearEvento"; // va a frontera
		$variableNuevoEvento .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variableNuevoEvento .= "&id_calendario=" . $id_calendario;
		$variableNuevoEvento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableNuevoEvento, $url );
		
		?>
<a href='<? echo $variableNuevoEvento?>' title='Nuevo Evento'> <img
	src='<? echo $this->urlImagenes?>images/calendario_dia.png'
	width='25px'>
</a>
<?php
	}
	function crearEnlaceEditarEvento($evento) {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=editarEvento"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
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
		$variable .= "&id_evento=" . $evento ['id_evento'];
		$variable .= "&nombre_evento=" . $evento ['nombre_evento'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<a href='<? echo $variable?>'> <img
	src='<? echo $this->urlImagenes?>images/borrar_redondo.png'
	width='25px'>
</a><?php
	}
	function consultarEventos($id_calendario) {
		$mis_eventos = $this->miComponente->consultarEvento ( $id_calendario );
		return $mis_eventos;
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

$miRegistrador = new MostradorCalendario ( $this->lenguaje, $this->miFormulario );
$miRegistrador->mensaje ();
$miRegistrador->mostrarLista ();

// $miRegistrador->formConsultarCalendario();

?>