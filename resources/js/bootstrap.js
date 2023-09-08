// Load plugins
import helper from "./helper";
import axios from "axios";
import * as Popper from "@popperjs/core";
import dom from "@left4code/tw-starter/dist/js/dom";
import {createIcons, icons} from "lucide";

// Set plugins globally
window.helper = helper;
window.axios = axios;
window.Popper = Popper;
window.$ = dom;

// CSRF token
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}



window.addEventListener('reload-scripts', event => {
    setTimeout(function () {
        createIcons({
            icons,
            "stroke-width": 1.5,
            nameAttr: "data-lucide",
        });
    }, 200)

})


window.addEventListener('console.log', event => {
    console.log(event.detail);
})