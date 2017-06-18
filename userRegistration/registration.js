window.onsubmit=validateData;




function validateData() {
	var message = ""; //ew
    var phone1 = document.getElementById("reg_phone1").value;
    var phone2 = document.getElementById("reg_phone2").value;
	var phone3 = document.getElementById("reg_phone3").value;
	var zip = document.getElementById("reg_address_zip").value;

	if (!validDigits(phone1, 3) || !validDigits(phone2, 3) || !validDigits(phone3, 4) ) {
		message += "Invalid phone number. Please check your format. \n";
	}
	
	if (zip !="" && (!validDigits(zip, 5)) ) {
		message += "Invalid zip code. Please check your format.";
		
	}
	
	if (message != "") {
		alert(message);
		return false;
	}
	
	
	message = "Do you want to submit the form data?";
	if (window.confirm(message))
            return true;
        else    
            return false;
}

function inBetween(number, min, max) {
	if (number <= max && number >= min) {
		return true;
	}
	
	return false;
}

function validDigits(data, length) {
                if (data.length != length)
                    return false;
                else {
                    for (var idx = 0; idx < data.length; idx++) {
                        if (isNaN(data.charAt(idx)))
                            return false;
                    }
                    return true;
                }
            }