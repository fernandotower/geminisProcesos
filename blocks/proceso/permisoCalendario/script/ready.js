<?php
$_REQUEST ['tiempo'] = time ();
$this->site = $this->miConfigurador->getVariableConfiguracion ( "site" );

?>
var table = $('#example').DataTable({
	  "jQueryUI": true,
	  "language": {				
		  "url":  "<?php echo $this->host.$this->site.'/plugin/scripts/javascript/datatables.esp.txt';?>"     																	    
		}  
	});

var table = $('#example1').DataTable({
	  "jQueryUI": true,
	  "language": {				
		  "url":  "<?php echo $this->host.$this->site.'/plugin/scripts/javascript/datatables.esp.txt';?>"  																    
		}  
	});

// Asociar el widget de validación al formulario
$("#login").validationEngine({
	promptPosition : "centerRight",
	scroll : false
});

$('#usuario').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#login').submit();
    }
});

$('#clave').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#login').submit();
    }
});


$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});

