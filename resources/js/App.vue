<template>
    <div class="container">
        <router-link to="/example">Example</router-link>
        <router-link to="/test">Test</router-link>
        <router-view />
    </div>
</template>

<script>
  import ExampleComponent from './components/ExampleComponent';
  import TestComponent from './components/TestComponent';

  export default {
    name: 'app',
    components: {
      ExampleComponent,
      TestComponent
    },

    mounted() {
      console.log('APP Component mounted.')
    }
  }
</script>
