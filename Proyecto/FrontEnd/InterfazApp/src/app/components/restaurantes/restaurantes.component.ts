import { Component, OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';
import { MarcadoresService } from "../../services/marcadores.service";
import { AuthService } from "../../services/auth.service";

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
  perfil:any;
  esAdministrador = false;


  constructor( private marcadoresService:MarcadoresService,
               private auth: AuthService ) {
      //deberia obtener los marcadores desde la BD con una consulta al servico...
      this.actualizarRestaurantesCerca();
       // setea el perfil según el servicio de auth0
      this.perfil = this.auth.userProfile;
      if( this.perfil.name == "admin@admin.com" )
        this.esAdministrador = true;
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
