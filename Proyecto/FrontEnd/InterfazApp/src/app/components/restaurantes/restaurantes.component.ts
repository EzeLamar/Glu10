import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';
import { MarcadoresService } from "../../services/marcadores.service";


@Component({
  selector: 'app-restaurantes',
  templateUrl: './restaurantes.component.html',
  styleUrls: ['./restaurantes.component.css']
})
export class RestaurantesComponent implements OnInit {

  mobile: boolean;
  RestaurantesCerca: Marcador[] = [];
  Arr = Array; //Array type captured in a variable 
  num:number = 5; 


  constructor( private marcadoresService:MarcadoresService ) {
      //deberia obtener los marcadores desde la BD con una consulta al servico...
      this.actualizarRestaurantesCerca();
   }

  ngOnInit() {
    if (window.screen.width < 1000)  // 768px portrait
      this.mobile = true;
    else 
      this.mobile= false;
  }

  actualizarRestaurantesCerca(){
    this.RestaurantesCerca= this.marcadoresService.setMarcadoresCerca();
  }

}
