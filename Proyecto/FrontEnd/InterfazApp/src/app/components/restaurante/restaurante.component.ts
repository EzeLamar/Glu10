import { Component, Input,OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';
import { Router } from '@angular/router';


@Component({
  selector: 'app-restaurante',
  templateUrl: './restaurante.component.html',
  styleUrls: ['./restaurante.component.css']
})
export class RestauranteComponent implements OnInit {

  @Input() restaurante:Marcador= new Marcador(1,1);

  constructor( private router: Router ) { }

  ngOnInit() {
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

}