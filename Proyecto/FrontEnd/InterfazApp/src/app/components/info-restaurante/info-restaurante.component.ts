import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from "@angular/router";
import { Marcador } from "../../classes/marcador.class";

// Para Ruteo
import { Router } from '@angular/router';

@Component({
  selector: 'app-info-restaurante',
  templateUrl: './info-restaurante.component.html',
  styleUrls: ['./info-restaurante.component.css']
})
export class InfoRestauranteComponent implements OnInit {

  marcadorActual: Marcador = new Marcador(1,1);

  constructor( private activatedRoute: ActivatedRoute,
               private router: Router){
    let idActual:number;
    let marcadoresLocalStorage: Marcador[];
    this.activatedRoute.params.subscribe( params =>{
      idActual = Number(params.id);
    });

    //obtengo el marcador correspondinete a ese id..
    if ( localStorage.getItem('marcadores')) {
      marcadoresLocalStorage = JSON.parse(localStorage.getItem('marcadores'));
    }
    console.log("localstorage tenia esto",marcadoresLocalStorage);
    console.log("TOMO EL PRIMERO",marcadoresLocalStorage[0].id);
    


    //busco el marcador a partir de su id
    let encontre = false;
    let pos=0;
    let posBuscada=0;
    for( pos=0; (pos<marcadoresLocalStorage.length)&&(!encontre); pos++ )
      if( marcadoresLocalStorage[pos].id === idActual ){
        encontre = true;
        posBuscada = pos;
      }
    if( encontre ){
      console.log("encontre", marcadoresLocalStorage[posBuscada]);
      this.marcadorActual.id = marcadoresLocalStorage[posBuscada].id;
      this.marcadorActual.nombre = marcadoresLocalStorage[posBuscada].nombre;
      this.marcadorActual.calificacion = marcadoresLocalStorage[posBuscada].calificacion;
      this.marcadorActual.descripcion = marcadoresLocalStorage[posBuscada].descripcion;
      this.marcadorActual.tieneMenuCel = marcadoresLocalStorage[posBuscada].tieneMenuCel;
      this.marcadorActual.imagen = marcadoresLocalStorage[posBuscada].imagen;
      this.marcadorActual.cp = marcadoresLocalStorage[posBuscada].cp;
    }

  }

  // para ruteos
  moverseACalificar(id: number) {
    this.router.navigate(['/restaurante', id, 'calificar']);
  }
  moverseAMapa() {
    this.router.navigate(['/mapa']);
  }

  ngOnInit() {
  }

}
