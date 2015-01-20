
<?/**
$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$item = 'index';
$items [$item] ['nombre'] = 'Inicio';
$items [$item] ['enlace'] = true; // El <li> es un enlace directo
$items [$item] ['icono'] = 'ui-icon-circle-triangle-e'; // El <li> es un enlace directo
$enlace = 'pagina=index';
$items [$item] ['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $enlace, $directorio );
// Atributos generales para la lista
$atributos ['id'] = 'menuLateral';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"] = true;
$atributos ['items'] = $items;
$atributos ['menu'] = true;
echo $this->miFormulario->listaNoOrdenada ( $atributos );
*/ 
?>
