var myInput = document.getElementById("psw");
var checkpsw = document.getElementById("Check_psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");
var psw_status = document.getElementById("psw_status");

var IsPasswordValid = true;
var IsValid = false;
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
}


myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}
checkpsw.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

checkpsw.onblur = function() {
    document.getElementById("message").style.display = "none";
}
// When the user starts to type something inside the password field
myInput.onkeyup = function() {

    var lowerCaseLetters = /[a-z]/g;
    let ValidLower = myInput.value.match(lowerCaseLetters);
    let ValidUpper = myInput.value.match(upperCaseLetters);
    let ValidNumbers = myInput.value.match(numbers);
    let ValidLength= myInput.value.length >= 8;
    if(ValidLower) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");

    }


    var upperCaseLetters = /[A-Z]/g;
    if(ValidUpper) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
    } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(ValidNumbers) {
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
    }

    // Validate length
    if(ValidLength) {
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
     IsPasswordValid =  ValidNumbers && ValidUpper && ValidLower && ValidLength;
    
}
checkpsw.onkeyup = function()
{
    let check = myInput.value == checkpsw.value
    if(check) {
        psw_status.classList.remove("invalid");
        psw_status.classList.add("valid");
    } else {
        psw_status.classList.remove("valid");
        psw_status.classList.add("invalid");
    }

    IsValid = IsPasswordValid && check;
}