/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import '@fortawesome/fontawesome-free/js/all.min.js';

require('./bootstrap');

window.Vue = require('vue');

Vue.config.ignoredElements = ['video-js'];

import Vue2Filters from 'vue2-filters';

Vue.use(Vue2Filters);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('subscribe-button', require('./components/subscribe-button.vue').default);
Vue.component('vote-buttons', require('./components/vote-buttons.vue').default);
Vue.component('comments-box', require('./components/comments-box.vue').default);
require('./components/channel-uploads');



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
