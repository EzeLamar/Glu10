import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { MapsComponent } from './components/maps/maps.component';

//mapas
import { AgmCoreModule } from '@agm/core';

// Animacion
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

// MaterialDesign
import { MaterialModule } from './material.module';
import { MenuCirculoComponent } from './components/menu-circulo/menu-circulo.component';

//comunicación con el Servidor PHP
import { HttpClientModule } from '@angular/common/http';

//servicios
import { AuthService } from './services/auth.service';
import { LoginComponent } from './components/login/login.component';

//rutas
import { APP_ROUTING } from './app.routes';

@NgModule({
  declarations: [
    AppComponent,
    MapsComponent,
    MenuCirculoComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    APP_ROUTING,
    MaterialModule,
    HttpClientModule,
    AgmCoreModule.forRoot({
      apiKey: 'AIzaSyA-HXVa2jtkGfKtIJwisxgC46RaWqC1xuI'
    })
  ],
  providers: [
    AuthService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
