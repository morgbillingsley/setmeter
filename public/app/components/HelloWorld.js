import Domhut from '../Domhut.js';

export default class HelloWorld extends Domhut {
    markup() {
        return this.getTemplate("HelloWorld.html");
    }

    styles() {
        return {
            color: 'navy'
        }
    }
}