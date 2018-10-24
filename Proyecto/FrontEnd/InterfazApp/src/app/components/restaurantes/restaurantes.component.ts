import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';


@Component({
  selector: 'app-restaurantes',
  templateUrl: './restaurantes.component.html',
  styleUrls: ['./restaurantes.component.css']
})
export class RestaurantesComponent implements OnInit {

  topTen: Marcador[] = [];
  Arr = Array; //Array type captured in a variable 
  num:number = 5; 


  constructor() {
      //deberia obtener los marcadores desde la BD con una consulta al servico...
   }

  ngOnInit() {
  }

}
