<template>
    <div>
      <Navbar />
      <router-view />
    </div>
</template>

<script>
  // import Home from './views/Home';
  import ExampleComponent from './components/ExampleComponent';
  import TestComponent from './components/TestComponent';
  import Navbar from './components/layout/Navbar';

  export default {
    name: 'app',
    components: {
      // Home,
      Navbar,
      ExampleComponent,
      TestComponent
    },

    mounted() {
      console.log('APP Component mounted.')
    }
  }
</script>
