// getting local storage
var gToken = '', gEmail = '';
gEmail = localStorage.getItem("email");
gToken = localStorage.getItem("token");

$(document).ready(function () {

	// getProfile();
	buildForm();
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

	var data = "username=" + email + "&password=" + pass + '&action=login';

    $.post(apiURL, data, function (data) {

		window.location.href = '/home.html';

		console.log('success');
		console.log(data);
		
		token = data.JWT;
		localStorage.setItem("token", token);
		localStorage.setItem("email", email);
		gToken = token;
		gEmail = email
        		
		// if logged in getProfile 
		getProfile();
	
	}).fail(function (xhr, status, error) {

		token = ''; //not logged in token = none
		localStorage.setItem('token', token);
		alert("Login Failed ");
		$('#loginModal').modal('show');
		$('#loginFailedToast').toast('show');

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
	window.location.href = '/';
}