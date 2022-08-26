
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Vue = require('vue');

window.events = new Vue();

window.flash = function(message) {
    window.events.$emit('flash', message);
};

Vue.component(
    'flash',
    require('./components/Flash.vue')
);

Vue.component(
    'loader',
    require('./components/Loader.vue')
);

Vue.filter('capitalize',
    function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
    });

window.moment = require('moment');

const app = new Vue({
    el: '#app'
});
