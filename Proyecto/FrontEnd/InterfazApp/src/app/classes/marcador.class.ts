export class Marcador {
    public id: number;
    public latitud: number;
    public longitud: number;
    
    public nombre = "Sin Titulo";
    public descripcion = "Sin Descripción";
    public calificacion = -1;
    public tieneMenuCel : boolean;
   
    constructor (lat: number, lng: number) {
        this.latitud = lat;
        this.longitud = lng;
    }
}