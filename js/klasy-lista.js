function dodaj(x){
    window.location.assign("/pl/admin/klasy-dodaj?id="+x);
}
function edytuj(x){
    window.location.assign("/pl/admin/klasy-edytuj?id="+x);
}
function usun(x){
    var potwierdzenie = confirm("Czy chcesz usunąć klasę o id "+x+" ?");
    if (potwierdzenie == true){
        window.location.assign("/pl/admin/klasy-usun?id="+x);
    }
}
function dodajusun(x,y,z){
    window.location.assign("/pl/admin/klasy-dodajusun?id_k="+x+"&id_u="+y+"&d="+z);
}