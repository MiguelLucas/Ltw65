function loadComments(idEventToGet, callback) 
{
  $.ajax(
  {
    method: "GET",
	encoding:"UTF-8",
	dataType: "json",
    url: "database/comment.php",
    data: { action : "comment" , idEvent: idEventToGet},
    success: function(data) {
		// For each object, creates a div .comment and fills each field
		for (var i = 0; i < data.length; i++) {
			if (data[i].parentComment == 0){
				printRootComment(data[i],idEventToGet);
				for (var k = 0; k < data.length;k++) {
					if (data[k].parentComment == data[i].idComment){
						printChildComment(data[k],data[i].idComment);
					}
				}
			} 
		}
		
		if (callback)
			callback();
    },
    error: function(data)
    {
    console.log(data.responseText);
    }
  });
}

function printRootComment(comment,idEvent){
	var userFullName = comment.userFirstName + ' ' + comment.userLastName;
    var comment_container = $('#hidden .comment_item').clone(true);
	comment_container.attr('id','comm_' + comment.idComment);
    comment_container.find(".comment_img").attr("src", 'thisfolder/' + comment.photo);
    comment_container.find(".comment_text").text(comment.content);
    comment_container.find(".publish_date").text(moment(comment.date).format('MMM D, YYYY [at] h:mm A'));
    comment_container.find(".author").text(userFullName);
	comment_container.find(".nested_comment").attr('id','nest_' + comment.idComment);
	comment_container.find(".nested_form").attr('id','nest_form_' + comment.idComment);
	comment_container.find(".postChildComment").attr('id',comment.idComment);
	comment_container.find(".childCommentContent").attr('id',comment.idComment);
	$('#main_comment').append(comment_container);
	comment_container.find(".comment_text").append("<br><a class='link' href='view-event.php?idEvent=" + idEvent + "&replytocom=" + comment.idComment + "'>Reply</a>");
}

function printChildComment(comment,idFather){
	var userFullName = comment.userFirstName + ' ' + comment.userLastName;
    var comment_container = $('#hidden .comment_item').clone(true);
    comment_container.find(".comment_img").attr("src", 'thisfolder/' + comment.photo);
    comment_container.find(".comment_text").text(comment.content);
    comment_container.find(".publish_date").text(moment(comment.date).format('MMM D, YYYY [at] h:mm A'));
    comment_container.find(".author").text(userFullName);
	comment_container.find(".nested_form").remove();
	$('#main_comment #comm_' + idFather + ' #nest_' + idFather).append(comment_container);
	
}
  
function createComment(newIdUser,newIdEvent,newParentComment) {
    $.ajax(
      {
        method: "POST",
        dataType: "json",
        url: "database/comment.php",
        data: {
			action: "create_comment",
			idUser: newIdUser,
			idEvent: newIdEvent,
			parentComment: newParentComment,
			content: (newParentComment == 0) ? $('input[name="content"]').val() : $('input[id="' + newParentComment + '"]').val()
        },
        success: function(data) {
          //if (data.redirect !== undefined && data.redirect)
            window.location.reload();
        },
        error: function(data) {
          console.log(data.responseText);
        }
      });
}

function showForm(id){
	$('#nest_form_' + id).attr('style','display: block');
}

function validateInput(comment){
	if (comment)
		return true;
	else{
		swal("Watch out!", "You didn't write anything!", "warning");
		return false;
	}
}

function removeLinks(){
	$('.link').remove();
}