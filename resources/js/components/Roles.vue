<template>
    <div class="container">
        <h2>ROLE Component</h2>

        <!-- COMPONENT FORM --> 
        <form @submit.prevent="addRole" class="mb-3">
            <!-- <div class="form-group">
                <input type="text" class="form-control" placeholder="Role User ID" v-model="role.user_id">
            </div> -->
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Role Name" v-model="role.name">
            </div>

            <!-- SELECT ROLE USER --> 
            <div class="form-group">
                <label for="exampleFormControlSelect1">Select User</label>
                <select v-model="role.user_id" class="form-control" id="exampleFormControlSelect1">
                    <option disabled value="">Please select one</option>
                    <option v-for="user in users" :key="user.id" :value="user.id" >
                        {{user.name}}
                    </option>
                </select>
            </div>

            <!-- <div class="form-group">
                <label for="role_user_id">Select User</label>
                <select id="role_user_id" class="form-control" v-model="role.user_id">
                    <option v-for="user in users" v-bind:key="user.id">{{user.name}}</option>
                </select>
            </div> -->


            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <!-- END COMPONENT FORM -->

        <!-- PAGINATION -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
                    <a @click="fetchRoles(pagination.prev_page_url)" class="page-link">Previous</a>
                </li>

                <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
                    <a @click="fetchRoles(pagination.next_page_url)" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
        <!-- END PAGINATION -->

        <!-- CARDS -->
        <div class="card card-body mb-2" v-for="role in roles" v-bind:key="role.id">
            <h3>{{ role.name }}</h3>
            <p>{{ role.user_name + " | " + role.user_email}}</p>
            <hr>
            <button @click="editRole(role)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteRole(role.id)" class="btn btn-danger">Delete</button>
        </div>
        <!-- END CARDS -->
    </div>
</template>

<script>
    import User from './Users.vue';
    export default {
        data() {
            return {
                role: {
                    id: '',
                    user_id: '',
                    name: '',
                },
                user: {
                    id: '',
                    name: '',
                    email: '',
                },
                roles: [],
                users: [],
                role_id: '',
                pagination: {},
                edit: false,
            }
        },

        components: {
            User,
        },

        created() {
            this.fetchRoles();
            this.fetchUsers();
        },

        methods: {
            fetchRoles(page_url) {
                let vm = this;
                page_url = page_url || 'api/roles';
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Roles log to console
                    console.log(res.data);
                    // this fetches role data
                    this.roles = res.data;
                    // Get this vue's structure pagination?
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            fetchUsers(page_url) {
                let vm = this;
                page_url = page_url || 'api/users'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Users log to console
                    console.log(res.data);
                    // this fetches user data
                    this.users = res.data;
                    // Get this vue's structure pagination?
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            getUsers() {
                console.log(this.users);
            },

            makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };

            this.pagination = pagination;
            },

            deleteRole(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/role/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Role Removed')
                        this.fetchRoles();
                    })
                    .catch(err => console.log(err));
                }
            },

            addRole() {
                if(this.edit === false) {
                    // Add
                    fetch('api/role', {
                        method: 'post',
                        body: JSON.stringify(this.role),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.role.name = '';
						this.role.user_id = '';
                        alert('Role Added');
                        this.fetchRoles();
                    })
                    .catch(err =>console.log(err));
                } else {
                    // Update
                    fetch('api/role', {
                        method: 'put',
                        body: JSON.stringify(this.role),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.role.name = '';
						this.role.user_id = '';
                        alert('Role Updated');
                        this.fetchRoles();
                    })
                    .catch(err =>console.log(err));
                }
            },

            editRole(role) {
                this.edit = true;
                this.role.id = role.id;
                this.role.role_id = role.id;
                this.role.name = role.name;
                this.role.user_id = role.user_id;
            }
        },

        mounted() {
            console.log('Role Component mounted.')
        }
    }
</script>
