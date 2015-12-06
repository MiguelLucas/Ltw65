
function detectFirstName(name){
	if(/^([^0-9]*)$/.test(name)){
		var newdiv = document.getElementById('firstNameErr');
		newdiv.innerHTML = "";
		newdiv.style.display = "none";
		return true;
	}else{
		var newdiv = document.getElementById('firstNameErr');
		newdiv.innerHTML = "Incorrect first name!";
		newdiv.style.display = "block";
		return false;
	}
}

function detectLastName(name){
	if(/^([^0-9]*)$/.test(name)){
		var newdiv = document.getElementById('lastNameErr');
		newdiv.innerHTML = "";
		newdiv.style.display = "none";
		return true;
	}else{
		var newdiv = document.getElementById('lastNameErr');
		newdiv.innerHTML = "Incorrect last name!";
		newdiv.style.display = "block";
		return false;
	}
}
//An email needs at least one symbol, a '@', another symbol, a '.' and finally another symbol 
function detectEmail(email){
	if(/\S+@\S+\.\S+/.test(email)){
		var newdiv = document.getElementById('emailErr');
		newdiv.innerHTML = "";
		newdiv.style.display = "none";
		return true;
	}else{
		var newdiv = document.getElementById('emailErr');
		newdiv.innerHTML = "Email is incorrect!";
		newdiv.style.display = "block";
		return false;
	}
}

function is_leap_year(year){
	return (((year % 4) == 0) && (((year % 100) != 0) || ((year %400) == 0)));
}
function detectDate(day,month,year){
	var birth_date = new Date();
	birth_date.setYear(year);
	birth_date.setMonth(month-1);
	birth_date.setDate(day);
	var today = new Date();
	
	//First, it compares the inputed date with today's date
	if (birth_date > today){
		swal("Error!", "We don't accept people from the future!", "error");
		return false;
	}
	
	//Then, it verifies if the date is correctly introduced
	if (is_leap_year(year)){
		if (month == 2){
			if (day > 29){
				swal("Error!", "The date is wrongly introduced!", "error");
				return false;
			}
		}
	} else {
		if (month == 2){
			if (day > 28){
				swal("Error!", "The date is wrongly introduced!", "error");
				return false;
			}
		}
	}
	if (month == 4 || month == 6 || month == 9 || month == 11){
		if (day > 28){
			swal("Error!", "The date is wrongly introduced!", "error");
			return false;
		}
	}
	return true;
}

function detectPassword(password){
	var newdiv = document.getElementById('passwordErr');
	
	if(password.length < 6){
		newdiv.innerHTML = "Password is too short!";
		newdiv.style.display = "block";
		return false;
	} else {
		if (/\d/.test(password) && /[a-zA-Z]/.test(password)) {
			newdiv.innerHTML = "";
			newdiv.style.display = "none";
			return true;
		} else {
			newdiv.innerHTML = "Password must include at least one number and one letter!";
			newdiv.style.display = "block";
			return false;
		}
	}
}

function validateNewUser(form,firstName,lastName,email,day,month,year,password){
	if (!firstName || !lastName || !email || !day || !month || !year || !password){
		swal("Error!", "You haven't filled all the parameters!", "error");
		return false;
	}
	
	if (!detectFirstName(firstName)){
		swal("Error!", "The first name is wrongly introduced!", "error");
		return false;
	}
	if (!detectLastName(lastName)){
		swal("Error!", "The last name is wrongly introduced!", "error");
		return false;
	}
	if (!detectEmail(email)){
		swal("Error!", "The email is wrongly introduced!", "error");
		return false;
	}
	if (!detectDate(day,month,year)){
		return false;
	}
	if (!detectPassword(password)){
		swal("Error!", "The password is not according to security parameters!", "error");
		return false;
	}
	form.submit();
	return true;
}

function listDays(){
	for (i=1;i<=31;i++){
		var txt1 = "<option value='";
		var txt2 = "'>";
		var txt3 = "</option>";
		var finaltxt = txt1 + i + txt2 + i + txt3;
		document.write(finaltxt);
	}
}

function listYears(){
	for (i=2015;i>=1915;i--){
				var txt1 = "<option value='";
				var txt2 = "'>";
				var txt3 = "</option>";
				var finaltxt = txt1 + i + txt2 + i + txt3;
				document.write(finaltxt);
			}
}
