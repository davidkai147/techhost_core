/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap'

import Vue from 'vue'
import router from './router'
import store from './store'

window.Vue = Vue

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/Home.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
import App from './App.vue'

import './plugins/chartjs';
import './plugins/vue-cookies';


// import VeeValidate
import va_ja from './locale/validate_jp'
import { ValidationProvider, ValidationObserver, localize } from 'vee-validate/dist/vee-validate.full'

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
// Vue.use(VeeValidate, { classNames: 'text-bold', fieldsBagName: 'text-bold' })
localize('ja', va_ja)
// End VeeValidate

import ElementUI from 'element-ui'
import el_ja from 'element-ui/lib/locale/lang/ja'

Vue.use(ElementUI, { locale: el_ja })

Vue.config.productionTip = false
Vue.component('App', App)
Vue.filter('formatPrice', function (value) {
    if (!value) return value;
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
})

import {Cookie} from './util/cookie'

// This callback runs before every route change, including on page load.
router.beforeEach((to, from, next) => {
    // This goes through the matched routes from last to first, finding the closest route with a title.
    // eg. if we have /some/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title)
    // If a route with a title was found, set the document (page) title to that value.
    if (nearestWithTitle) document.title = `TechHost CMS | ${nearestWithTitle.meta.title}`

    if (!to.name) {
        next({name: 'PageNotFound'})
    }

    if (to.name === 'SignIn' && Cookie.findByName('access_token')) {
        const name = Cookie.findByName('type') === 'SUPER_ADMIN' ? 'AdminDashboard' : 'AccountDashboard'
        next({name: name})
    } else {
        next()
    }
})

const app = new Vue({
    el: '#app',
    router,
    store,
})
