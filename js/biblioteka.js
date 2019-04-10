function zarezerwuj(x,y){
    var potwierdzenie = confirm("Czy chcesz zarezerwowac książkę?");
    if (potwierdzenie == true){
        window.location.assign("/pl/biblioteka/rezerwuj?id_k="+x+"&id_u="+y);
    }
}
function edytuj(x){
    window.location.assign("/pl/biblioteka/edytuj?id_k="+x);
}