import {isArray} from 'util';

export class Menu {
  id: number;
  order: number;
  name: string;
  link: string;
  icon: string;
  badge: string;
  children: Menu[] = [];
  isopen: boolean;

  constructor(menu: Menu = null) {
    if (menu) {
      this.id = menu.id;
      this.name = menu.name;
      this.link = menu.link;
      this.icon = menu.icon;
      this.badge = menu.badge;
    }
  }

  open() {
    this.isopen = true;
  }
  close() {
    // tslint:disable-next-line: prefer-for-of
    for (let i = 0; i < this.children.length; i++) {
      this.children[i].close();
    }
    this.isopen = false;
  }
  toggle() {
    if (this.isopen) { this.close(); } else { this.open(); }
  }
}
export class Convert {
  static toObject<T>(value: any[], type?: new () => T): T[];
  static toObject<T>(value: any, type?: new () => T): T;
  static toObject<T>(value: any | any[], type?: new () => T): T | T[] {
    if (isArray(value)) {
      const array = [];
      // tslint:disable-next-line: prefer-for-of
      for (let i = 0; i < value.length; i++) { array.push(Convert.toObject(value[i], type)); }
      return array;
    } else {
      let obj;
      if (type) { obj = new type; }
      else { obj = {}; }
      // tslint:disable-next-line: forin
      for (const k in value) { obj[k] = value[k]; }
      return obj;
    }
  }
}
