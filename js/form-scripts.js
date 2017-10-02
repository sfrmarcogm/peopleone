$('#tipo').change(function() {
	var cual = $('#tipo').val();
	if(cual.length>0){
		var url = 'api/incidencias/' + cual;
		$('#div_id').addClass('no-ver');
		$('#div_item').addClass('no-ver');
		$('#div_catalogo').addClass('no-ver');
		$('#div_area').addClass('no-ver');
		if((cual=="borrar") || (cual=="editar")){ 
			$('#div_id').removeClass('no-ver'); 
		}
		if(cual=="lista"){ 
			$('#div_item').removeClass('no-ver'); 
		}
		if((cual=="crear") || (cual=="editar")) {
			$('#div_item').removeClass('no-ver');
			$('#div_catalogo').removeClass('no-ver');
			$('#div_area').removeClass('no-ver');
		}
	} else {
		var url = "";
	}
    $('#url_').val(url);
});

$("#apiForm").validator().on("submit", function (event) {
    if (event.isDefaultPrevented()) {
        //valida errores
        //formError();
        //submitMSG(false, "Completa los campos");
		$("#msgError").removeClass().addClass('h3 text-center text-danger').text('Completa los campos');
    } else {
        //env+io correcto
        event.preventDefault();
        var tipo_ = "POST";
		var cual = $('#tipo').val();
		var $form = $(this);

		if(cual=="lista"){ tipo_="GET"; }
		var $inputs = $form.find("input, select, button, textarea");
		var serializedData = $form.serialize();
		var datos = "item=" + $("#item").val() + "&catalogo=" + $("#catalogo").val() + "&area="+ $("#area").val() + "&id="+ $("#id_").val();

		$inputs.prop("disabled", true);
		$('#resultado').text();
		$("#form-submit").text("Espera...");

		request = $.ajax({
			url: 'api/incidencias/' + cual,
			type: tipo_,
			dataType: 'text',
			data: datos,
			success: function (data) {
				$('#resultado').val(data);
				$("#msgError").removeClass().addClass('h3 text-center text-success').text("Success");
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   //console.log(textStatus, errorThrown);
				$("#msgError").removeClass().addClass('h3 text-center text-danger').text(errorThrown);
			}
		});
		$inputs.prop("disabled", false);
		$("#form-submit").text("Enviar");
    }
});
