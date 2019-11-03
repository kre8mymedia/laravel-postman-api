require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;

Vue.config.productionTip = false

Vue.use(VueRouter);

const Home = Vue.component('Home', require('./views/Home.vue').default);
const Tickets = Vue.component('Ticket', require('./components/Tickets.vue').default);
const ExampleComponent = Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Navbar', require('./components/layout/Navbar.vue').default);
const App = Vue.component('App', require('./App.vue').default);
const Users = Vue.component('User', require('./components/Users.vue').default);
const Roles = Vue.component('Role', require('./components/Roles.vue').default);

const routes = [
    { path: '/home', component: Home },
    { path: '/tickets', component: Tickets },
    { path: '/users', component: Users },
    { path: '/roles', component: Roles },
    { path: '/example', component: ExampleComponent },
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