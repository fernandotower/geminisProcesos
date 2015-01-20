<?php
$indice=0;



$estilo[$indice++]="code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
$estilo[$indice++]="cdn.datatables.net/plug-ins/a5734b29083/integration/jqueryui/dataTables.jqueryui.css";

//$estilo[$indice++]="code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
//$estilo[$indice++]="cdn.datatables.net/plug-ins/a5734b29083/integration/jqueryui/dataTables.jqueryui.css";
//$estilo[$indice++]="datatables.css";
$estilo[$indice++]="datatables_themeroller.css";
//$estilo[$indice++]="datatables.min.css";

$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($unBloque["grupo"]==""){
        $rutaBloque.="/blocks/".$unBloque["nombre"];
}else{
        $rutaBloque.="/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"];
}

foreach ($estilo as $nombre){
        echo "<link rel='stylesheet' type='text/css' href='".$rutaBloque."/css/".$nombre."'>\n";

}
?>
