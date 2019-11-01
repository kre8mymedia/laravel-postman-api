require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;

Vue.config.productionTip = false

Vue.use(VueRouter);

const Home = Vue.component('Home', require('./views/Home.vue').default);
const Tickets = Vue.component('Test', require('./components/Tickets.vue').default);
const ExampleComponent = Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Navbar', require('./components/layout/Navbar.vue').default);
const App = Vue.component('App', require('./App.vue').default);
const Users = Vue.component('User', require('./components/Users.vue').default);

const routes = [
    { path: '/home', component: Home },
    { path: '/example', component: ExampleComponent },
    { path: '/tickets', component: Tickets },
    { path: '/users', component: Users },
]

const router = new VueRouter({
    mode: 'history',
    routes
})

new Vue({
    router,
    render: h => h(
        App,
    )
}).$mount('#app')