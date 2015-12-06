var src;

function submitForm(type, id) {
	console.log(type,id);
	event.preventDefault();
	uploadFile(type, id, function(){
		var imageClass = '.' + type + 'Image';
		var img = $(imageClass);
		src = src.replace('../','');
		img.attr('src', src);
		
	});
	
	return true;

}

function uploadFile(type, id, callback){
	
	var fd = new FormData(document.getElementById("fileUpload"));
	fd.append("label", type);
	fd.append("id", id);

	console.log(fd);
	
	$.ajax({
	  url: "database/imageUpload.php",
	  type: "POST",
	  dataType: "json",
	  data: fd,
	  enctype: 'multipart/form-data',
	  processData: false,  // tell jQuery not to process the data
	  contentType: false,   // tell jQuery not to set contentType
	  success: (function( data ) {
		console.log('a');
		src = data['src'];
		console.log(src);
		if(callback){
			callback();
		}
			
		}),
		error: (function (response, textStatus, jqXHR){
			console.log(jqXHR);
			console.log('b');
			console.log('error image upload');
		
		})
	
	})
	
}
	