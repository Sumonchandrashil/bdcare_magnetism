require('./../../../vue-assets.js');
Vue.component('product-area-list', require('./ProductAreaList.vue').default);

const app = new Vue({
	el: '#erp-app'
});
