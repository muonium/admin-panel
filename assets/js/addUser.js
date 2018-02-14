window.onload = function() {
    window.addEventListener("keydown", function(event) {
        switch(event.keyCode) {
            case 13:
                sendRegisterRequest();
                break;
        }
    });
}

var hex2chars = function(input) {
    var output = '';
    input = input.replace(/^(0x)?/g, '');
    input = input.replace(/[^A-Fa-f0-9]/g, '');
    input = input.split('');
    for(var i = 0; i < input.length; i+=2) {
        output += String.fromCharCode(parseInt(input[i]+''+input[i+1], 16));
    }
    return output;
}

var mui_hash = function(input) {
    // Hash a string in sha384 thanks to sha512.js, convert it in base64 thanks to base64.js and urlencode it
    return encodeURIComponent(base64.encode(hex2chars(sha384(input)), true));
}


var randomString = function (length, chars) {
    var mask = '';
    if (chars.indexOf('a') > -1) mask += 'abcdefghijklmn!@#$%^&*()_+-={}[]";\'<>?,opqrstuvwxyz';
    if (chars.indexOf('A') > -1) mask += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (chars.indexOf('#') > -1) mask += '0123456789';
    if (chars.indexOf('!') > -1) mask += '~`!@#$%^&*()_+-={}[]";\'<>?,';
    var result = '';
    for (var i = length; i > 0; --i) result += mask[Math.floor(Math.random() * mask.length)];
    return result;
}

var cek = {};
cek.encrypt = function(key, y){
	//crypto parameters
	var a = sjcl.random.randomWords(4); //authentication data - 128 bits
	var i = sjcl.random.randomWords(4); //initialization vector - 128 bits
	var s = sjcl.random.randomWords(4); //salt - 128 bits
	//encrypt it
	var key = sjcl.encrypt(y, key, {mode:'gcm', iv:i, salt:s, iter:7000, ks:256, adata:a, ts:128});
	var key = base64.encode(key); //don't store a Json in mongoDB...
	return key;
}
cek.gen = function(y){
	var t = randomString(32, '#A!');
	return cek.encrypt(t, y); //encrypt it
}


var sendRegisterRequest = function()
{
    console.log("Start register");

    var field_mail = document.querySelector("#field_mail").value;
    var field_login = document.querySelector("#field_login").value;
    var field_password = document.querySelector("#field_pass").value;
    var field_passphrase = document.querySelector("#field_passphrase").value;
    var doubleAuth = document.querySelector("#doubleAuth").checked;

    var returnArea = document.querySelector("#return p");

    if(field_mail.length < 6 || field_login.length < 2) {
        returnArea.innerHTML = "Mail or login too short.";
    }
    else if(field_password.length < 6 || field_passphrase.length < 6) {
        returnArea.innerHTML = "Pass too short.";
	}
    else {

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./addUserResult.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function()
        {
            if(xhr.status == 200 && xhr.readyState == 4)
            {
                console.log(xhr.responseText);
                if(xhr.responseText.length > 2)
                {
                    if(xhr.responseText.substr(0, 3) == "ok@") {
                        returnArea.innerHTML = xhr.responseText.substr(3);
                        return false;
                    }
                    else {
                        returnArea.innerHTML = xhr.responseText;
                    }
                }
            }
        }

		var cek_xhr = cek.gen(field_passphrase);
        xhr.send("mail="+field_mail+"&login="+field_login+"&pass="+mui_hash(field_password)+"&doubleAuth="+doubleAuth+"&cek="+encodeURIComponent(cek_xhr));
    }
}
