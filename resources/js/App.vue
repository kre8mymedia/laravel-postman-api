<template>
    <div class="container">
      <router-link to="/dashboard">Home</router-link>
      <router-link to="/example">Example</router-link>
      <router-link to="/test">Test</router-link>
      <router-view />
    </div>
</template>

<script>
  // import Home from './views/Home';
  import ExampleComponent from './components/ExampleComponent';
  import TestComponent from './components/TestComponent';

  export default {
    name: 'app',
    components: {
      // Home,
      ExampleComponent,
      TestComponent
    },

    mounted() {
      console.log('APP Component mounted.')
    }
  }
</script>
