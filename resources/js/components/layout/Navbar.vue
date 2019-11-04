<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <router-link class="navbar-brand" to="/home">Navbar</router-link>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <router-link class="nav-link" to="/home">Home <span class="sr-only">(current)</span></router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/tickets">Tickets</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/tenants">Tenants</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/managers">Managers</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/owners">Owners</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/users">Users</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/roles">Roles</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/example">Example</router-link>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown link
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li> -->
      </ul>
    </div>
  </nav>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('Navbar Mounted');
  }
}
</script>
