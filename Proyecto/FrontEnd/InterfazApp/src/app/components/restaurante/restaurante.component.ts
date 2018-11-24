import { Component, Input,OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';
import { Router } from '@angular/router';
import { AuthService } from "../../services/auth.service";


@Component({
  selector: 'app-restaurante',
  templateUrl: './restaurante.component.html',
  styleUrls: ['./restaurante.component.css']
})
export class RestauranteComponent implements OnInit {

  @Input() restaurante:Marcador= new Marcador(1,1);
  esAdmin = false;

  constructor( private router: Router,
               private auth0: AuthService
             ) {

                  this.esAdmin = this.auth0.esAdministrador();   

                }

  ngOnInit() {
  }

  //para ruteos
  moverseACalificar(id: number){
  this.router.navigate(['/restaurante',id,'calificar']);
  }

  moverseAVerMas(id: number){
  this.router.navigate(['/restaurante',id,'info']);
  }

}