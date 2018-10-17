import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';


@Component({
  selector: 'app-maps',
  templateUrl: './maps.component.html',
  styleUrls: ['./maps.component.css']
})
export class MapsComponent implements OnInit {

  marcadores: Marcador[] = [];

  // lat: number = 51.678418;
  // lng: number = 7.809007;
  lat: number = -38.71536909404415;
  lng: number = -62.26685779187005;

  constructor() { 
    if(localStorage.getItem('marcadores')){  //si existe
      this.marcadores = JSON.parse( localStorage.getItem('marcadores') );
    } 
    else{
      const nuevoMarcador = new Marcador(this.lat,this.lng );
      this.marcadores.push(nuevoMarcador);
    }
  }

  ngOnInit() {
  }

  agregarMarcador( evento ){
    const coords: { lat: number, lng: number } = evento.coords;

    const nuevoMarcador = new Marcador(coords.lat, coords.lng);
    nuevoMarcador.titulo = "Hola";
    nuevoMarcador.desc= "este es un lugar copado";
     

    this.marcadores.push(nuevoMarcador);
    this.guardaMarcadores();

  }

  guardaMarcadores(){
    localStorage.setItem('marcadores',JSON.stringify(this.marcadores));
  }

}
