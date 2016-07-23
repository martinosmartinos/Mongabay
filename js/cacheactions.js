// JavaScript Document

jQuery(document).ready(function( $ ) {
  var userlevel = readCookie('mongabay-user-level')
  if (userlevel=='2') { $('body').addClass('mongabay-subscriber'); }
  else if (userlevel=='1') { $('body').addClass('mongabay-user'); }
  else $('body').addClass('mongabay-logout');
});


function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
  }
 