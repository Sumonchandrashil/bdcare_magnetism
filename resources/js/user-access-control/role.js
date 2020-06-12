require('./app-assets');

window.Vue = require('vue');

Vue.component('manage-role', require('./ManageRole.vue'));

const app = new Vue({
    el: '#app'
});
