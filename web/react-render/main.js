const dom = {
    type: "div",
    props: { id: "hello", class: "foo" },
    children: [
        { type: "h1", children: "Hello" },
        {
            type: "p",
            children: [
                { type: "span", props: { class: "bar" }, children: "World" },
            ],
        },
    ],
};

const root = document.querySelector("body");

let virtualDOM = "";

const react = {
    createDOM(dom) {
        const closingTags = [];

        for (const element in dom) {
            if (element === "type") {
                virtualDOM += `<${dom[element]}>`;
                closingTags.unshift(`</${dom[element]}>`);
            }

            if (element === "props") {
                let index = virtualDOM.lastIndexOf(">");
                let propStr = virtualDOM.slice(0, index);

                for (const prop in dom[element]) {
                    propStr += ` ${prop}="${dom[element][prop]}"`;
                }

                propStr += virtualDOM.slice(index);
                virtualDOM = propStr;
            }

            if (element === "children" && !Array.isArray(dom[element])) {
                virtualDOM += dom[element];
            }

            if (element === "children" && Array.isArray(dom[element])) {
                for (const child of dom[element]) {
                    this.createDOM(child);
                }
            }
        }

        for (const item of closingTags) {
            virtualDOM += item;
        }
    },
    render(dom) {
        this.createDOM(dom);
        root.innerHTML = virtualDOM;
        console.log(virtualDOM);
    },
};

react.render(dom);
