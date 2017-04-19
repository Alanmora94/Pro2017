import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import { AppComponent } from './app.component';
import { LogeoComponent } from './logeo/logeo.component';
import { PagNoEncontradaComponent } from './pag-no-encontrada/pag-no-encontrada.component';
import { RouterModule,Routes} from '@angular/router';

// crear array de ruta
//

// crear array de ruta
//
//const rutasDeNavegacion : Routes= [{path:'/login',component:LoginComponent}];
//const rutasDeNavegacion : Routes= [{path:'login',component:LoginComponent} {path:'#pag-no-encontrada',component:pag-no-encontrada.component} ];
//
const rutasDeNavegacion : Routes= [{path:'logeo',component:LogeoComponent}, {path:'',redirectTo:'/logeo', pathMatch: 'full'},{path:'**',component:PagNoEncontradaComponent}];
//const rutasDeNavegacion : Routes= [{path:'login',component:LoginComponent}, {path:'',redirectTo:'/login', pathMatch: 'full'},{path:'**',component:PaginaNoEncontradaComponent}];
//const rutasDeNavegacion : Routes= [{path:'login',component:LoginComponent}];




@NgModule({
  declarations: [
    AppComponent,
    LogeoComponent,
    PagNoEncontradaComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    RouterModule.forRoot(rutasDeNavegacion)
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
