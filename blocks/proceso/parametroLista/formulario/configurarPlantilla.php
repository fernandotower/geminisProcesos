<?php
use component\Calendar\Componente;
include_once ('component/Calendar/Componente.php');
class ConfiguradorPlantilla {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $urlImagenes;
	var $eventosplantilla;
	var $relacionEventos;
	var $plantilla;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miComponente = new Componente ();
		
		$id_plantilla = $_REQUEST ['id_plantilla'];
		
		$this->plantilla = $this->miComponente->consultarPlantilla ( $id_plantilla );
		
		// datos necesarios para obtener los permisos
		$datos ['id_objeto'] = $this->plantilla ['id_plantilla'];
		$datos ['tipo_objeto'] = '3'; // 1. calendario 2. evento 3. plantilla 4. eventoPlantilla
		$datos ['id_usuario'] = $_REQUEST ['id_usuario'];
		$this->permisosPlantilla = $this->miComponente->consultarRelacion ( $datos );
		
		$this->eventosplantilla = $this->miComponente->consultarEventosPlantilla ( $id_plantilla );
		
		$this->relacionEventos = $this->miComponente->consultarRelacionEventos ( $id_plantilla );
	}
	function mostrarDatosPlantilla() {
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		$url = 'index.php?data';
		$variableNuevoEvento = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variableNuevoEvento .= "&opcion=crearPlantillaEvento"; // va a frontera
		$variableNuevoEvento .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variableNuevoEvento .= "&id_plantilla=" . $this->plantilla ['id_plantilla'];
		$variableNuevoEvento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableNuevoEvento, $url );
		echo '<div style="clear: right; padding: 10px">';
		
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Plantilla " . $this->plantilla ['id_plantilla'] . ": " . $this->plantilla ['nombre_plantilla'];
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		?>
<div style="clear: right; padding: 10px">
	<div><?php echo $this->plantilla['descripcion_plantilla']?></div>

</div>
<?
		
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		echo '</div>';
	}
	function mostrarSecuenciaDeEventos() {
		echo "<hr>";
		$resultadoRelacionEventos = $this->relacionEventos;
		echo '<div style="clear: right; padding: 10px">';
		
		$esteCampo = "marcoSecuenciaEventos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = 'Secuencia de eventos';
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
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
						$plantillaevento1 = $this->miComponente->consultarEventoPlantilla ( $relacion ['id_evento1'] );
						echo "<b><span class='green'>" . $posicion . "</span></b><br> ";
						// Almacenar en memoria la fecha donde id_evento es el indice y la fecha valor: id_evento=>fecha
						if (! isset ( $eventoMostrado ['id_evento1'] )) {
							echo $plantillaevento1 ['id_plantillaevento'] . ' - ';
							echo $plantillaevento1 ['nombre_plantillaevento'];
							// echo $plantillaevento1 ['descripcion_plantillaevento'];
							echo "<br>";
						} else {
						}
						$this->decodificarIntervalo ( $relacion ['intervalo'] );
						// echo $relacion ['intervalo'] . '<br>';
						// $eventoMostrado ['id_evento1']=1;
						
						// evento 2
						// consultar evento1
						$plantillaevento2 = $this->miComponente->consultarEventoPlantilla ( $relacion ['id_evento2'] );
						
						echo $plantillaevento2 ['id_plantillaevento'] . ' - ';
						echo $plantillaevento2 ['nombre_plantillaevento'] . '<br>';
						// echo $plantillaevento2 ['descripcion_plantillaevento'] . '<br>';
						// echo $relacion ['intervalo'] . '<br>';
						
						// Almacenar en memoria la fecha donde id_evento es el indice y la fecha valor: id_evento=>fecha
						if (! isset ( $fechaEvento [$relacion ['id_evento1']] )) {
							// $fechaEvento [$relacion ['id_evento1']] = $datosEvento1 ['fecha_inicio'];
						} else {
						}
						unset ( $plantillaevento1 );
						unset ( $datosEvento1 );
						unset ( $plantillaevento2 );
						unset ( $datosEvento2 );
					}
					;
				}
			}
		} else {
			echo 'No existen secuencia de eventos!<br>Por favor registre un nuevo evento para crear una secuencia';
		}
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		echo '</div>';
	}
	function decodificarIntervalo($intervalo) {
		$miIntervalo = new DateInterval ( $intervalo );
		
		if ($miIntervalo->y == 1) {
			echo $miIntervalo->y . ' año, ';
		}
		if ($miIntervalo->y > 1) {
			echo $miIntervalo->y . ' años, ';
		}
		if ($miIntervalo->m == 1) {
			echo $miIntervalo->m . ' mes, ';
		}
		if ($miIntervalo->m > 1) {
			echo $miIntervalo->m . ' meses, ';
		}
		if ($miIntervalo->d == 1) {
			echo $miIntervalo->d . ' día, ';
		}
		if ($miIntervalo->d > 1) {
			echo $miIntervalo->d . ' días, ';
		}
		if ($miIntervalo->h == 1) {
			echo $miIntervalo->h . ' hora, ';
		}
		if ($miIntervalo->h > 1) {
			echo $miIntervalo->h . ' horas, ';
		}
		if ($miIntervalo->i == 1) {
			echo $miIntervalo->i . ' minuto, ';
		}
		if ($miIntervalo->i > 1) {
			echo $miIntervalo->i . ' minutos, ';
		}
		if ($miIntervalo->s == 1) {
			echo $miIntervalo->s . ' segundo, ';
		}
		if ($miIntervalo->s > 1) {
			echo $miIntervalo->s . ' segundos, ';
		}
		//en el caso de ingresar todos los campos cero, esto para evitar error
		if ($intervalo=='P0Y') {
			echo 'Inician en el mismo instante';
		}
		echo '<br>';
	}
	function mostrarListadoEventos() {
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		$url = 'index.php?data';
		$variableNuevoEvento = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variableNuevoEvento .= "&opcion=crearPlantillaEvento"; // va a frontera
		$variableNuevoEvento .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variableNuevoEvento .= "&id_plantilla=" . $this->plantilla ['id_plantilla'];
		$variableNuevoEvento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableNuevoEvento, $url );
		echo '<div style="clear: right; padding: 10px">';		
		
		$esteCampo = "marcoSecuenciaEventos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = 'Listado de eventos';
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		if (stristr ( $this->permisosPlantilla ['permiso'], 'p' ) || stristr ( $this->permisosPlantilla ['permiso'], 'w' )) {
		?>
<div style="float: right; padding: 10px">
	<div id="toolbar" class="ui-widget-header ui-corner-all"
		style="float: right">
		<a id="nuevoEvento" href="<?php echo $variableNuevoEvento?>">Nuevo
			Evento</a>
	</div>
</div>
<?}
		if ($this->eventosplantilla) {
			
			?>
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Número</th>
			<th>Nombre</th>
			<th>Descripción</th>
			<th>Editar</th>
			<th>Eliminar</th>
		</tr>
	</thead>

	<tbody>

<?
			
			foreach ( $this->eventosplantilla as $evento ) {
				?>
				<tr>
			<td><?php echo $evento ['id_plantillaevento'];?></td>
			<td><?php echo $evento ['nombre_plantillaevento'];?></td>
			<td><?php echo $evento ['descripcion_plantillaevento'];?></td>
		
<?php
				if (isset ( $this->relacionEventos )) {
					
					foreach ( $this->relacionEventos as $value ) {
						
						if ($value ['id_evento2'] == $evento ['id_plantillaevento']) {
							$evento ['id_plantillaevento_orden'] = $value ['id_plantillaevento_orden'];
							$evento ['evento_precedente'] = $value ['id_evento1'];
							$evento ['intervalo'] = $value ['intervalo'];
						}
					}
				}
				
				if (stristr ( $this->permisosPlantilla ['permiso'], 'p' ) || stristr ( $this->permisosPlantilla ['permiso'], 'w' )) {
					?>
				<td align='center'><?php $this->crearEnlaceEditarEvento ( $evento );?></td>
				<?php
				} else {
					echo '<td align="center"></td>';
				}
				
				if (isset ( $evento ['evento_precedente'] ) & (stristr ( $this->permisosPlantilla ['permiso'], 'p' ) || stristr ( $this->permisosPlantilla ['permiso'], 'w' ))) {
					?>
				<td align='center'><?php $this->crearEnlaceEliminarEvento ( $evento );?></td>
				<?php
				
} else {
					echo '<td align="center"></td>';
				}
				?>
				
		
							
				<?php
			}
			?>
			</tr>

</table><?
		}
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		echo '</div>';
	}
	function crearEnlaceEditarEvento($evento) {
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=editarPlantillaEvento"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_plantillaevento=" . $evento ['id_plantillaevento'];
		$variable .= "&id_plantilla=" . $evento ['id_plantilla'];
		$variable .= "&nombre_plantillaevento=" . $evento ['nombre_plantillaevento'];
		$variable .= "&descripcion_plantillaevento=" . $evento ['descripcion_plantillaevento'];
		$variable .= "&tipo=" . $evento ['tipo'];
		$variable .= "&estado=" . $evento ['estado'];
		if (isset ( $evento ['evento_precedente'] )) {
			$variable .= "&id_plantillaevento_orden=" . $evento ['id_plantillaevento_orden'];
			$variable .= "&evento_precedente=" . $evento ['evento_precedente'];
			$variable .= "&intervalo=" . $evento ['intervalo'];
		}
		
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<a href='<? echo $variable?>' title='Editar Evento de Plantilla'> <img
	src='<? echo $this->urlImagenes?>images/edit.png' width='25px'>
</a>
<?php
	}
	function crearEnlaceEliminarEvento($evento) {
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=borrarPlantillaEvento"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_plantillaevento=" . $evento ['id_plantillaevento'];
		$variable .= "&id_plantilla=" . $evento ['id_plantilla'];
		// $variable .= "&nombre_plantillaevento=" . $evento ['nombre_plantillaevento'];
		// $variable .= "&descripcion_plantillaevento=" . $evento ['descripcion_plantillaevento'];
		// $variable .= "&tipo=" . $evento ['tipo'];
		// $variable .= "&estado=" . $evento ['estado'];
		if (isset ( $evento ['evento_precedente'] )) {
			$variable .= "&id_plantillaevento_orden=" . $evento ['id_plantillaevento_orden'];
			$variable .= "&evento_precedente=" . $evento ['evento_precedente'];
			// $variable .= "&intervalo=" . $evento ['intervalo'];
		}
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		?>
<a href='<? echo $variable?>' title='Eliminar Evento de Plantilla'> <img
	src='<? echo $this->urlImagenes?>images/borrar_redondo.png'
	width='25px'>
</a>
<?
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

$miRegistrador = new ConfiguradorPlantilla ( $this->lenguaje, $this->miFormulario );
$miRegistrador->mensaje ();
$miRegistrador->mostrarDatosPlantilla (); // datos de la plantilla y enlace nuevo evento plantilla
                                          // $miRegistrador->formConfigurarPlantilla ();
$miRegistrador->mostrarListadoEventos ();
$miRegistrador->mostrarSecuenciaDeEventos ();

?>