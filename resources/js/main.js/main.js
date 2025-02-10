import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import axios from 'axios';

axios.defaults.baseURL = process.env.MIX_APP_URL || 'http://localhost'; // Set the base URL for API requests


Vue.use(Vuetify);

new Vue({
  vuetify: new Vuetify(),
  render: h => h(App),
}).$mount('#app');
