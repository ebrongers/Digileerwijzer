$("#scholengemeenschap").change(function(){
	
	$( "#scholengemeenschap option:selected" ).each(function() {
		var sID=$( this ).val();
		
		$.getJSON( "/index.php/digileerwijzer/API/getlocaties/"+sID, function( data ) {
			var options = '<option value="" disabled selected>Selecteer een locatie...</option>';
			$.each( data, function( key,val ) {
				options += '<option value="' + val.lID + '">' + val.naam + '</option>';
			});
			$("select#locatie").html(options);
		});
				
	});
	
});
				
$("#locatie").change(function(){
	
	$( "#locatie option:selected" ).each(function() {
		var sID=$( this ).val();
		
		$.getJSON( "/index.php/digileerwijzer/API/getSectiesPerLocatie/"+sID, function( data ) {
			var options = '<option value="" disabled selected>Selecteer een sectie</option>';
			$.each( data, function( key,val ) {
				options += '<option value="' + val.secID + '">' + val.sectienaam + '</option>';
			});
			$("select#sectie").html(options);
		});
				
	});
	
});