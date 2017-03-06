function _(x) {
	return document.getElementById(x);
}

function login(){
	var e = _("email").value;
	var p = _("password").value;
	if(e == "" || p == ""){
		alert("Fill out all of the form data");
	} else {
		_("login_btn").style.display = "none";
		var ajax = ajaxObj("POST", "login.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText == "login_failed"){
					alert("Login unsuccessful, please try again.");
					_("login_btn").style.display = "block";
				} else {
					window.location = "user.php?u="+ajax.responseText;
				}
	        }
        }
        ajax.send("email="+e+"&password="+p);
	}
}

function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}

function checkUserName() {
	var u = _("username").value;
	if(u != ""){
		var ajax = ajaxObj("POST", "register.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            alert(ajax.responseText);
	        }
        }
        ajax.send("usernamecheck="+u);
	} else {
		alert('Please Enter Username');
	}
}

function register() {
	var u = _("username").value;
	var e = _("email").value;
	var p1 = _("password").value;
	var p2 = _("password_confirm").value;
	var c = _("country").value;
	var g = _("sex").value;
	if(u == "" || e == "" || p1 == "" || p2 == "" || c == "" || g == ""){
		alert("Fill out all of the form data");
	} else if(p1 != p2){
		alert("Your password fields do not match");
	} else {
		var ajax = ajaxObj("POST", "register.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "signup_success"){
					alert(ajax.responseText);
				} else {
					window.scrollTo(0,0);
					alert("Register Successful You Can Now Login");
				}
	        }
        }
        ajax.send("username="+u+"&email="+e+"&password="+p1+"&country="+c+"&gender="+g);
	}
}
