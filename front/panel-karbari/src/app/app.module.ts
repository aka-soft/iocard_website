import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HomeComponent } from './home/home.component';
import { ToolbarComponent } from './toolbar/toolbar.component';
import { ErrorpageComponent } from './errorpage/errorpage.component';
import {
	MatIconModule,
	MatButtonModule,
	MatSidenavModule,
	MatToolbarModule,
	MatInputModule,
	MatFormFieldModule,
	MatListModule,
	MatChipsModule,
	MatMenuModule,
	MatButtonToggleModule,
	MatCardModule,
	MatTableModule,
	MatCheckboxModule,
	MatDialogModule,
	MatRadioModule,
	MatTooltipModule,
	MatSnackBarModule,
	MatTabsModule,
	MatSelectModule
} from '@angular/material';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { FlexLayoutModule } from '@angular/flex-layout';
import { HttpClientModule, HttpClient, HTTP_INTERCEPTORS } from '@angular/common/http';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    ToolbarComponent,
    ErrorpageComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatIconModule,
    MatButtonModule,
    MatSidenavModule,
    MatToolbarModule,
    MatInputModule,
    MatFormFieldModule,
    MatListModule,
    MatChipsModule,
    MatMenuModule,
    MatButtonToggleModule,
    MatCardModule,
    MatTableModule,
    MatCheckboxModule,
    MatDialogModule,
    MatRadioModule,
    MatTooltipModule,
    MatSnackBarModule,
    MatTabsModule,
    MatSelectModule,
    FormsModule,
    ReactiveFormsModule,
    FlexLayoutModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
