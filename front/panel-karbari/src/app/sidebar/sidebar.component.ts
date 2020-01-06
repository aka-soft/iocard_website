import { Component, OnInit } from '@angular/core';
import {Convert, Menu} from './menu';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {



  menusServise=[
    {
      name: "پیشخوان",
      link: null,
      icon: "",
      active:true,
      children: [
        {
          name: "تست",
          link: ""
        }
      ]
    },
    {
      name: "اخرین سفارشات",
      link: null,
      icon: "",
      children: [
        {
          name: "تست",
          link: ""
        }
      ]
    },

    {
      name: "پشتیبانی",
      link: null,
      icon: "",
      children: [
        {
          name: "تست",
          link: ""
        }
      ]
    },
    {
      name: "همکار شو",
      link: null,
      icon: ""
    },
    {
      name: "مشتریان ثبت شده شما",
      link: null,
      icon: "",
      children: [
        {
          name: "تست",
          link: ""
        }
      ]
    },
    {
      name: "ویرایش اطلاعات کاربری",
      link: null,
      icon: "",
      children: [
        {
          name: "تست",
          link: ""
        }
      ]
    }
  ];
  menus:Menu[]=[];
  constructor() { }

  ngOnInit() {
    this.menus = Convert.toObject(this.menusServise, Menu);
    for (let i = 0; i < this.menus.length; i++) {
      this.menus[i].children = Convert.toObject(this.menus[i].children, Menu);
    }
  }

  sortMenu(menus: Menu[]): Menu[] {
    if(!menus) return;
    return menus.sort((x1,x2) => (x1.order > x2.order ? 1 : (x1.order < x2.order ? -1 : 0)));
  }
  closeAllMenu() {
    for (let i = 0; i < this.menus.length; i++) this.menus[i].close();
  }
  toggleMenu(menu: Menu) {
    if (menu) {
      let isopen = menu.isopen;
      this.closeAllMenu();
      if (!isopen) menu.open();
      else menu.close();
    }
  }
}
