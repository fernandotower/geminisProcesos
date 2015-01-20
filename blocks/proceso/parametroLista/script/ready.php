<?php
$_REQUEST ['tiempo'] = time ();
$this->site = $this->miConfigurador->getVariableConfiguracion ( "site" );

?>

setTimeout(function() {
    $('#divMensaje').hide( "drop", { direction: "up" }, "slow" );
}, 3000); // <-- time in milliseconds


      
        
// Asociar el widget de validación al formulario
     $("#plantillaCalendarioLista").validationEngine({
            promptPosition : "centerRight", 
            scroll: false,
            autoHidePrompt: true,
            autoHideDelay: 2000
	         });
	

        $(function() {
            $("#plantillaCalendarioLista").submit(function() {
                $resultado=$("#plantillaCalendarioLista").validationEngine("validate");
                   
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });


 $('#example').DataTable({
        	  "jQueryUI": true,
        	  "language": {				
					"url":  "<?php echo $this->host.$this->site.'/plugin/scripts/javascript/datatables.esp.txt';?>"   																	    
  				}        	               
        	});
        	        	
 
 
  $(function() {
$( "#tabs" ).tabs();
});

  
  $( "#<?php echo $this->campoSeguro('anos');?>"  ).spinner(
  	{
  		min:0, 
  		max:60}
  	);
  	  $( "#<?php echo $this->campoSeguro('meses');?>"  ).spinner(
  	{
  		min:0, 
  		max:60}
  	);
  	  	  $( "#<?php echo $this->campoSeguro('dias');?>"  ).spinner(
  	{
  		min:0, 
  		max:60}
  	);
  	  	  $( "#<?php echo $this->campoSeguro('horas');?>"  ).spinner(
  	{
  		min:0, 
  		max:60}
  	);
  	  	  $( "#<?php echo $this->campoSeguro('minutos');?>"  ).spinner(
  	{
  		min:0, 
  		max:60}
  	);
  	  	  $( "#<?php echo $this->campoSeguro('segundos');?>"  ).spinner(
  	{
  		min:0, 
  		max:60}
  	);
  	