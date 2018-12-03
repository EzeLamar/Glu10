import { Component, Input,OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';
import { Router } from '@angular/router';
import { AuthService } from "../../services/auth.service";
import { RestaurantesComponent } from "../restaurantes/restaurantes.component";


@Component({
  selector: 'app-restaurante',
  templateUrl: './restaurante.component.html',
  styleUrls: ['./restaurante.component.css']
})
export class RestauranteComponent implements OnInit {

  @Input() restaurante:Marcador= new Marcador(1,1);
  esAdmin = false;

  constructor( private router: Router,
               private listaRestaurantes: RestaurantesComponent
             ) {

                  //this.esAdmin = this.auth0.esAdministrador();   
                  this.esAdmin=this.listaRestaurantes.esAdministrador;
                }

  ngOnInit() {
  }

  obtenerCalificacion(){
    return this.restaurante.calificacion.toFixed(2);
  }

  //para ruteos
  moverseACalificar(id: number){
  this.router.navigate(['/restaurante',id,'calificar']);
  }

  moverseAVerMas(id: number){
  this.router.navigate(['/restaurante',id,'info']);
  }

}