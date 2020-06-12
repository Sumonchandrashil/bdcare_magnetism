require('./../../../vue-assets.js');
Vue.component('list', require('./List.vue').default);

const app = new Vue({
	el: '#erp-app'
});
