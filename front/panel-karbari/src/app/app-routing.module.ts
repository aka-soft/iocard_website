import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ToolbarComponent } from './toolbar/toolbar.component';
import { ErrorpageComponent } from './errorpage/errorpage.component';


const routes: Routes = [
  {path: '', redirectTo: '/Home', pathMatch: 'full' },
  {
    path: '',
    component: ToolbarComponent,
    children:[
      {path: 'Home', component: HomeComponent},
    ]
  },

  {path: '**', component: ErrorpageComponent}

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
