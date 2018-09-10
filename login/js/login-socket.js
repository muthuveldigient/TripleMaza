var wsUri = WEB_SOCKET_URL;
var output;
window.addEventListener("load", init, false);
function init()  {
	connectWebSocket();
}

function connectWebSocket()  {
	websocket = new WebSocket(wsUri);
	websocket.onopen = function(evt) { onOpen(evt) };
	websocket.onclose = function(evt) { onClose(evt) };
	websocket.onmessage = function(evt) {onMessage(evt) };
	websocket.onerror = function(evt) { onError(evt) };
}

function onOpen(evt)  {
	writeToScreen("CONNECTED");
	console.log("CONNECTED");
}

function onClose(evt)  {
	writeToScreen("DISCONNECTED");
	networkConnection();
	console.log("DISCONNECTED");
}
var servetDateTime='';
function onMessage(evt)  {
	var json = JSON.parse(evt.data);
	console.log(json);
	if(json.action=="LoginResponse"){
		if(json.errorCode ==100){
			console.log(json.userData);
			$.post("processlogin.php", json.userData, function (response) {
				if (response == 1) {
					//doSend(response.message);
					window.location.href = "web/index.php";
				} else {
					$("#log_msg").show().html('Username or Password invalid');
					$("#log_loader").hide();
					$("#submit_btn").show();
					clear_form();
					//doSend(response.message);
				}
				setTimeout(function () {
					$("#log_msg").hide();
				}, 4000);

			}).fail(function(xhr, status, error) {
					$("#log_msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
					location.reload();
				if (xhr.readyState == 4) {
					// HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
					//$("#msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
				} else if (xhr.readyState == 0) {
					// Network error (i.e. connection refused, access denied due to CORS, etc.)
					$("#log_msg").show().html('Trying to connect to network.Please wait').removeClass('alert-success').addClass('alert-danger');
					location.reload();

				}
				// error handling
			});
			return false;
			//success
		}
		if(json.errorCode ==101){
			//error
			$("#log_msg").show().html('User already logged in');
			$("#log_loader").hide();
			$("#submit_btn").show();
			clear_form();
			return false;
		}
		if(json.errorCode ==102){
			//error
			$("#log_msg").show().html('Invalid Login');
			$("#log_loader").hide();
			$("#submit_btn").show();
			clear_form();
			return false;
		}
		if(json.errorCode ==103){
			//error
			$("#log_msg").show().html('Invalid Request');
			$("#log_loader").hide();
			$("#submit_btn").show();
			clear_form();
			return false;
		}				
	}
	
	if(json.action=='LogoutResponse'){
	console.log('Logout=>',json);
		if(json.errorCode ==100){
			window.location.href = "logout.php";
		}
	}
	
	if(json.action=="AckResponse"){
		//console.log(json.action);
	}
}

function onError(evt) {
	console.log(evt);
}

function doSend(message) {
	websocket.send(message);
	console.log("SENT: " + message);
}

//var count=30;
function writeToScreen(message) {
	if(message=="DISCONNECTED"){
		setTimeout(function(){ init(); networkConnection(); }, 1000);
	}
	if(message=="CONNECTED"){
		//alert("CONNECTED");
	}
}

function activeWS(){
	var msg = {action: "AckRequest"};
	doSend(JSON.stringify(msg));
	
}

var count = 10;

function startCounting( ) {
	setInterval("countDown()", 1000);
}

function countDown( ) {
    count=count-1;
	if (count <= 0) {
		location.reload();
		return;
	}
	$("#timer").html(count);
}

var connection =true;
function networkConnection(){
	if(connection==true){
		connection=false
		$('#confirmation').show();
		startCounting();
	}
}


function logout(user_id,session_id){
	var logout = '{"action": "LogoutRequest","serviceType": "wintcService","userId":"'+user_id+'","sessionId":"'+session_id+'"}';
	doSend(logout)
}

	

