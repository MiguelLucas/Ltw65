function detectNames(name){
	if(/^([^0-9]*)$/.test(name)){
		return true;
	}else{
		swal("Error!", "The name is wrongly introduced!", "error");
		return false;
	}
}

function detectEmail(email){
	if(/\S+@\S+\.\S+/.test(email)){
		return true;
	}else{
		swal("Error!", "The email is wrongly introduced!", "error");
		return false;
	}
}

function detectPassword(password){
	if(password.length < 6){
		swal("Error!", "The password is too short!", "error");
		return false;
	} else {
		if (/\d/.test(password) && /[a-zA-Z]/.test(password)) {
			return true;
		} else {
			swal("Error!", "Password must include at least one number and one letter!", "error");
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
      swal("Your data was successfully edited", ":)", "success")
    },
    error: function(data) {
      console.log(data.responseText);
    }
  });
}