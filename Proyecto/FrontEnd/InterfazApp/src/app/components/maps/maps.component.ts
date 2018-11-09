import {MatSnackBar} from '@angular/material';
import {MatDialog, MatDialogRef} from '@angular/material';
import { MapaEditarComponent } from './mapa-editar.component';
import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';

// servicio importado
import { MarcadoresService } from '../../services/marcadores.service';

@Component({
  selector: 'app-maps',
  templateUrl: './maps.component.html',
  styleUrls: ['./maps.component.css']
})
export class MapsComponent implements OnInit {

  // para pruebas
  lat: number = -38.71536909404415;
  lng: number = -62.26685779187005;

  // Para star-rating
  public starCount = 5;
  public starColor = 'accent';

  // atributos de la clase
  marcadores: Marcador[] = [];
  error = 'todo bien';

  constructor(  private snackBar: MatSnackBar,
                private dialog: MatDialog,
                private marcadorService: MarcadoresService ) {
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
    nuevoMarcador.calificacion = 3;

    this.marcadores.push(nuevoMarcador);

    this.guardaMarcadores();

  }

  guardaMarcadores() {
    localStorage.setItem('marcadores', JSON.stringify(this.marcadores));
  }

  obtenerMarcadoresServer(): void {
    console.log("esperando por los marcadores");

    this.marcadorService.getAll().subscribe(
      ( res: Marcador[] ) => {
        this.marcadores = res;
        console.log("se obtuvieron los marcadores");
        console.log("obtengo marcadores cerca..");
        this.marcadorService.setMarcadoresCerca(this.lat, this.lng);
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
  onRatingChanged(rating) {
    console.log(rating);
    this.rating = rating;
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
        this.marcadores.push(new Marcador( position.coords.latitude, position.coords.longitude));
            });
    } else {
      alert( 'Geolocation is not supported by this browser.' );
    }
  }

  agregarMarcador( evento ) {

    const coords: { lat: number, lng: number } = evento.coords;

    this.marcadores.push( new Marcador( coords.lat, coords.lng ));

    this.guardarStorage();
    this.snackBar.open('Marcador agregado', 'Cerrar', { duration: 1000 });

    // console.log(evento);
  }

  guardarStorage() {

    localStorage.setItem('marcadores', JSON.stringify (this.marcadores));
  }

  borrarMarcador( i: number ) {
      this.marcadores.splice( i , 1);
      this.guardarStorage();
      this.snackBar.open('Marcador borrado', 'Cerrar', { duration: 1000 });
  }

  editarMarcador(marcador: Marcador ) {

    const dialogRef = this.dialog.open(MapaEditarComponent, {
      width: '250px',
      data: {titulo: marcador.titulo , desc: marcador.desc }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      console.log(result);
      if ( !result ) {
        return;
      }

      marcador.titulo = result.titulo;
      marcador.desc = result.desc;

      this.guardarStorage();
      this.snackBar.open('Marcador actualizado', 'Cerrar', { duration: 1000 });
    });
  }

}
