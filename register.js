document.getElementById('registration').addEventListener("submit", register);

function register()
{
	event.preventDefault();
	var fname = document.getElementById('fname').value;
	var lname = document.getElementById('lname').value;
	var email = document.getElementById('email').value;
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	var user_type = document.getElementById('user_type').value;

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
	console.log("helo");

		if (this.readyState == 4 && this.status == 200) 
		{
	console.log("hiiiiiiii");
			
			var response = this.responseText;
			document.getElementById('alert').innerHTML = response;
			document.getElementById("alert").style.display = "block";
			
		}
	};
	xhttp.open("POST", "ajax_register.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("fname="+fname+"&lname="+lname+"&email="+email+"&username="+username+"&password="+password+"&usertype="+user_type);
}

