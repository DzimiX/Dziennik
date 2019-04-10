$(function() {
  $("#submit_login").click(function() {
	var username = $("input#username").val();
	if (username == "") {
	   $('.errormess').html('<b style="margin-left:25px;color:red;">Wprowadź email!</b>');	
       return false;
    }
	var password = $("input#password").val();
	if (password == "") {
	   $('.errormess').html('<b style="margin-left:25px;color:red;">Wprowadź hasło!</b>');	
       return false;
	}
	var dataString = 'username='+ username + '&password=' + password;
	$.ajax({
      type: "POST",
      url: 'logowanie.php',
      data: dataString,
	  dataType: "html",
      success: function(data) {
	  if (data == 0) {
	  	$('.errormess').html('<b style="margin-left:25px;color:red;">Złe dane, pucuj się.</b>');
		} else {
			$('.errormess').html('<b style="margin-left:25px;color:green;">Zalogowano, przekierowanie!</b>');	
			document.location.href = '/pl/panel';	
		}
      }
     });
    return false;
	});
});