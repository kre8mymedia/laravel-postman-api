require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;

Vue.config.productionTip = false

Vue.use(VueRouter);

const TestComponent = Vue.component('Test', require('./components/TestComponent.vue').default);
const ExampleComponent = Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const App = Vue.component('App', require('./App.vue').default);

const routes = [
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
        App
    )
}).$mount('#app')