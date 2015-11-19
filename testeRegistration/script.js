$(document).ready(loadDocument);

function loadDocument() {
	 $.ajax({
			  type: "POST",
			  url: "registration.php",
			  data: $("registerForm").serialize(),
			  
			  success: function(msg) {
					$("#result").html(msg.message);
			  },
			  error: function(){
				  $("#result").html("There was an error submitting the form. Please try again.");
		}
		
		echo "You've successfully registered! You can now login.";
			}
	} else {
			// not all information is set return false
			//die('{status:0,txt:"You haven\'t filled in each field"}');
			echo "You haven't filled in all the fields!";
	}
	 
}
