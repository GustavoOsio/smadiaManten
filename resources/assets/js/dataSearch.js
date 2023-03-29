class dataSearch {
    constructor(data) {
        this.data = data;
    }
    resp(fun) {
        const elm = $(this.data.selector);
        let elmRes;
        let elmP = this.data.selector.split(" ");
        for (let index = 0; index < elm.length; index++) {
            try {
                let element = elm[index];
                element =
                    element.nodeName != elmP[0].trim().toUpperCase()
                        ? dataSearch.table(element, this.data)
                        : element;
                elmRes = dataSearch.addSearchElm(element, this.data);
                if(elmRes!=false){
                    element.querySelector(elmP[elmP.length-1].trim().toLowerCase()).appendChild(elmRes);
                }
            } catch (error) {
                throw error;
            } finally {
                fun instanceof Function === true ? fun(elmRes) : "";
            }
        }
    }
    static ignore(ign, th) {
        let ft = false;
        if (ign != false) {
            if (ign.hasOwnProperty("text")) {
                const tS =
                    ign.text instanceof Array === true ? ign.text : [ign.text];
                ft = tS.indexOf(th.textContent) != -1 ? true : false;
            }
            if (ign.hasOwnProperty("class")) {
                const tS =
                    ign.class instanceof Array === true ? ign.class : [ign.class];
                for (const key in ign.class) {
                    if (ign.class.hasOwnProperty(key)) {
                        const class_ = ign.class[key];
                        if(th.classList.contains(class_)){
                            return true;
                        }
                        ft=false;
                    }
                }
            }
            if (ign.hasOwnProperty("attr")) {
            }
            return ft;
        } else {
            return ft;
        }
    }
    static condition(cond, th, dataElm) {
        let resp = dataElm;

        for (const key in cond) {
            if (cond.hasOwnProperty(key)) {
                const elmCond = cond[key];
                const co =
                    elmCond instanceof Array === true ? elmCond : [elmCond];
                resp = co.indexOf(th.textContent) != -1 ? key : dataElm;
                //console.log(resp, key,th.textContent);

                if (co.indexOf(th.textContent) != -1) {
                    break;
                }
            }
        }
        return resp;
    }
    static addSearchElm(elm, data) {
        const tr = elm.querySelector(data.referent);
        const th = tr.querySelectorAll(data.parentElm);
        const elmTr = document.createElement(data.referent);

        if (data.hasOwnProperty("attr")) {
            for (const key in data.attr) {
                if (data.attr.hasOwnProperty(key)) {
                    const attr = data.attr[key];
                    elmTr.setAttribute(key, attr);
                }
            }
        }

        for (const key in th) {
            if (th.hasOwnProperty(key)) {
                const elm = th[key];
                const elmTh = document.createElement(data.parentElm);
                let datElm = data.elm;
                elmTr.appendChild(elmTh);
                if (dataSearch.ignore(data.ignore, elm) != true) {
                    const e = dataSearch.condition(data.condition, elm, datElm);
                    const elmAdd =document.createElement(e)
                    elmAdd.setAttribute("data-" + e, elm.textContent);
                    elmTh.appendChild(elmAdd);
                }
            }
        }

        return elmTr;
    }
    static table(elm, data) {
        // Element.matches() polyfill
        let elem = elm;
        let selector =
            data.parent != undefined
                ? data.parent
                : data.selector.split(" ")[0].trim();
        //console.log(selector);

        if (!Element.prototype.matches) {
            Element.prototype.matches =
                Element.prototype.matchesSelector ||
                Element.prototype.mozMatchesSelector ||
                Element.prototype.msMatchesSelector ||
                Element.prototype.oMatchesSelector ||
                Element.prototype.webkitMatchesSelector ||
                function(s) {
                    var matches = (
                            this.document || this.ownerDocument
                        ).querySelectorAll(s),
                        i = matches.length;
                    while (--i >= 0 && matches.item(i) !== this) {}
                    return i > -1;
                };
        }

        // Get the closest matching element
        for (; elem && elem !== document; elem = elem.parentNode) {
            if (elem.matches(selector)) return elem;
        }
        return null;
    }
}
export default dataSearch;
