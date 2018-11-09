import { Component, Input,OnInit } from '@angular/core';
import { Marcador } from '../../classes/marcador.class';


@Component({
  selector: 'app-restaurante',
  templateUrl: './restaurante.component.html',
  styleUrls: ['./restaurante.component.css']
})
export class RestauranteComponent implements OnInit {

  @Input() restaurante:Marcador= new Marcador(1,1);

  constructor() { }

  ngOnInit() {
  }

}