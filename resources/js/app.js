require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;

Vue.config.productionTip = false

Vue.use(VueRouter);

// App Components
const ExampleComponent = Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const App = Vue.component('App', require('./App.vue').default);
const Home = Vue.component('Home', require('./views/Home.vue').default);
const Users = Vue.component('User', require('./components/Users.vue').default);

// Layout Components
Vue.component('Navbar', require('./components/layout/Navbar.vue').default);

// Role Components
const Roles = Vue.component('Role', require('./components/Roles.vue').default);
const Tenants = Vue.component('Tenant', require('./components/Tenants.vue').default);
const Managers = Vue.component('Manager', require('./components/Managers.vue').default);
const Owners = Vue.component('Owner', require('./components/Owners.vue').default);

// Object Components
const Tickets = Vue.component('Ticket', require('./components/Tickets.vue').default);
const Properties = Vue.component('Property', require('./components/Properties.vue').default);

const routes = [
    { path: '/home', component: Home },
    { path: '/tickets', component: Tickets },
    { path: '/properties', component: Properties },
    { path: '/tenants', component: Tenants },
    { path: '/managers', component: Managers },
    { path: '/owners', component: Owners },
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