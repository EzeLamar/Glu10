import { Component, OnInit, ViewChild } from '@angular/core';
// sidenav
import {MatSidenav} from '@angular/material/sidenav';
import { Router } from '@angular/router';

@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.css']
})
export class ToolbarComponent implements OnInit {

  @ViewChild('sidenav') sidenav: MatSidenav;

  constructor( private router:Router ) { }

  ngOnInit() {
  }
  close() {
    this.sidenav.close();
  }
  open() {
    this.sidenav.open();
  }

  moverseAMap(){
    this.sidenav.close();
    this.router.navigate(['/mapa']);
  }

  moverseAAbout(){
    this.sidenav.close();
    this.router.navigate(['/about']);
  }
}