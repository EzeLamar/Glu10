import { Component, OnInit} from '@angular/core';
import { Marcador } from 'src/app/classes/marcador.class';
import {MatSnackBar} from '@angular/material';
import {MatDialog, MatDialogRef} from '@angular/material';
import { MapaEditarComponent } from './mapa-editar.component';

@Component({
  selector: 'app-maps',
  templateUrl: './maps.component.html',
  styleUrls: ['./maps.component.css']
})
export class MapsComponent implements OnInit {


  marcadores: Marcador[] = [];
  public lat = -38.710566;
  public lng = -62.263447;

  constructor(public snackBar: MatSnackBar,
              public dialog: MatDialog ) {
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

    // const nuevoMarcador = new Marcador(-38.710566, -62.263447);

    // this.marcadores.push(nuevoMarcador);

  }

  ngOnInit() {
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
