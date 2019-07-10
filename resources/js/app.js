/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Import gateova
 */

import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);
 
/**
 * importing vform
 */
import { Form, HasError, AlertError } from 'vform'

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


/**
 * importing sweetalert2
 */

import Swal from 'sweetalert2';
window.Swal = Swal;

 /**
* importing vue-bootstrap
 */

 import BootstrapVue from 'bootstrap-vue'

 Vue.use(BootstrapVue)

 /**
  * import vue-router
  */

 import VueRouter from 'vue-router'

 Vue.use(VueRouter)

 /**
  * define routes
  */
 const routes = [
    { path: '/', name: 'Welcome', component: require('./components/Welcome.vue').default, props: true },
    { path: '/dashboard', name: 'Dashboard', component: require('./components/Dashboard.vue').default, props: true },
    { path: '/expences', component: require('./components/Expences.vue').default  },
    { path: '/orders', component: require('./components/Order.vue').default  }
  ]

  const router = new VueRouter({
    routes // short for `routes: routes`
  })

  /**
   * some custom event
   */

window.Event = new Vue();

/**
 * some custom components
 */
// Vue.component('user-component', require('./components/User.vue').default);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    el: '#app',
});
