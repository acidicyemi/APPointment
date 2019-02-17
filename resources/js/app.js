import 'vuetify/dist/vuetify.min.css'

import 'babel-polyfill';

window.Vue = require('vue');
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import StoreData from './store/index';
import { routes } from './routers/routes';
import Vuex from 'vuex'
import 'es6-promise/auto'

Vue.use(Vuex)
Vue.use(Vuetify) 
Vue.use(VueRouter)


const store = new Vuex.Store(StoreData)
const router = new VueRouter({
  routes,
  mode: 'history',
})


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('appointment-layout', require('./components/Layout.vue').default);
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store,
});
