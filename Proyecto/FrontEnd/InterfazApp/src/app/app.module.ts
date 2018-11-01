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
import { FooterComponent } from './components/footer/footer.component';
import { ToolbarComponent } from './components/toolbar/toolbar.component';
import { CalificacionComponent } from './components/calificacion/calificacion.component';
import { RestauranteComponent } from './components/restaurante/restaurante.component';
import { AboutComponent } from './components/about/about.component';
import { RestaurantesComponent } from './components/restaurantes/restaurantes.component';

@NgModule({
  declarations: [
    AppComponent,
    MapsComponent,
    MenuCirculoComponent,
    LoginComponent,
    FooterComponent,
    ToolbarComponent,
    CalificacionComponent,
    RestauranteComponent,
    AboutComponent,
    RestaurantesComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
  //  MatSelectModule,
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
