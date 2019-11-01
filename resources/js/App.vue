<template>
    <div>
      <Navbar />
      <router-view />
    </div>
</template>

<script>
  import Home from './views/Home';
  import ExampleComponent from './components/ExampleComponent';
  import Navbar from './components/layout/Navbar';
  import Tickets from './components/Tickets';
  import Users from './components/Users';
  import Roles from './components/Roles';

  export default {
    name: 'app',
    components: {
      Home,
      Navbar,
      ExampleComponent,
      Tickets,
      Users,
      Roles
    },

    mounted() {
      console.log('APP Component mounted.')
    }
  }
</script>
