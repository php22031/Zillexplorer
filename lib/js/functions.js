
// Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com


/////////////////////////////////////////////////////////////

function delete_cookie( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

/////////////////////////////////////////////////////////////

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

/////////////////////////////////////////////////////////////

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}


/////////////////////////////////////////////////////////////

function check_pass(doc_id_alert, doc_id_pass1, doc_id_pass2, pass) {
	
    var pass1 = document.getElementById(doc_id_pass1);
    var pass2 = document.getElementById(doc_id_pass2);
    var message = document.getElementById(doc_id_alert);
    
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    
    // Check length / compare values
	if ( document.getElementById(doc_id_pass1).value.length < 12 || document.getElementById(doc_id_pass1).value.length > 40 ) {
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Password must be between 12 and 40 characters long."
        return false;
	}
   else if (pass1.value != pass2.value) {
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match"
        return false;
    }
   else if (pass1.value == pass2.value){
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Password OK"
        return true;
   }

}

/////////////////////////////////////////////////////////////

