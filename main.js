jQuery(document).on('submit','#form_insert', function(event){
	event.preventDefault();
	jQuery.ajax({
		url: 'addreport2.php',
		type: 'POST',
		dataType: 'json',
		data: $(this).serialize(),
	})
		.done(function(respuesta){
		console.log(respuesta);
		/*if(!respuesta.error)
		{
			alert('MUY BIEN');
		}
		else{
			alert('NO SE PUDO INGRESAR');
		}*/
	})
		.fail(function(resp){
		console.log(resp.responseText);
	})
		.always(function(){
		console.log("complete");
	})
});