$(document).ready(function() {
  
	$('#reportTab a.button').click( function(e){
		var checked = new Array();
		var post_id = $('#reportTab input#post_id').val()
		$("#reportTab input:checked").each( function( index ){
			checked[ index ] = $(this).attr('ID');
		});
		$.post("/wp-content/themes/wp-foundation/ajax.php", { "func": "saveReports", "post_id": post_id, "reported": checked }, function( data) {
			if(data.error == 0)
			{
				alert('Tack för rapporteringen!');
			}
		}, "json");
	});

});