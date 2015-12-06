function submitForm(type, id) {
	
	console.log('entrei');
	console.log(type);
	var fd = new FormData(document.getElementById("fileUpload"));
	fd.append("label", type);
	fd.append("id", id);

	console.log(fd);
	/*if(type == "Event")
		fd.append("label", "events/");
	else if(type == "User")
		fd.append("label", "users/");
	else return false;*/
	$.ajax({
	  url: "database/imageUpload.php",
	  type: "POST",
	  dataType: "JSON",
	  data: fd,
	  enctype: 'multipart/form-data',
	  processData: false,  // tell jQuery not to process the data
	  contentType: false,   // tell jQuery not to set contentType
	  success: (function( data ) {
		console.log("PHP Output:");
		var img = $('.userImage');
		
		

		console.log(data);
		//var src = '<?php echo getUserPhoto(); ?>';

		//console.log(src);
		//img.attr('src', src);
	}),
	error: (function (response, textStatus, jqXHR){
		console.log(jqXHR);
		
	})
	
	})
	return false;
}