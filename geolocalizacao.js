$(document).ready(function() {
    $.get('//ip-api.com/json', function(data) {
        if(data.city!=null){$("#city").val(data.city);$("#city").parent().show();}
        if(data.region!=null){$("#stateselect").val(data.region);$("#stateselect").parent().show();}
    });
    $("#postcode").after("<span class='btn btn-block btn-xs btn-primary btn-geo'>Preencher endereço automaticamente</span>");
	function showPosition(position) {
	    $.get('//maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+','+position.coords.longitude, function(data) {
	        if(data.results[0].address_components[2].long_name!=null){$("#city").val(data.results[0].address_components[2].long_name);$("#city").parent().show();}
	        if(data.results[0].address_components[4].short_name!=null){$("#stateselect").val(data.results[0].address_components[4].short_name);$("#stateselect").parent().show();}
	        if(data.results[0].address_components[0].long_name!=null){$("#address1").val(data.results[0].address_components[0].long_name);$("#address1").parent().show();}
	        if(data.results[0].address_components[1].long_name!=null){$("#address2").val(data.results[0].address_components[1].long_name);$("#address2").parent().show();}
	        $("#phonenumber").parent().show();
	        $(".btn-geo").remove();
	    });
	}
    $(".btn-geo").click(function(event) {
	    if (navigator.geolocation) {
	        navigator.geolocation.getCurrentPosition(showPosition);
	        $(".btn-geo").text('Carregando...');
	    } else {
	        alert = "Geolocalização não suportada pelo browser.";
	    }
    });
});
