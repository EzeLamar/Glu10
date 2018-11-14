import {MatSnackBar} from '@angular/material';
import {MatDialog, MatDialogRef} from '@angular/material';
import { MapaEditarComponent } from './mapa-editar.component';
import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';
import { Router } from '@angular/router';

//importo al panel de restaurantes cerca para indicarle que se actualice LUEGO de obener los datos.
import { RestaurantesComponent } from "../restaurantes/restaurantes.component";
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
                private marcadorService: MarcadoresService,
                private panelRestaurantesCerca: RestaurantesComponent,
                private router: Router) {
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
    //creo el nuevo marcador con la latitud y longitud donde se hizo click..
    const nuevoMarcador = new Marcador(coords.lat, coords.lng);

    this.marcadores.push(nuevoMarcador);
    //this.marcadorService.marcadoresServer.push(nuevoMarcador);
   
    this.snackBar.open('Marcador agregado', 'Cerrar', { duration: 1000 });
    this.guardaMarcadores();
    this.panelRestaurantesCerca.actualizarRestaurantesCerca();

    //lo agregamos a la base de datos
    this.almacenarMarcadorServer(nuevoMarcador);

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
        this.marcadorService.setUbicacionActual(this.lat, this.lng);
        this.panelRestaurantesCerca.actualizarRestaurantesCerca();
        //this.marcadorService.setMarcadoresCerca(this.lat, this.lng);
      },
      ( err ) => {
        this.error = err;   // VER DSPS: nunca recibe el mensaje de error , por loque nunca cambia. 
      }
    );
  }

  almacenarMarcadorServer(nuevoMarcador: Marcador): void {

    this.marcadorService.addMarcador(nuevoMarcador).subscribe(
      ( res: string ) => {
          console.log(res);
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

   //para ruteos
   moverseACalificar(id: number){
    console.log("calificar "+id);
    this.router.navigate(['/restaurante',id,'calificar']);
  }

  moverseAVerMas(id: number){
    console.log("verMas "+id);
    this.router.navigate(['/restaurante',id,'info']);
  }

  // onRatingChanged(rating) {
  //   console.log(rating);
  //   this.rating = rating;
  // }


  borrarMarcador( id: number ) {
      let encontre = false;
      for(let i=0; i<this.marcadores.length && !encontre; i++)
        if( this.marcadores[i].id == id ){
          encontre=true;
          this.marcadores.splice(i, 1);
        }
      this.guardaMarcadores();
      this.panelRestaurantesCerca.actualizarRestaurantesCerca();
      this.snackBar.open('Marcador borrado', 'Cerrar', { duration: 1000 });
      
  }

  editarMarcador(marcador: Marcador ) {

    const dialogRef = this.dialog.open(MapaEditarComponent, {
      width: '250px',
      data: { 
              id: marcador.id, 
              nombre: marcador.nombre ,
              descripcion: marcador.descripcion,
              latitud : marcador.latitud,
              longitud : marcador.longitud,
              tieneMenuCel : marcador.tieneMenuCel,
              calificacion : marcador.calificacion 
            }
    });
    dialogRef.afterClosed().subscribe(result => {
      console.log('The dialog was closed');
      console.log(result);
      if ( !result ) {
        return;
      }

      marcador.id = result.id;
      marcador.nombre = result.nombre;
      marcador.descripcion = result.descripcion;
      marcador.calificacion = result.calificacion;
      marcador.tieneMenuCel = result.tieneMenuCel;
      this.almacenarMarcadorServer(marcador);


      this.guardaMarcadores();
      this.snackBar.open('Marcador actualizado', 'Cerrar', { duration: 1000 });
    });
  }

}
