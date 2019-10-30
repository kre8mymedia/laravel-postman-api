require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;

Vue.config.productionTip = false

Vue.use(VueRouter);

// const Home = Vue.component('Home', require('./views/Home.vue').default);
const TestComponent = Vue.component('Test', require('./components/TestComponent.vue').default);
const ExampleComponent = Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Navbar', require('./components/layout/Navbar.vue').default);
const App = Vue.component('App', require('./App.vue').default);

const routes = [
    { path: '/dashboard' },
    { path: '/example', component: ExampleComponent },
    { path: '/test', component: TestComponent },
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