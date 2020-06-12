require('./../../vue-assets.js');
Vue.component('referral-hospital-list', require('./ReferralList.vue').default);

const app = new Vue({
	el: '#erp-app'
});
