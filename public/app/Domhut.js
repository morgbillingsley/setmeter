export default class Domhut {
    constructor(elem) {
        this.elem = elem;
        this.state = new EventTarget();
        this.state.addEventListener('ready', (e) => {
            this.elem.innerHTML = e.detail.html;
            let css = this.styles();
            Object.assign(this.elem.style, css);
        });
        if (this.elem !== null) {
            let html = this.markup();
            if (typeof(html) == 'string') {
                let event = new CustomEvent('ready', { detail: { html: html } });
                this.state.dispatchEvent(event);
            }
        }
    }

    getTemplate(path) {
        let request = new XMLHttpRequest();
        request.open('GET', '/app/components/' + path);
        request.overrideMimeType("text/html");

        request.onreadystatechange = () => {
            if (request.readyState == 4 && request.status == 200) {
                let html = request.responseText;
                if (html !== null) {
                    let event = new CustomEvent('ready', { detail: { html: html } });
                    this.state.dispatchEvent(event);
                }
            }
        }

        request.send(null);
    }
}

export class RegisterComponent {
    constructor(tagName, Comp) {
        Array.from(document.getElementsByTagName(tagName)).forEach((elem) => {
            new Comp(elem);
        });
    }
}