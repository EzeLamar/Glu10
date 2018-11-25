import { Component, OnInit, ViewChild } from '@angular/core';
// sidenav
import {MatSidenav} from '@angular/material/sidenav';
import { Router } from '@angular/router';
// Servicio Autenticacion
import { AuthService } from '../../services/auth.service';
@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.css']
})
export class ToolbarComponent implements OnInit {

  @ViewChild('sidenav') sidenav: MatSidenav;

  perfil: any;
  nombre: string;

  constructor( private router: Router, private auth0: AuthService ) {
    auth0.handleAuthentication();
  }

  actualizarUsuario(){
    if (this.auth0.isAuthenticated()) {
      this.perfil = this.auth0.userProfile;
    }
  }

  ngOnInit() {
  }
  // For auth service purpose
  login() {
    this.auth0.login();
  }
  logout() {
    this.auth0.logout();
    localStorage.clear();
    // this.router.navigate(['/login']); Ya lo realizo en el metodo "logout()" del servicio auth
  }
  // For the menu
  close() {
    this.sidenav.close();
  }
  open() {
    this.sidenav.open();
  }

  moverseALogin(){
    this.sidenav.close();
    this.router.navigate(['/login']);
  }

  moverseAMap() {
    this.sidenav.close();
    this.router.navigate(['/mapa']);
  }

  moverseAAbout() {
    this.sidenav.close();
    this.router.navigate(['/about']);
  }
}

