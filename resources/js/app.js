/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 /
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

*/


require('./bootstrap');

// 1. Comment out this following line:
// window.Vue = require('vue');

// 2. Add below the above commented-out line:
import Vue from 'vue';
import VueRouter from "vue-router";

window.Vue = Vue;
Vue.use(VueRouter);

import Form from "./utilities/Form";
window.Form = Form;

import router from './routes';

//Import Vue Filter
require('./filter');

//Import progressbar
require('./progressbar');

//Setup custom events
require('./customEvents');

//Import Sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast

/* ... SNIP ... */

// 3. Update the new Vue intance at the bottom of the file.
new Vue({
    el: '#app',
    router,
});
