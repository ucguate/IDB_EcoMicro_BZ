// getting local storage
var gToken = '', gEmail = '', gUser = {};
gEmail = localStorage.getItem("email");
gToken = localStorage.getItem("token");
gUser = JSON.parse(localStorage.getItem('user')); 


$(document).ready(function () {

	console.log('token: '+gToken);
	getProfile();
	console.log(gToken);

});

// listeners
$('#loginBtn').click(function () {
    let email = $('#emailInput').val();
    let pass = $('#passInput').val();

    login(email, pass);
});

$('#logoutBtn').click(function () {
	logOut();
});

// ------------------------------------------------------------

// functions
function login(email, pass){
	console.log('logging in');

	var data = "action=login&username=" + email + "&password=" + pass;

    $.post(apiURL, data, function (data) {

		window.location.href = '/home.html';

		console.log('success');
		console.log(data);
		
		token = data.JWT;
		localStorage.setItem("token", token);
		localStorage.setItem("email", email);
		localStorage.setItem("user", JSON.stringify(data));
		gToken = token;
		gEmail = email;
		gUser = JSON.parse(data);
        		
		// if logged in getProfile 
		getProfile();
	
	}).fail(function (xhr, status, error) {

		token = ''; //not logged in token = none
		localStorage.setItem('token', token);
		alert("Login Failed ");

	});

}

function getProfile(){
    var url = apiURL + "?action=list&object=users&email=" + gEmail;
    $.ajax({
		url: url,
		type: "GET",
		success: function (data, status, xhr) {

			console.log('ALERT');
			console.log(data);
			buildForm();

        },
		error: function (xhr, ajaxOptions, thrownError) {
            console.log('Error');
        },
		beforeSend: function (request) { // Set JWT header
			request.setRequestHeader('Authorization', 'Bearer ' + gToken);
        }
    });
}

function logOut(){
	localStorage.clear();
	window.location.href = '/index.html';
}