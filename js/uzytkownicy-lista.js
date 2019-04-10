function resetuj(x,y,z){
    var potwierdzenie = confirm("Czy chcesz zresetować hasło użytkownikowi o id "+x+" ?");
    if (potwierdzenie == true){
        window.location.assign("/pl/admin/uzytkownicy-reset?id="+x);
    }
}
function edytuj(x){
    window.location.assign("/pl/admin/uzytkownicy-edytuj?id="+x);
}