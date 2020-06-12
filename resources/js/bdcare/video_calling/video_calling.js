require('./../../vue-assets.js');
Vue.component('list', require('./VideoCallingList.vue').default);

const app = new Vue({
	el: '#erp-app'
});
