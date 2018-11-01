import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';

//serivcio importado
import { MarcadoresService } from "../../services/marcadores.service";


@Component({
  selector: 'app-maps',
  templateUrl: './maps.component.html',
  styleUrls: ['./maps.component.css']
})
export class MapsComponent implements OnInit {

  //para pruebas
  lat: number = -38.71536909404415;
  lng: number = -62.26685779187005;

  //atributos de la clase
  marcadores: Marcador[] = [];
  error = 'todo bien';

  constructor( private marcadorService: MarcadoresService ) { 
  // Geolocacion del usuario
  if ('geolocation' in navigator) {
    /* la geolocalización está disponible */
    console.log('Puedo obtener Ubicacion');
    this.findMe();
  } else {
    /* la geolocalización NO está disponible */
    console.log('Error al obtener Ubicacion');
  }

  // Mediante la funcion cargo los marcadores que anteriormente habia seleccionado en mi navegador
  if ( localStorage.getItem('marcadores')) {
    this.marcadores = JSON.parse(localStorage.getItem('marcadores'));
  }

  // this.marcadores.push(nuevoMarcador);
  }

  ngOnInit() {
    this.obtenerMarcadoresServer();
    console.log(this.error);
    // this.obtenerPrueba();
  }

  setearLatLng(position ) {
    this.lat = position.coords.latitude;
    this.lng = position.coords.longitude;
  }

  // Codigo para pedir la ubicacion del usuario al navegador y mostrar su ubicacion en el mapa
  findMe() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        console.log(position);
        this.setearLatLng(position);
        // this.marcadores.push(new Marcador( position.coords.latitude, position.coords.longitude));
            });
    } else {
      alert( 'Geolocation is not supported by this browser.' );
    }
  }


  agregarMarcador( evento ) {
    const coords: { lat: number, lng: number } = evento.coords;

    console.log( 'lat:' + coords.lat + ', long:'  + coords.lng);
    const nuevoMarcador = new Marcador(coords.lat, coords.lng);
    nuevoMarcador.nombre = 'Hola';
    nuevoMarcador.descripcion = 'este es un lugar copado';
    nuevoMarcador.calificacion = 5;

    this.marcadores.push(nuevoMarcador);

    this.guardaMarcadores();

  }

  guardaMarcadores() {
    localStorage.setItem('marcadores', JSON.stringify(this.marcadores));
  }

  obtenerMarcadoresServer(): void{
    console.log("esperando por los marcadores");

    this.marcadorService.getAll().subscribe(
      ( res: Marcador[] ) => {
        this.marcadores = res;
        console.log("se obtuvieron los marcadores");
      },
      ( err ) => {
        this.error = err;   // VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia. 
      }
    );
  }

  obtenerPrueba(): void {
    this.marcadorService.getPrueba().subscribe(
      ( res: string ) => {
        console.log("Component:" + res);
      },
      ( err ) => {
        this.error = err;   // VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia. 
      }
    );
  }

  markerIconUbicacionActual() {
    return ('../../../assets/my_location.svg');
  }

  markerIconRestaurante(calificacion:number) {
    if(calificacion>=4)
      return ('../../../assets/verde.png'); 
    
    else if (calificacion>=2)
      return ('../../../assets/amarillo.png'); 
    else 
      return ('../../../assets/rojo.png');    
  }

  moverseACalificar(id: number){
    console.log("calificar "+id);
  }

  moverseAVerMas(id: number){
    console.log("verMas "+id);
  }

}
