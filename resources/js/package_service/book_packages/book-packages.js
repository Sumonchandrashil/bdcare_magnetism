require('./../../vue-assets.js');
Vue.component('book-packages-list', require('./List.vue').default);

const app = new Vue({
	el: '#erp-app'
});
