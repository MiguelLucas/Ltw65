function detectNames(name){
	if(/^([^0-9]*)$/.test(name)){
		return true;
	}else{
		swal("Really? You don't know how to write your name?", "Ranger does not admit this.", "error");
		//swal("Error!", "The name is wrongly introduced!", "error");
		return false;
	}
}

function detectEmail(email){
	if(/\S+@\S+\.\S+/.test(email)){
		return true;
	}else{
		//swal("Error!", "The email is wrongly introduced!", "error");
		swal("Ranger sees everything.", "And now, Ranger sees the email is incorrect.", "error");
		return false;
	}
}

function detectPassword(password){
	if(password.length < 6){
		//swal("Error!", "The password is too short!", "error");
		swal("Ranger does not admit short passwords.", "Your password must be like Ranger's one. Epic.", "error");
		return false;
	} else {
		if (/\d/.test(password) && /[a-zA-Z]/.test(password)) {
			return true;
		} else {
			//swal("Error!", "Password must include at least one number and one letter!", "error");
			swal("Ranger does not admit passwords without at least one number and one letter.", "Your password must be like Ranger's one. Epic.", "error");
			return false;
		}
	}
}

function editUser(idUserToEdit,newFirstName,newLastName,newEmail,newDate,newPassword) {
  $.ajax(
  {
    method: "PUT",
    dataType: "json",
    url: "database/user.php",
    data: {
        action: "edit_user",
		idUser: idUserToEdit,
        firstName: newFirstName,
		lastName: newLastName,
		email: newEmail,
		date: newDate,
		password: newPassword
		},
    success: function() {
      //swal("Your data was successfully edited", ":)", "success")
	  swal("You cannot edit your data. Ranger edits your data.", "And Ranger has already done it, successfully.", "success")
    },
    error: function(data) {
      console.log(data.responseText);
    }
  });
}