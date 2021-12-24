countdownTimer();
move = (someValue, fromtxt, totxt) => {
	var length = fromtxt.length;
	var maxlength = fromtxt.getAttribute(maxlength);
	if(length == maxlength){
		document.getElementById(totxt).focus();
		// var x = document.getElementById(totxt).value;
		// var lastfieldsid = $("input[type=text]:last").attr("id");
			// console.log(lastfieldsid);
			
		var OTPs = [];
		$(".pin").each(function(){
			 //console.log($(this).val());
			 OTPs.push($(this).val());
		});
		//var newDob = DoB.slice(0, -1);
		var newDob = OTPs.join('');
		var pin = document.getElementById("txt5").value = newDob;
		console.log(pin);
		if(pin.length == 4){
			goCountdownTimer(pin);
		}
	}
}
var seconds = 180; // seconds for HTML
var foo; // variable for clearInterval() function

function redirect() {
	var id = document.getElementById("myId").value;

	//endpoint to make otp expire
	var url = "/otp/expires/" + id;
    document.location.href = url;
}

function updateSecs() {
    document.getElementById("seconds").innerHTML = seconds;
    seconds--;
    if (seconds == -1) {
        clearInterval(foo);
        redirect();
    }
}

function countdownTimer() {
    foo = setInterval(function () {
        updateSecs()
    }, 1000);
}

var goSecond = 1; 
var act; 

function goRedirect(pin) {
	var id = pin;
	//endpoint to make verify otp
	var url = "/otp/verify/" + id;
    document.location.href = url;
}

function goUpdateSecs(pin) {
    goSecond--;
    if (goSecond == -1) {
        clearInterval(foo);
        goRedirect(pin);
    }
}

function goCountdownTimer(pin) {
    act = setInterval(function () {
        goUpdateSecs(pin)
    }, 1000);
}