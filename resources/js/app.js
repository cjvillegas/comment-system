require('./bootstrap');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const files = require.context("./", true, /\.vue$/i);
files.keys().map((key) =>
    Vue.component(key.split("/").pop().split(".")[0], files(key).default)
);

import Vue from "vue"
import API from "./api/index.js"

// services
import ED from "./services/EventDispatcher"

import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import "element-ui/lib/theme-chalk/display.css";
import locale from "element-ui/lib/locale/lang/en";

Vue.use(ElementUI, { locale, size: "small" });

// Instancetiate the API global variable. Holder of all api request
Vue.prototype.$API = API
Vue.prototype.$ED = new ED()

// Create the Vue app instance
const app = new Vue({
    el: "#app"
})
