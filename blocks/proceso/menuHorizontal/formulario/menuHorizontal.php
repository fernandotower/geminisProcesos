<?php
// $this->host = $this->miConfigurador->getVariableConfiguracion ( "host" );
// $this->site = $this->miConfigurador->getVariableConfiguracion ( "site" );

class menuHorizontal {
	function armarMenuHorizontal() {
		$this->miConfigurador = Configurador::singleton ();
		$this->urlImagenes = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
		$this->pagina = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
		// enlaces propios de cada página: crear, editar, duplicar, borrar...
		?>

<div style='height: 60px; float: clear'>
	<div id="toolbar" class="ui-widget-header ui-corner-all"
		style="float: right">
		<?php $this->enlaceNuevo()?>
		<?php $this->enlaceNuevoConPlantilla()?>		
		<?php $this->enlaceEditar()?>
		<?php $this->enlaceEliminar()?>
		<?php $this->enlaceDuplicar()?>
		<?php $this->enlacePermisos()?>		
		<a id="salir" href="<?php echo $this->enlaceSalir()?>">salir</a> <span
			id="repeat"> </span>
	</div>

		<?php
		// enlaces del generales del componente: calendario, plantilla, permisos...
		?>
	
	<div id="toolbar" class="ui-widget-header ui-corner-all"
		style="float: left">
		<a id="inicio" href="<?php echo $this->enlaceInicio()?>">Inicio</a> <a
			id="calendarios" href="<?php echo $this->enlaceInicio()?>">Procesos</a>
		<a id="parametros" href="<?php echo $this->enlaceParametro()?>">Parámetros</a>
		
	</div>

</div>




<?
	}
	function enlaceNuevo() {
		$url = 'index.php?data';
		switch ($this->pagina) {
			// En la página que se presenta la lista de todos calendarios
			case 'calendarioLista' :
				$etiqueta = 'Nuevo Calendario';
				$variable = "&pagina=calendarioLista";
				$variable .= "&opcion=crearCalendario"; // va a frontera
				
				break;
			
			// En la página que se presenta un solo calendario con todas sus características
			case 'calendario' :
				$etiqueta = 'Nuevo Evento';
				$variable = "&pagina=calendario";
				$variable .= "&opcion=crearEvento"; // va a frontera
				$variable .= "&id_calendario=" . $_REQUEST ['id_calendario'];
				$variable .= "&permiso=" . $_REQUEST ['permiso'];
				
				if (stristr ( $_REQUEST ['permiso'], 'p' ) || stristr ( $_REQUEST ['permiso'], 'w' )) {
					;
				} else {
					unset ( $etiqueta );
				}
				break;
			
			case 'plantillaCalendarioLista' :
				$etiqueta = 'Nueva Plantilla de Calendario';
				$variable = "&pagina=" . $this->pagina;
				$variable .= "&opcion=crearPlantilla"; // va a frontera
				break;
			case 'plantilla' :
				$etiqueta = 'Nueva plantilla';
				$variable = "&pagina=" . $this->pagina;
				$variable .= "&id_plantilla=" . $_REQUEST ['id_plantilla'];
				$variable .= "&opcion=crearPlantilla"; // va a frontera
				break;
			case 'permisoCalendario' :
				$etiqueta = 'Nuevo Permiso';
				$variable = "&pagina=permisoCalendario";
				$variable .= "&opcion=crearPermisos"; // va a frontera
				break;
			default :
				;
				break;
		}
		if (isset ( $variable, $etiqueta )) {
			$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
			$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
			
			?>
<a id="nuevo" href="<?php echo $variable?>"><?php echo $etiqueta?></a>
<?php
		}
	}
	function enlaceNuevoConPlantilla() {
		$url = 'index.php?data';
		switch ($this->pagina) {
			// En la página que se presenta la lista de todos calendarios
			case 'calendarioLista' :
				$etiqueta = 'Nuevo Calendario basado en plantilla';
				$variable = "&pagina=calendarioLista";
				$variable .= "&opcion=crearCalendarioConPlantilla"; // va a frontera
				break;
			
			default :
				;
				break;
		}
		if (isset ( $variable, $etiqueta )) {
			$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
			$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
				
			?>
	<a id="nuevoPlantilla" href="<?php echo $variable?>"><?php echo $etiqueta?></a>
	<?php
			}
		}
	function enlaceEditar() {
		$url = 'index.php?data';
		switch ($this->pagina) {
			// En la página que se presenta la lista de todos calendarios
			case 'calendarioLista' :
				
				// $variable .= "&opcion=crearCalendario"; // va a frontera
				
				break;
			
			// En la página que se presenta un solo calendario con todas sus características
			case 'calendario' :
				$etiqueta = 'Editar Calendario';
				$variable = "&pagina=calendario";
				$variable .= "&opcion=editarCalendario"; // va a frontera
				$variable .= "&id_calendario=" . $_REQUEST ['id_calendario'];
				$variable .= "&permiso=" . $_REQUEST ['permiso'];
				if (stristr ( $_REQUEST ['permiso'], 'p' ) || stristr ( $_REQUEST ['permiso'], 'w' )) {
					;
				} else {
					unset ( $etiqueta );
				}
				break;
			
			case 'plantillaCalendarioLista' :
				$variable = "&pagina=" . $this->pagina;
				$variable .= "&opcion=crearPlantilla"; // va a frontera
				break;
			default :
				;
				break;
		}
		
		// $variable .= "&opcion=editarCalendario"; // va a frontera
		
		if (isset ( $variable, $etiqueta )) {
			$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
			$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
			?>
<a id="editar" href="<?php echo $variable?>"><?php echo $etiqueta?></a>
<?php
		}
	}
	function enlaceEliminar() {
		$url = 'index.php?data';
		switch ($this->pagina) {
			// En la página que se presenta la lista de todos calendarios
			case 'calendarioLista' :
				// $variable .= "&opcion=eliminarCalendario"; // va a frontera
				
				break;
			
			// En la página que se presenta un solo calendario con todas sus características
			case 'calendario' :
				// $etiqueta = 'Eliminar Calendario';
				// $variable = "&pagina=calendario";
				// $variable .= "&opcion=eliminarCalendario"; // va a frontera
				// $variable .= "&id_calendario=" . $_REQUEST ['id_calendario'];
				break;
			
			case 'plantillaCalendarioLista' :
				$variable = "&pagina=" . $this->pagina;
				$variable .= "&opcion=crearPlantilla"; // va a frontera
				break;
			default :
				;
				break;
		}
		
		if (isset ( $variable, $etiqueta )) {
			$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
			$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
			?>
<a id="borrar" href="<?php echo $variable?>"><?php echo $etiqueta?></a>
<?php
		}
	}
	function enlaceDuplicar() {
		$url = 'index.php?data';
		switch ($this->pagina) {
			// En la página que se presenta la lista de todos calendarios
			case 'calendarioLista' :
				// $variable .= "&opcion=duplicarCalendario"; // va a frontera
				
				break;
			
			// En la página que se presenta un solo calendario con todas sus características
			case 'calendario' :
				$etiqueta = 'Duplicar Calendario';
				$variable = "&pagina=calendario";
				$variable .= "&opcion=duplicarCalendario"; // va a frontera
				$variable .= "&id_calendario=" . $_REQUEST ['id_calendario'];
				$variable .= "&permiso=" . $_REQUEST ['permiso'];
				if (stristr ( $_REQUEST ['permiso'], 'p' ) || stristr ( $_REQUEST ['permiso'], 'w' )) {
					;
				} else {
					unset ( $etiqueta );
				}
				break;
			case 'plantillaCalendarioLista' :
				$variable = "&pagina=" . $this->pagina;
				$variable .= "&opcion=crearPlantilla"; // va a frontera
				break;
			default :
				;
				break;
		}
		
		if (isset ( $variable, $etiqueta )) {
			$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
			$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
			?>
<a id="copiar" href="<?php echo $variable?>"><?php echo $etiqueta?></a>
<?php
		}
	}
	
	function enlacePermisos() {
		$url = 'index.php?data';
		switch ($this->pagina) {
			// En la página que se presenta la lista de todos calendarios
			case 'calendarioLista' :
				// $variable .= "&opcion=duplicarCalendario"; // va a frontera
	
				break;
					
				// En la página que se presenta un solo calendario con todas sus características
			case 'calendario' :
				$etiqueta = 'Editar permisos del calendario';
				$variable = "&pagina=calendario";
				$variable .= "&opcion=editarPermiso"; // va a frontera
				$variable .= "&id_calendario=" . $_REQUEST ['id_calendario'];
				$variable .= "&permiso=" . $_REQUEST ['permiso'];
				if (stristr ( $_REQUEST ['permiso'], 'p' ) || stristr ( $_REQUEST ['permiso'], 'w' )) {
					;
				} else {
					unset ( $etiqueta );
				}
				break;
			case 'plantilla' :
				$etiqueta = 'Editar permisos de la Plantilla';
				$variable = "&pagina=" . $this->pagina;				
				$variable .= "&opcion=editarPermiso"; // va a frontera
				$variable .= "&id_plantilla=" . $_REQUEST ['id_plantilla'];
				break;
			default :
				;
				break;
		}
	
		if (isset ( $variable, $etiqueta )) {
			$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
			$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
			?>
	<a id=permisosObjeto href="<?php echo $variable?>"><?php echo $etiqueta?></a>
	<?php
			}
		}
	/**
	 * inicio del Gestor de Calendario
	 */
	function enlaceInicio() {
		$url = 'index.php?data';
		$variable = "&pagina=calendarioLista";
		$variable .= "&opcion=mostrarCalendario"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		return $variable;
	}
	function enlaceSalir() {
		$url = 'index.php?data';
		$variable = "&pagina=index";
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		return $variable;
	}
	function enlaceParametro() {
		$url = 'index.php?data';
		$variable = "&pagina=parametroLista";
		$variable .= "&opcion=mostrarParametro"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		return $variable;
	}
	function enlacePermiso() {
		$url = 'index.php?data';
		$variable = "&pagina=permisoCalendario";
		$variable .= "&opcion=crearPermisos"; // va a frontera
		$variable .= "&id_usuario=" . $_REQUEST ['id_usuario'];
		$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variable, $url );
		
		return $variable;
	}
}
$miMenu = new menuHorizontal ();
$miMenu->armarMenuHorizontal ();
?>



