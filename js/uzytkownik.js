var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
var string_length = 8;
var randomstring = '';
for (var i=0; i<string_length; i++) {
    var rnum = Math.floor(Math.random() * chars.length);
    randomstring += chars.substring(rnum,rnum+1);
}

$("input#haslo").val(randomstring);
$(document).on('change', 'input', function() {
    var imie = $("input#imie").val();
    var nazwisko = $("input#nazwisko").val();
    var PESEL = $("input#PESEL").val();
    var login = imie.charAt(0)+nazwisko+PESEL.charAt(4)+PESEL.charAt(5)+PESEL.charAt(2)+PESEL.charAt(3);
    login = login.toLowerCase();
    $("input#login").val(login);
});