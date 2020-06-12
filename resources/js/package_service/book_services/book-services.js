require('./../../vue-assets.js');
Vue.component('book-services-list', require('./List.vue').default);

const app = new Vue({
	el: '#erp-app'
});
