<?php
use component\Calendar\Componente;
// use component\User\Componente;
include_once ('component/Calendar/Componente.php');
// include_once ('component/User/Componente.php');
class MostradorPlantilla {
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
	function formConsultarListadoPlantilla() {
		$id_usuario = $_REQUEST ['id_usuario'];
		$resultadoPlantilla = $this->miComponente->consultarPlantillaUsuario ( $id_usuario );
		$registro = $resultadoPlantilla;
		
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		
		$esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		// $atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "Plantillas de Calendario";
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		if ($registro) {
			?>
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Proceso</th>
			<th>Nro. Plantilla</th>
			<th>Nombre Plantilla</th>
			<th>Descripción</th>
			<th>Estado</th>
			<th>Editar</th>
			<th>Configurar</th>
			<th>Duplicar</th>
		</tr>
	</thead>

	<tbody>

        <?
			// Presenta los calendarios
			foreach ( $registro as $clave => $valor ) {
				if (stristr ( $registro [$clave] ['permiso'], 'p' ) || stristr ( $registro [$clave] ['permiso'], 'r' ) || stristr ( $registro [$clave] ['permiso'], 'w' )) {
					if ($registro [$clave] ['estado'] != 5) {
						
						?>

				<tr>
			<td><?$this->mostrarProceso( $registro[$clave] ['id_proceso']) ?></td>
			<td><?echo $registro [$clave] ['id_plantilla'] ?></td>
			<td><?echo $registro [$clave] ['nombre_plantilla'] ?></td>
			<td><?echo $registro [$clave] ['descripcion_plantilla'] ?></td>
			<td align='center'><?
						// Posibles estados: borrador, activo, finalizado, inactivo, eliminado
						switch ($registro [$clave] ['estado']) {
							case 0 :
								echo "Inactiva";
								break;
							case 1 :
								echo "Activa";
								break;
							
							default :
								echo "ND";
								break;
						}
						?>
				</td>
			
			<?php
						if (stristr ( $registro [$clave] ['permiso'], 'p' ) || stristr ( $registro [$clave] ['permiso'], 'w' )) {
							?><td align='center'><?php $this->mostrarEnlaceEditarPlantilla($registro [$clave])?></td>
			
			<?php
						} else {
							?>						
					<td align='center'>-</td>						
						<?
						}
						?>
			<td align='center'><?php $this->mostrarEnlaceConfigurarPlantilla ( $registro [$clave] );?></td>
			<td align='center'><?php $this->crearEnlaceDuplicarPlantilla($registro [$clave]);?></td>

		</tr>
		<?php
					}
				}
			}
			?>		
	</tbody>

</table>

<?
		} else {
			echo 'No existen plantilla registradas!';
		}
		echo $this->miFormulario->marcoAgrupacion ( 'fin' );
		unset ( $variable );
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
	function crearEnlaceNuevaPlantilla() {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=crearPlantilla"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<div>
	<a href='<? echo $variable?>' title='Nueva Plantilla'> <img
		src='<? echo $this->urlImagenes?>/images/plantilla.png' width='40px'
		height="40">Nueva Plantilla
	</a>
</div>
<?
	}
	function crearEnlaceDuplicarPlantilla($registro) {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=duplicarPlantilla"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_plantilla=" . $registro ['id_plantilla'];
		$variable .= "&nombre_plantilla=" . $registro ['nombre_plantilla'];
		$variable .= "&descripcion_plantilla=" . $registro ['descripcion_plantilla'];
		$variable .= "&propietario=" . $registro ['propietario'];
		$variable .= "&id_proceso=" . $registro ['id_proceso'];
		$variable .= "&estado=" . $registro ['estado'];
		
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<div>
	<a href='<? echo $variable?>' title='Duplicar Plantilla'> <img
		src='<? echo $this->urlImagenes?>images/duplicar.png' width='25px'>
	</a>
</div>

<?
	}
	function mostrarEnlaceConfigurarPlantilla($plantilla) {
		$url = 'index.php?data';
		$variable = "&pagina=plantilla";
		$variable .= "&opcion=configurarPlantilla"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_plantilla=" . $plantilla ['id_plantilla'];
		$variable .= "&nombre_plantilla=" . $plantilla ['nombre_plantilla'];
		$variable .= "&descripcion_plantilla=" . $plantilla ['descripcion_plantilla'];
		$variable .= "&estado=" . $plantilla ['estado'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<a href='<? echo $variable?>'
	title='Crear eventos y configurar intervalos de tiempo'> <img
	src='<? echo $this->urlImagenes?>images/configurar.png' width='25px'>
</a>

<?php
	}
	function mostrarEnlaceEditarPlantilla($plantilla) {
		$url = 'index.php?data';
		$variable = "&pagina=plantillaCalendarioLista";
		$variable .= "&opcion=editarPlantilla"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_plantilla=" . $plantilla ['id_plantilla'];
		$variable .= "&propietario=" . $plantilla ['propietario'];
		$variable .= "&nombre_plantilla=" . $plantilla ['nombre_plantilla'];
		$variable .= "&descripcion_plantilla=" . $plantilla ['descripcion_plantilla'];
		$variable .= "&estado=" . $plantilla ['estado'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		?>
<a href='<? echo $variable?>' title='Editar Plantilla'> <img
	src='<? echo $this->urlImagenes?>images/edit.png' width='25px'>
</a>

<?php
	}
	function mostrarDatosEvento($evento) {
		echo $evento ['fecha_inicio'] . ": " . $evento ['nombre_evento'] . " - " . $evento ['ubicacion'];
		// echo $evento[$clave_evento]['fecha_fin']
	}
	function crearEnlaceNuevaPlantillaEvento($id_plantilla) {
		$url = 'index.php?data';
		$variableNuevoEvento = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variableNuevoEvento .= "&opcion=crearPlantillaEvento"; // va a frontera
		$variableNuevoEvento .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variableNuevoEvento .= "&id_plantilla=" . $id_plantilla;
		$variableNuevoEvento = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableNuevoEvento, $url );
		
		?>
<a href='<? echo $variableNuevoEvento?>' title='Nuevo Evento'> <img
	src='<? echo $this->urlImagenes?>images/calendario_dia.png'
	width='25px'>
</a>
<?php
	}
	function crearEnlaceEditarPlantillaEvento($evento) {
		$url = 'index.php?data';
		$variable = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$variable .= "&opcion=editarPlantillaEvento"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable .= "&id_evento=" . $evento ['id_plantillaevento'];
		$variable .= "&id_plantilla=" . $evento ['id_plantilla'];
		$variable .= "&nombre_evento=" . $evento ['nombre_plantillaevento'];
		$variable .= "&descripcion_evento=" . $evento ['descripcion_plantillaevento'];
		// $variable .= "&tipo=" . $evento ['tipo'];
		// $variable .= "&fecha_inicio=" . $evento ['fecha_fin'];
		// $variable .= "&fecha_fin=" . $evento ['fecha_inicio'];
		// $variable .= "&ubicacion=" . $evento ['ubicacion'];
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
	function consultarEventos($id_plantilla) {
		$mis_eventos = $this->miComponente->consultarEvento ( $id_plantilla );
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

$miRegistrador = new MostradorPlantilla ( $this->lenguaje, $this->miFormulario );
$miRegistrador->mensaje ();
$miRegistrador->formConsultarListadoPlantilla ();

?>